<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function dashboard()
    {
        $latestProducts = $this->productBaseQuery()
            ->orderByDesc('products.updated_at')
            ->limit(6)
            ->get();

        return view('admin.dashboard', [
            'stats' => [
                'products' => $this->countTable('products'),
                'categories' => $this->countTable('categories'),
                'brands' => $this->countTable('brands'),
                'banners' => $this->countTable('banners'),
                'lowStock' => $this->countTable('products', fn ($query) => $query->where('quantity', '<=', 10)),
                'featured' => $this->countTable('products', fn ($query) => $query->where('is_featured', true)),
            ],
            'latestProducts' => $latestProducts,
        ]);
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
            'thumbnail' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['active', 'inactive', 'out_of_stock'])],
        ]);

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
            'thumbnail' => $data['thumbnail'] ?? null,
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
            'image' => ['nullable', 'string', 'max:255'],
        ]);

        return [
            'parent_id' => $data['parent_id'] ?? null,
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'image' => $data['image'] ?? null,
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
            'logo' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        return [
            'name' => $data['name'],
            'slug' => $data['slug'],
            'logo' => $data['logo'] ?? null,
            'description' => $data['description'] ?? null,
            'status' => $request->boolean('status'),
            'updated_at' => now(),
        ];
    }

    private function bannerPayload(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'string', 'max:255'],
            'link' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:50'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        return [
            'title' => $data['title'],
            'image' => $data['image'],
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

        foreach ($this->lines((string) $request->input('image_paths', '')) as $imagePath) {
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

    private function slug(?string $slug, ?string $name): string
    {
        $slug = Str::slug($slug ?: $name ?: '');

        return $slug !== '' ? $slug : 'item-'.time();
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
