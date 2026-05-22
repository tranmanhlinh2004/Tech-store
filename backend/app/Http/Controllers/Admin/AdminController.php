<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminPermission;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function dashboard()
    {
        $paidOrders = Schema::hasTable('orders')
            ? DB::table('orders')
                ->where('payment_status', 'paid')
                ->whereNotIn('order_status', ['cancelled', 'returned'])
            : null;

        $totalRevenue = $paidOrders ? (float) (clone $paidOrders)->sum('total_amount') : 0;
        $paidOrderCount = $paidOrders ? (int) (clone $paidOrders)->count() : 0;
        $monthlySales = $this->monthlySales();

        return view('admin.dashboard', [
            'stats' => [
                'totalRevenue' => $totalRevenue,
                'monthRevenue' => $paidOrders
                    ? (float) (clone $paidOrders)->whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->sum('total_amount')
                    : 0,
                'todayRevenue' => $paidOrders
                    ? (float) (clone $paidOrders)->whereDate('created_at', today())->sum('total_amount')
                    : 0,
                'orders' => $this->countTable('orders'),
                'pendingOrders' => $this->countTable('orders', fn ($query) => $query->whereIn('order_status', ['pending', 'confirmed', 'processing'])),
                'paidOrders' => $paidOrderCount,
                'averageOrder' => $paidOrderCount > 0 ? $totalRevenue / $paidOrderCount : 0,
                'lowStock' => $this->countTable('products', fn ($query) => $query->where('quantity', '<=', 10)),
                'reviews' => $this->countTable('reviews'),
                'activeCoupons' => $this->countTable('coupons', fn ($query) => $query->where('status', true)),
            ],
            'monthlySales' => $monthlySales,
            'maxMonthlyRevenue' => max(1, (float) $monthlySales->max('revenue')),
            'recentOrders' => $this->recentOrders(),
            'topProducts' => $this->topSellingProducts(),
            'recentActivities' => $this->recentActivities(),
        ]);
    }

    public function users(Request $request)
    {
        $query = DB::table('users')
            ->leftJoin('roles', 'roles.id', '=', 'users.role_id')
            ->select([
                'users.id',
                'users.name',
                'users.email',
                'users.phone',
                'users.status',
                'users.created_at',
                'users.role_id',
                'roles.name as role_name',
                'roles.description as role_description',
            ]);
        $keyword = trim((string) $request->query('q', ''));
        $role = (string) $request->query('role', '');

        if ($keyword !== '') {
            $query->where(function ($query) use ($keyword): void {
                $keyword = '%'.$keyword.'%';
                $query->where('users.name', 'like', $keyword)
                    ->orWhere('users.email', 'like', $keyword)
                    ->orWhere('users.phone', 'like', $keyword)
                    ->orWhere('roles.name', 'like', $keyword);
            });
        }

        if ($role !== '') {
            $query->where('roles.name', $role);
        }

        return view('admin.users.index', [
            'users' => $query->orderByDesc('users.created_at')->limit(200)->get(),
            'roles' => $this->roleOptions(),
            'filters' => [
                'q' => $keyword,
                'role' => $role,
            ],
        ]);
    }

    public function userRoleUpdate(Request $request, int $id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        abort_if(! $user, 404);

        if ((int) $user->id === (int) auth()->id()) {
            return back()->withErrors(['role_id' => 'Không thể tự đổi vai trò hoặc trạng thái của tài khoản đang đăng nhập.']);
        }

        $data = $request->validate([
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'status' => ['required', 'string', Rule::in(['active', 'blocked'])],
        ]);

        DB::table('users')->where('id', $id)->update([
            'role_id' => (int) $data['role_id'],
            'status' => $data['status'],
            'updated_at' => now(),
        ]);

        return back()->with('status', 'Đã cập nhật vai trò tài khoản.');
    }

    public function roles()
    {
        $roles = DB::table('roles')
            ->leftJoin('users', 'users.role_id', '=', 'roles.id')
            ->select([
                'roles.id',
                'roles.name',
                'roles.description',
                'roles.created_at',
                DB::raw('COUNT(users.id) as users_count'),
            ])
            ->groupBy('roles.id', 'roles.name', 'roles.description', 'roles.created_at')
            ->orderByRaw("CASE roles.name WHEN 'admin' THEN 0 WHEN 'manager' THEN 1 WHEN 'staff' THEN 2 WHEN 'customer' THEN 99 ELSE 50 END")
            ->orderBy('roles.name')
            ->get();

        $rolePermissionMap = DB::table('role_permissions')
            ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
            ->select('role_permissions.role_id', 'permissions.name')
            ->orderBy('permissions.name')
            ->get()
            ->groupBy('role_id')
            ->map(fn ($rows) => $rows->pluck('name')->all());

        return view('admin.roles.index', [
            'roles' => $roles,
            'permissionGroups' => $this->permissionGroups(),
            'rolePermissionMap' => $rolePermissionMap,
        ]);
    }

    public function roleStore(Request $request)
    {
        $request->merge([
            'name' => Str::slug((string) $request->input('name'), '_'),
        ]);

        $data = $this->rolePayload($request);
        $roleId = DB::table('roles')->insertGetId([
            'name' => $data['name'],
            'description' => $data['description'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->syncRolePermissions($roleId, $data['permissions']);

        return redirect()->route('admin.roles.index')->with('status', 'Đã tạo vai trò mới.');
    }

    public function roleUpdate(Request $request, int $id)
    {
        $role = DB::table('roles')->where('id', $id)->first();
        abort_if(! $role, 404);

        $data = $this->rolePayload($request, $id);
        $permissions = $role->name === 'admin'
            ? AdminPermission::names()
            : $data['permissions'];

        DB::table('roles')->where('id', $id)->update([
            'description' => $data['description'],
            'updated_at' => now(),
        ]);
        $this->syncRolePermissions($id, $permissions);

        return redirect()->route('admin.roles.index')->with('status', 'Đã cập nhật quyền cho vai trò '.$role->name.'.');
    }

    public function roleDestroy(int $id)
    {
        $role = DB::table('roles')->where('id', $id)->first();
        abort_if(! $role, 404);

        if (in_array($role->name, ['admin', 'customer'], true)) {
            return back()->withErrors(['role' => 'Không thể xóa vai trò hệ thống.']);
        }

        if (DB::table('users')->where('role_id', $id)->exists()) {
            return back()->withErrors(['role' => 'Vai trò này đang được gán cho user, không thể xóa.']);
        }

        DB::transaction(function () use ($id): void {
            DB::table('role_permissions')->where('role_id', $id)->delete();
            DB::table('roles')->where('id', $id)->delete();
        });

        return redirect()->route('admin.roles.index')->with('status', 'Đã xóa vai trò.');
    }

    public function products(Request $request)
    {
        $query = $this->productBaseQuery();
        $keyword = trim((string) $request->query('q', ''));

        if ($keyword !== '') {
            $query->where(function ($query) use ($keyword): void {
                $keyword = '%'.$keyword.'%';
                $query->where('products.name', 'like', $keyword)
                    ->orWhere('products.sku', 'like', $keyword)
                    ->orWhere('brands.name', 'like', $keyword)
                    ->orWhere('categories.name', 'like', $keyword);
            });
        }

        if ($request->filled('status')) {
            $query->where('products.status', $request->query('status'));
        }

        return view('admin.products.index', [
            'products' => $query->orderByDesc('products.updated_at')->get(),
            'filters' => [
                'q' => $keyword,
                'status' => (string) $request->query('status', ''),
            ],
        ]);
    }

    public function productCreate()
    {
        return view('admin.products.form', $this->productFormData());
    }

    public function productStore(Request $request)
    {
        $payload = $this->productPayload($request);
        $payload['created_at'] = now();

        $productId = DB::transaction(function () use ($payload, $request): int {
            $productId = DB::table('products')->insertGetId($payload);
            $this->syncProductAssets($productId, $payload['thumbnail'] ?? null, $request);

            return $productId;
        });

        return redirect()
            ->route('admin.products.edit', $productId)
            ->with('status', 'Đã thêm sản phẩm mới.');
    }

    public function productEdit(int $id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        abort_if(! $product, 404);

        return view('admin.products.form', $this->productFormData($product));
    }

    public function productUpdate(Request $request, int $id)
    {
        abort_if(! DB::table('products')->where('id', $id)->exists(), 404);

        $payload = $this->productPayload($request, $id);

        DB::transaction(function () use ($id, $payload, $request): void {
            DB::table('products')->where('id', $id)->update($payload);
            $this->syncProductAssets($id, $payload['thumbnail'] ?? null, $request);
        });

        return redirect()
            ->route('admin.products.edit', $id)
            ->with('status', 'Đã cập nhật sản phẩm.');
    }

    public function productDestroy(int $id)
    {
        DB::table('products')->where('id', $id)->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Đã xóa sản phẩm.');
    }

    public function productImages(Request $request)
    {
        $products = $this->productBaseQuery()
            ->orderBy('products.name')
            ->get();

        $selectedProductId = (int) $request->query('product_id', $products->first()->id ?? 0);
        $selectedProduct = $products->firstWhere('id', $selectedProductId);
        $images = $selectedProduct
            ? DB::table('product_images')->where('product_id', $selectedProductId)->orderBy('sort_order')->get()
            : collect();

        return view('admin.product-images.index', [
            'products' => $products,
            'selectedProduct' => $selectedProduct,
            'images' => $images,
            'imagePathText' => $images->where('is_main', false)->pluck('image_path')->implode(PHP_EOL),
        ]);
    }

    public function productImagesUpdate(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'current_thumbnail' => ['nullable', 'string', 'max:255'],
            'current_image_paths' => ['nullable', 'string'],
            'thumbnail_file' => $this->imageUploadRules(),
            'image_files' => ['nullable', 'array'],
            'image_files.*' => $this->imageUploadRules(),
        ]);

        DB::transaction(function () use ($data, $request): void {
            $thumbnail = $this->storeTemplateUploadIfPresent($request, 'thumbnail_file', 'products')
                ?: ($data['current_thumbnail'] ?? null);
            $imagePaths = array_merge(
                $this->lines((string) ($data['current_image_paths'] ?? '')),
                $this->storeTemplateUploads($request, 'image_files', 'products')
            );

            DB::table('products')
                ->where('id', $data['product_id'])
                ->update([
                    'thumbnail' => $thumbnail,
                    'updated_at' => now(),
                ]);

            $this->syncOnlyProductImages((int) $data['product_id'], $thumbnail, implode(PHP_EOL, $imagePaths));
        });

        return redirect()
            ->route('admin.product-images.index', ['product_id' => $data['product_id']])
            ->with('status', 'Đã cập nhật ảnh sản phẩm.');
    }

    public function productSpecifications(Request $request)
    {
        $products = $this->productBaseQuery()
            ->orderBy('products.name')
            ->get();

        $selectedProductId = (int) $request->query('product_id', $products->first()->id ?? 0);
        $selectedProduct = $products->firstWhere('id', $selectedProductId);
        $specifications = $selectedProduct
            ? DB::table('product_specifications')->where('product_id', $selectedProductId)->orderBy('sort_order')->get()
            : collect();

        return view('admin.product-specifications.index', [
            'products' => $products,
            'selectedProduct' => $selectedProduct,
            'specifications' => $specifications,
            'specificationText' => $specifications
                ->map(fn ($spec): string => $spec->spec_name.': '.$spec->spec_value)
                ->implode(PHP_EOL),
        ]);
    }

    public function productSpecificationsUpdate(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'specifications' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($data, $request): void {
            $this->syncOnlyProductSpecifications((int) $data['product_id'], (string) $request->input('specifications', ''));
            DB::table('products')->where('id', $data['product_id'])->update(['updated_at' => now()]);
        });

        return redirect()
            ->route('admin.product-specifications.index', ['product_id' => $data['product_id']])
            ->with('status', 'Đã cập nhật thông số kỹ thuật.');
    }

    public function orders(Request $request)
    {
        $query = DB::table('orders');

        if ($request->filled('status')) {
            $query->where('order_status', $request->query('status'));
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->query('payment_status'));
        }

        if ($request->filled('q')) {
            $keyword = '%'.trim((string) $request->query('q')).'%';
            $query->where(function ($query) use ($keyword): void {
                $query->where('order_code', 'like', $keyword)
                    ->orWhere('customer_name', 'like', $keyword)
                    ->orWhere('customer_phone', 'like', $keyword)
                    ->orWhere('customer_email', 'like', $keyword);
            });
        }

        $orders = $query
            ->orderByDesc('created_at')
            ->limit(100)
            ->get();

        return view('admin.orders.index', [
            'orders' => $orders,
            'filters' => [
                'q' => (string) $request->query('q', ''),
                'status' => (string) $request->query('status', ''),
                'payment_status' => (string) $request->query('payment_status', ''),
            ],
            'orderStatuses' => $this->orderStatuses(),
            'paymentStatuses' => $this->paymentStatuses(),
        ]);
    }

    public function orderUpdate(Request $request, int $id)
    {
        abort_if(! DB::table('orders')->where('id', $id)->exists(), 404);

        $data = $request->validate([
            'order_status' => ['required', Rule::in(array_keys($this->orderStatuses()))],
            'payment_status' => ['required', Rule::in(array_keys($this->paymentStatuses()))],
            'tracking_number' => ['nullable', 'string', 'max:100'],
        ]);

        DB::table('orders')
            ->where('id', $id)
            ->update([
                ...$data,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.orders.index', [
                'q' => $request->input('filter_q'),
                'status' => $request->input('filter_status'),
                'payment_status' => $request->input('filter_payment_status'),
            ])
            ->with('status', 'Đã cập nhật đơn hàng.');
    }

    public function coupons()
    {
        $coupons = DB::table('coupons')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.coupons.index', ['coupons' => $coupons]);
    }

    public function couponCreate()
    {
        return view('admin.coupons.form', ['coupon' => null]);
    }

    public function couponStore(Request $request)
    {
        $payload = $this->couponPayload($request);
        $payload['created_at'] = now();

        $id = DB::table('coupons')->insertGetId($payload);

        return redirect()
            ->route('admin.coupons.edit', $id)
            ->with('status', 'Đã thêm mã giảm giá.');
    }

    public function couponEdit(int $id)
    {
        $coupon = DB::table('coupons')->where('id', $id)->first();
        abort_if(! $coupon, 404);

        return view('admin.coupons.form', ['coupon' => $coupon]);
    }

    public function couponUpdate(Request $request, int $id)
    {
        abort_if(! DB::table('coupons')->where('id', $id)->exists(), 404);

        DB::table('coupons')->where('id', $id)->update($this->couponPayload($request, $id));

        return redirect()
            ->route('admin.coupons.edit', $id)
            ->with('status', 'Đã cập nhật mã giảm giá.');
    }

    public function couponDestroy(int $id)
    {
        DB::table('coupons')->where('id', $id)->delete();

        return redirect()
            ->route('admin.coupons.index')
            ->with('status', 'Đã xóa mã giảm giá.');
    }

    public function reviews(Request $request)
    {
        $query = DB::table('reviews')
            ->leftJoin('products', 'products.id', '=', 'reviews.product_id')
            ->leftJoin('users', 'users.id', '=', 'reviews.user_id')
            ->select('reviews.*', 'products.name as product_name', 'users.name as user_name');

        if ($request->filled('status')) {
            $query->where('reviews.status', (bool) $request->query('status'));
        }

        $reviews = $query
            ->orderByDesc('reviews.created_at')
            ->limit(100)
            ->get();

        return view('admin.reviews.index', [
            'reviews' => $reviews,
            'filters' => [
                'status' => (string) $request->query('status', ''),
            ],
        ]);
    }

    public function reviewUpdate(Request $request, int $id)
    {
        abort_if(! DB::table('reviews')->where('id', $id)->exists(), 404);

        $data = $request->validate([
            'status' => ['required', Rule::in(['0', '1'])],
        ]);

        DB::table('reviews')->where('id', $id)->update([
            'status' => (bool) $data['status'],
        ]);

        return redirect()
            ->route('admin.reviews.index', $request->only('status'))
            ->with('status', 'Đã cập nhật đánh giá.');
    }

    public function reviewDestroy(int $id)
    {
        DB::table('reviews')->where('id', $id)->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('status', 'Đã xóa đánh giá.');
    }

    public function categories()
    {
        $productCounts = DB::table('products')
            ->select('category_id', DB::raw('COUNT(*) as product_count'))
            ->groupBy('category_id');

        $categories = DB::table('categories')
            ->leftJoin('categories as parent', 'parent.id', '=', 'categories.parent_id')
            ->leftJoinSub($productCounts, 'product_counts', 'product_counts.category_id', '=', 'categories.id')
            ->select('categories.*', 'parent.name as parent_name', DB::raw('COALESCE(product_counts.product_count, 0) as product_count'))
            ->orderByRaw('categories.parent_id IS NOT NULL')
            ->orderBy('categories.name')
            ->get();

        return view('admin.categories.index', ['categories' => $categories]);
    }

    public function categoryCreate()
    {
        return view('admin.categories.form', $this->categoryFormData());
    }

    public function categoryStore(Request $request)
    {
        $payload = $this->categoryPayload($request);
        $payload['created_at'] = now();

        $id = DB::table('categories')->insertGetId($payload);

        return redirect()
            ->route('admin.categories.edit', $id)
            ->with('status', 'Đã thêm danh mục.');
    }

    public function categoryEdit(int $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();
        abort_if(! $category, 404);

        return view('admin.categories.form', $this->categoryFormData($category));
    }

    public function categoryUpdate(Request $request, int $id)
    {
        abort_if(! DB::table('categories')->where('id', $id)->exists(), 404);

        DB::table('categories')->where('id', $id)->update($this->categoryPayload($request, $id));

        return redirect()
            ->route('admin.categories.edit', $id)
            ->with('status', 'Đã cập nhật danh mục.');
    }

    public function categoryDestroy(int $id)
    {
        if (DB::table('categories')->where('parent_id', $id)->exists()) {
            return back()->withErrors(['delete' => 'Không thể xóa danh mục đang có danh mục con.']);
        }

        if (DB::table('products')->where('category_id', $id)->exists()) {
            return back()->withErrors(['delete' => 'Không thể xóa danh mục đang có sản phẩm.']);
        }

        DB::table('categories')->where('id', $id)->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Đã xóa danh mục.');
    }

    public function brands()
    {
        $productCounts = DB::table('products')
            ->select('brand_id', DB::raw('COUNT(*) as product_count'))
            ->groupBy('brand_id');

        $brands = DB::table('brands')
            ->leftJoinSub($productCounts, 'product_counts', 'product_counts.brand_id', '=', 'brands.id')
            ->select('brands.*', DB::raw('COALESCE(product_counts.product_count, 0) as product_count'))
            ->orderBy('brands.name')
            ->get();

        return view('admin.brands.index', ['brands' => $brands]);
    }

    public function brandCreate()
    {
        return view('admin.brands.form', ['brand' => null]);
    }

    public function brandStore(Request $request)
    {
        $payload = $this->brandPayload($request);
        $payload['created_at'] = now();

        $id = DB::table('brands')->insertGetId($payload);

        return redirect()
            ->route('admin.brands.edit', $id)
            ->with('status', 'Đã thêm thương hiệu.');
    }

    public function brandEdit(int $id)
    {
        $brand = DB::table('brands')->where('id', $id)->first();
        abort_if(! $brand, 404);

        return view('admin.brands.form', ['brand' => $brand]);
    }

    public function brandUpdate(Request $request, int $id)
    {
        abort_if(! DB::table('brands')->where('id', $id)->exists(), 404);

        DB::table('brands')->where('id', $id)->update($this->brandPayload($request, $id));

        return redirect()
            ->route('admin.brands.edit', $id)
            ->with('status', 'Đã cập nhật thương hiệu.');
    }

    public function brandDestroy(int $id)
    {
        if (DB::table('products')->where('brand_id', $id)->exists()) {
            return back()->withErrors(['delete' => 'Không thể xóa thương hiệu đang có sản phẩm.']);
        }

        DB::table('brands')->where('id', $id)->delete();

        return redirect()
            ->route('admin.brands.index')
            ->with('status', 'Đã xóa thương hiệu.');
    }

    public function banners()
    {
        $banners = Schema::hasTable('banners')
            ? DB::table('banners')->orderBy('position')->orderBy('sort_order')->get()
            : collect();

        return view('admin.banners.index', ['banners' => $banners]);
    }

    public function bannerCreate()
    {
        return view('admin.banners.form', ['banner' => null]);
    }

    public function bannerStore(Request $request)
    {
        $payload = $this->bannerPayload($request);
        $payload['created_at'] = now();

        $id = DB::table('banners')->insertGetId($payload);

        return redirect()
            ->route('admin.banners.edit', $id)
            ->with('status', 'Đã thêm banner.');
    }

    public function bannerEdit(int $id)
    {
        $banner = DB::table('banners')->where('id', $id)->first();
        abort_if(! $banner, 404);

        return view('admin.banners.form', ['banner' => $banner]);
    }

    public function bannerUpdate(Request $request, int $id)
    {
        abort_if(! DB::table('banners')->where('id', $id)->exists(), 404);

        DB::table('banners')->where('id', $id)->update($this->bannerPayload($request));

        return redirect()
            ->route('admin.banners.edit', $id)
            ->with('status', 'Đã cập nhật banner.');
    }

    public function bannerDestroy(int $id)
    {
        DB::table('banners')->where('id', $id)->delete();

        return redirect()
            ->route('admin.banners.index')
            ->with('status', 'Đã xóa banner.');
    }

    private function orderStatuses(): array
    {
        return [
            'pending' => 'Chờ xác nhận',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipping' => 'Đang giao',
            'shipped' => 'Đã gửi hàng',
            'delivered' => 'Đã giao',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
            'returned' => 'Đã trả hàng',
        ];
    }

    private function paymentStatuses(): array
    {
        return [
            'unpaid' => 'Chưa thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thanh toán lỗi',
            'refunded' => 'Đã hoàn tiền',
        ];
    }

    private function couponPayload(Request $request, ?int $ignoreId = null): array
    {
        $request->merge([
            'code' => Str::upper(trim((string) $request->input('code'))),
        ]);

        $codeRule = Rule::unique('coupons', 'code');

        if ($ignoreId) {
            $codeRule->ignore($ignoreId);
        }

        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', $codeRule],
            'name' => ['required', 'string', 'max:255'],
            'discount_type' => ['required', Rule::in(['percentage', 'fixed'])],
            'discount_value' => ['required', 'numeric', 'min:0'],
            'min_order_value' => ['nullable', 'numeric', 'min:0'],
            'max_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['required', 'integer', 'min:0'],
            'used_count' => ['nullable', 'integer', 'min:0'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        return [
            'code' => $data['code'],
            'name' => $data['name'],
            'discount_type' => $data['discount_type'],
            'discount_value' => (float) $data['discount_value'],
            'min_order_value' => (float) ($data['min_order_value'] ?? 0),
            'max_discount_amount' => $request->filled('max_discount_amount') ? (float) $data['max_discount_amount'] : null,
            'quantity' => (int) $data['quantity'],
            'used_count' => (int) ($data['used_count'] ?? 0),
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'status' => $request->boolean('status'),
        ];
    }

    private function syncOnlyProductImages(int $productId, ?string $thumbnail, string $imagePathText): void
    {
        DB::table('product_images')->where('product_id', $productId)->delete();

        $imageRows = [];
        $sortOrder = 1;

        if ($thumbnail) {
            $imageRows[] = [
                'product_id' => $productId,
                'image_path' => $thumbnail,
                'is_main' => true,
                'sort_order' => $sortOrder++,
                'created_at' => now(),
            ];
        }

        foreach ($this->lines($imagePathText) as $imagePath) {
            if ($imagePath === $thumbnail) {
                continue;
            }

            $imageRows[] = [
                'product_id' => $productId,
                'image_path' => $imagePath,
                'is_main' => false,
                'sort_order' => $sortOrder++,
                'created_at' => now(),
            ];
        }

        if ($imageRows !== []) {
            DB::table('product_images')->insert($imageRows);
        }
    }

    private function syncOnlyProductSpecifications(int $productId, string $specificationText): void
    {
        DB::table('product_specifications')->where('product_id', $productId)->delete();

        $specRows = [];
        $sortOrder = 1;

        foreach ($this->lines($specificationText) as $line) {
            [$name, $value] = str_contains($line, ':')
                ? array_map('trim', explode(':', $line, 2))
                : ['Thông số', $line];

            if ($name === '' || $value === '') {
                continue;
            }

            $specRows[] = [
                'product_id' => $productId,
                'spec_name' => $name,
                'spec_value' => $value,
                'sort_order' => $sortOrder++,
            ];
        }

        if ($specRows !== []) {
            DB::table('product_specifications')->insert($specRows);
        }
    }

    private function monthlySales()
    {
        if (! Schema::hasTable('orders')) {
            return collect();
        }

        $start = now()->subMonthsNoOverflow(5)->startOfMonth();

        $rows = DB::table('orders')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month_key")
            ->selectRaw('COUNT(*) as order_count')
            ->selectRaw('SUM(total_amount) as revenue')
            ->where('payment_status', 'paid')
            ->whereNotIn('order_status', ['cancelled', 'returned'])
            ->where('created_at', '>=', $start)
            ->groupBy('month_key')
            ->get()
            ->keyBy('month_key');

        return collect(range(5, 0))->map(function (int $monthsAgo) use ($rows): array {
            $date = now()->subMonthsNoOverflow($monthsAgo);
            $key = $date->format('Y-m');
            $row = $rows->get($key);

            return [
                'label' => $date->format('m/Y'),
                'orders' => (int) ($row->order_count ?? 0),
                'revenue' => (float) ($row->revenue ?? 0),
            ];
        });
    }

    private function recentOrders()
    {
        if (! Schema::hasTable('orders')) {
            return collect();
        }

        return DB::table('orders')
            ->select('id', 'order_code', 'customer_name', 'total_amount', 'order_status', 'payment_status', 'created_at')
            ->orderByDesc('created_at')
            ->limit(8)
            ->get();
    }

    private function topSellingProducts()
    {
        if (! Schema::hasTable('order_items') || ! Schema::hasTable('orders')) {
            return collect();
        }

        return DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->leftJoin('products', 'products.id', '=', 'order_items.product_id')
            ->select('order_items.product_id', 'order_items.product_name', 'products.thumbnail')
            ->selectRaw('SUM(order_items.quantity) as sold_quantity')
            ->selectRaw('SUM(order_items.total) as revenue')
            ->where('orders.payment_status', 'paid')
            ->whereNotIn('orders.order_status', ['cancelled', 'returned'])
            ->groupBy('order_items.product_id', 'order_items.product_name', 'products.thumbnail')
            ->orderByDesc('sold_quantity')
            ->limit(6)
            ->get();
    }

    private function recentActivities()
    {
        $activities = collect();

        if (Schema::hasTable('orders')) {
            $activities = $activities->merge(
                DB::table('orders')
                    ->select('order_code', 'customer_name', 'total_amount', 'order_status', 'created_at')
                    ->orderByDesc('created_at')
                    ->limit(4)
                    ->get()
                    ->map(fn ($order): array => [
                        'icon' => 'fa-receipt',
                        'title' => 'Đơn hàng '.$order->order_code,
                        'meta' => $order->customer_name.' · '.$order->order_status.' · '.number_format((float) $order->total_amount, 0, ',', '.').'đ',
                        'time' => (string) $order->created_at,
                    ])
            );
        }

        if (Schema::hasTable('reviews')) {
            $activities = $activities->merge(
                DB::table('reviews')
                    ->leftJoin('products', 'products.id', '=', 'reviews.product_id')
                    ->select('reviews.rating', 'reviews.reviewer_name', 'reviews.created_at', 'products.name as product_name')
                    ->orderByDesc('reviews.created_at')
                    ->limit(4)
                    ->get()
                    ->map(fn ($review): array => [
                        'icon' => 'fa-star',
                        'title' => 'Đánh giá '.$review->rating.' sao',
                        'meta' => ($review->reviewer_name ?: 'Khách hàng').' · '.($review->product_name ?: 'Sản phẩm'),
                        'time' => (string) $review->created_at,
                    ])
            );
        }

        if (Schema::hasTable('products')) {
            $activities = $activities->merge(
                DB::table('products')
                    ->select('name', 'updated_at')
                    ->orderByDesc('updated_at')
                    ->limit(4)
                    ->get()
                    ->map(fn ($product): array => [
                        'icon' => 'fa-box',
                        'title' => 'Cập nhật sản phẩm',
                        'meta' => $product->name,
                        'time' => (string) $product->updated_at,
                    ])
            );
        }

        return $activities
            ->sortByDesc('time')
            ->take(8)
            ->values();
    }

    private function productBaseQuery()
    {
        return DB::table('products')
            ->leftJoin('brands', 'brands.id', '=', 'products.brand_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->select('products.*', 'brands.name as brand_name', 'categories.name as category_name');
    }

    private function productFormData(?object $product = null): array
    {
        $specifications = $product
            ? DB::table('product_specifications')->where('product_id', $product->id)->orderBy('sort_order')->get()
            : collect();

        $extraImages = $product
            ? DB::table('product_images')->where('product_id', $product->id)->where('is_main', false)->orderBy('sort_order')->pluck('image_path')
            : collect();

        return [
            'product' => $product,
            'categories' => DB::table('categories')->orderByRaw('parent_id IS NOT NULL')->orderBy('name')->get(),
            'brands' => DB::table('brands')->orderBy('name')->get(),
            'specificationText' => $specifications
                ->map(fn ($spec): string => $spec->spec_name.': '.$spec->spec_value)
                ->implode(PHP_EOL),
            'imagePathText' => $extraImages->implode(PHP_EOL),
        ];
    }

    private function productPayload(Request $request, ?int $ignoreId = null): array
    {
        $request->merge([
            'slug' => $this->slug($request->input('slug'), $request->input('name')),
        ]);

        $slugRule = Rule::unique('products', 'slug');
        $skuRule = Rule::unique('products', 'sku');

        if ($ignoreId) {
            $slugRule->ignore($ignoreId);
            $skuRule->ignore($ignoreId);
        }

        $data = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'brand_id' => ['required', 'integer', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $slugRule],
            'sku' => ['required', 'string', 'max:100', $skuRule],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'import_price' => ['nullable', 'numeric', 'min:0'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0'],
            'quantity' => ['nullable', 'integer', 'min:0'],
            'warranty_months' => ['nullable', 'integer', 'min:0'],
            'current_thumbnail' => ['nullable', 'string', 'max:255'],
            'current_image_paths' => ['nullable', 'string'],
            'thumbnail_file' => $this->imageUploadRules(),
            'image_files' => ['nullable', 'array'],
            'image_files.*' => $this->imageUploadRules(),
            'status' => ['required', Rule::in(['active', 'inactive', 'out_of_stock'])],
        ]);

        $thumbnail = $this->storeTemplateUploadIfPresent($request, 'thumbnail_file', 'products')
            ?: ($data['current_thumbnail'] ?? null);

        return [
            'category_id' => (int) $data['category_id'],
            'brand_id' => (int) $data['brand_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'sku' => $data['sku'],
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'] ?? null,
            'import_price' => (float) ($data['import_price'] ?? 0),
            'price' => (float) $data['price'],
            'sale_price' => $request->filled('sale_price') ? (float) $data['sale_price'] : null,
            'quantity' => (int) ($data['quantity'] ?? 0),
            'warranty_months' => (int) ($data['warranty_months'] ?? 0),
            'thumbnail' => $thumbnail,
            'status' => $data['status'],
            'is_featured' => $request->boolean('is_featured'),
            'is_free_shipping' => $request->boolean('is_free_shipping'),
            'updated_at' => now(),
        ];
    }

    private function categoryFormData(?object $category = null): array
    {
        $query = DB::table('categories')->orderByRaw('parent_id IS NOT NULL')->orderBy('name');

        if ($category) {
            $query->where('id', '<>', $category->id);
        }

        return [
            'category' => $category,
            'parents' => $query->get(),
        ];
    }

    private function categoryPayload(Request $request, ?int $ignoreId = null): array
    {
        $request->merge([
            'slug' => $this->slug($request->input('slug'), $request->input('name')),
            'parent_id' => $request->filled('parent_id') ? $request->input('parent_id') : null,
        ]);

        if ($ignoreId && (int) $request->input('parent_id') === $ignoreId) {
            throw ValidationException::withMessages(['parent_id' => 'Danh mục cha không hợp lệ.']);
        }

        $slugRule = Rule::unique('categories', 'slug');

        if ($ignoreId) {
            $slugRule->ignore($ignoreId);
        }

        $data = $request->validate([
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $slugRule],
            'description' => ['nullable', 'string'],
            'current_image' => ['nullable', 'string', 'max:255'],
            'image_file' => $this->imageUploadRules(),
        ]);

        $image = $this->storeTemplateUploadIfPresent($request, 'image_file', 'categories')
            ?: ($data['current_image'] ?? null);

        return [
            'parent_id' => $data['parent_id'] ?? null,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'image' => $image,
            'status' => $request->boolean('status'),
            'updated_at' => now(),
        ];
    }

    private function brandPayload(Request $request, ?int $ignoreId = null): array
    {
        $request->merge([
            'slug' => $this->slug($request->input('slug'), $request->input('name')),
        ]);

        $slugRule = Rule::unique('brands', 'slug');

        if ($ignoreId) {
            $slugRule->ignore($ignoreId);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', $slugRule],
            'current_logo' => ['nullable', 'string', 'max:255'],
            'logo_file' => $this->imageUploadRules(),
            'description' => ['nullable', 'string'],
        ]);

        $logo = $this->storeTemplateUploadIfPresent($request, 'logo_file', 'brands')
            ?: ($data['current_logo'] ?? null);

        return [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'logo' => $logo,
            'description' => $data['description'] ?? null,
            'status' => $request->boolean('status'),
            'updated_at' => now(),
        ];
    }

    private function bannerPayload(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'current_image' => ['nullable', 'string', 'max:255'],
            'image_file' => $this->imageUploadRules('current_image'),
            'link' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $image = $this->storeTemplateUploadIfPresent($request, 'image_file', 'banners')
            ?: ($data['current_image'] ?? null);

        return [
            'title' => $data['title'],
            'image' => $image,
            'link' => $data['link'] ?? null,
            'position' => $data['position'] ?? null,
            'sort_order' => (int) ($data['sort_order'] ?? 0),
            'status' => $request->boolean('status'),
            'updated_at' => now(),
        ];
    }

    private function syncProductAssets(int $productId, ?string $thumbnail, Request $request): void
    {
        DB::table('product_images')->where('product_id', $productId)->delete();

        $imageRows = [];
        $sortOrder = 1;

        if ($thumbnail) {
            $imageRows[] = [
                'product_id' => $productId,
                'image_path' => $thumbnail,
                'is_main' => true,
                'sort_order' => $sortOrder++,
                'created_at' => now(),
            ];
        }

        $imagePaths = array_merge(
            $this->lines((string) $request->input('current_image_paths', '')),
            $this->storeTemplateUploads($request, 'image_files', 'products')
        );

        foreach ($imagePaths as $imagePath) {
            if ($imagePath === $thumbnail) {
                continue;
            }

            $imageRows[] = [
                'product_id' => $productId,
                'image_path' => $imagePath,
                'is_main' => false,
                'sort_order' => $sortOrder++,
                'created_at' => now(),
            ];
        }

        if ($imageRows !== []) {
            DB::table('product_images')->insert($imageRows);
        }

        DB::table('product_specifications')->where('product_id', $productId)->delete();

        $specRows = [];
        $sortOrder = 1;

        foreach ($this->lines((string) $request->input('specifications', '')) as $line) {
            [$name, $value] = str_contains($line, ':')
                ? array_map('trim', explode(':', $line, 2))
                : ['Thông số', $line];

            if ($name === '' || $value === '') {
                continue;
            }

            $specRows[] = [
                'product_id' => $productId,
                'spec_name' => $name,
                'spec_value' => $value,
                'sort_order' => $sortOrder++,
            ];
        }

        if ($specRows !== []) {
            DB::table('product_specifications')->insert($specRows);
        }
    }

    private function lines(string $value): array
    {
        return collect(preg_split('/\r\n|\r|\n/', $value))
            ->map(fn (string $line): string => trim($line))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function imageUploadRules(?string $requiredWithout = null): array
    {
        $presenceRule = $requiredWithout ? 'required_without:'.$requiredWithout : 'nullable';

        return [$presenceRule, 'file', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'];
    }

    private function storeTemplateUploadIfPresent(Request $request, string $field, string $folder): ?string
    {
        if (! $request->hasFile($field)) {
            return null;
        }

        $file = $request->file($field);

        return $file instanceof UploadedFile ? $this->storeTemplateUpload($file, $folder) : null;
    }

    private function storeTemplateUploads(Request $request, string $field, string $folder): array
    {
        if (! $request->hasFile($field)) {
            return [];
        }

        $files = $request->file($field);
        $files = is_array($files) ? $files : [$files];

        return collect($files)
            ->filter(fn ($file): bool => $file instanceof UploadedFile)
            ->map(fn (UploadedFile $file): string => $this->storeTemplateUpload($file, $folder))
            ->values()
            ->all();
    }

    private function storeTemplateUpload(UploadedFile $file, string $folder): string
    {
        $basePath = realpath(base_path('../frontend/public/template/images'));

        if ($basePath === false) {
            throw ValidationException::withMessages(['image_file' => 'Không tìm thấy thư mục lưu ảnh.']);
        }

        $safeFolder = trim(str_replace(['\\', '..'], '/', $folder), '/');
        $targetDir = $basePath.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.$safeFolder;

        if (! is_dir($targetDir) && ! mkdir($targetDir, 0755, true) && ! is_dir($targetDir)) {
            throw ValidationException::withMessages(['image_file' => 'Không thể tạo thư mục lưu ảnh.']);
        }

        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $name = Str::slug($originalName) ?: 'image';
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'jpg');
        $filename = $name.'-'.now()->format('YmdHis').'-'.Str::lower(Str::random(8)).'.'.$extension;

        $file->move($targetDir, $filename);

        return 'template/images/uploads/'.$safeFolder.'/'.$filename;
    }

    private function slug(?string $slug, ?string $name): string
    {
        $slug = Str::slug($slug ?: $name ?: '');

        return $slug !== '' ? $slug : 'item-'.time();
    }

    private function roleOptions()
    {
        return DB::table('roles')
            ->orderByRaw("CASE name WHEN 'admin' THEN 0 WHEN 'manager' THEN 1 WHEN 'staff' THEN 2 WHEN 'customer' THEN 99 ELSE 50 END")
            ->orderBy('name')
            ->get();
    }

    private function rolePayload(Request $request, ?int $ignoreId = null): array
    {
        $this->ensurePermissionRows();
        $permissionNames = $this->permissionNames();
        $rules = [
            'description' => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['string', Rule::in($permissionNames)],
        ];

        if (! $ignoreId) {
            $rules['name'] = ['required', 'string', 'max:80', 'regex:/^[a-z0-9_]+$/', Rule::unique('roles', 'name')];
        }

        $messages = [
            'name.regex' => 'Tên vai trò chỉ dùng chữ thường, số và dấu gạch dưới.',
        ];
        $data = $request->validate($rules, $messages);

        return [
            'name' => $data['name'] ?? null,
            'description' => $data['description'] ?? null,
            'permissions' => $data['permissions'] ?? [],
        ];
    }

    private function permissionNames(): array
    {
        if (! Schema::hasTable('permissions')) {
            return AdminPermission::names();
        }

        return DB::table('permissions')
            ->orderBy('name')
            ->pluck('name')
            ->all();
    }

    private function permissionGroups(): array
    {
        $this->ensurePermissionRows();
        $permissions = DB::table('permissions')->orderBy('name')->get()->keyBy('name');
        $groups = [];
        $catalogNames = [];

        foreach (AdminPermission::groups() as $group => $catalogPermissions) {
            foreach ($catalogPermissions as $name => $label) {
                $catalogNames[] = $name;
                $groups[$group][] = (object) [
                    'name' => $name,
                    'description' => $permissions->get($name)->description ?? $label,
                ];
            }
        }

        $customPermissions = $permissions
            ->reject(fn ($permission, string $name): bool => in_array($name, $catalogNames, true))
            ->values();

        if ($customPermissions->isNotEmpty()) {
            $groups['Khác'] = $customPermissions->all();
        }

        return $groups;
    }

    private function ensurePermissionRows(): void
    {
        if (! Schema::hasTable('permissions')) {
            return;
        }

        $now = now();

        foreach (AdminPermission::descriptions() as $name => $description) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $name],
                [
                    'description' => $description,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }
    }

    private function syncRolePermissions(int $roleId, array $permissionNames): void
    {
        if (! Schema::hasTable('permissions') || ! Schema::hasTable('role_permissions')) {
            return;
        }

        $permissionIds = DB::table('permissions')
            ->whereIn('name', $permissionNames)
            ->pluck('id')
            ->map(fn ($id): int => (int) $id)
            ->all();

        DB::table('role_permissions')
            ->where('role_id', $roleId)
            ->when($permissionIds !== [], fn ($query) => $query->whereNotIn('permission_id', $permissionIds))
            ->when($permissionIds === [], fn ($query) => $query)
            ->delete();

        foreach ($permissionIds as $permissionId) {
            DB::table('role_permissions')->updateOrInsert([
                'role_id' => $roleId,
                'permission_id' => $permissionId,
            ]);
        }
    }

    private function countTable(string $table, ?callable $callback = null): int
    {
        if (! Schema::hasTable($table)) {
            return 0;
        }

        $query = DB::table($table);

        if ($callback) {
            $callback($query);
        }

        return (int) $query->count();
    }
}
