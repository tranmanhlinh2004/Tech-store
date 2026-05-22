<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Throwable;

class StorefrontController extends Controller
{
    public function home()
    {
        try {
            $featuredProducts = $this->decorateProducts(
                $this->productQuery()
                    ->where('products.is_featured', true)
                    ->orderByDesc('products.created_at')
                    ->limit(8)
                    ->get()
            );

            $dealProducts = $this->decorateProducts(
                $this->productQuery()
                    ->whereNotNull('products.sale_price')
                    ->whereColumn('products.sale_price', '<', 'products.price')
                    ->orderByRaw('(products.price - products.sale_price) DESC')
                    ->limit(3)
                    ->get()
            );

            return view('frontend.index', [
                'featuredProducts' => $featuredProducts,
                'dealProducts' => $dealProducts,
                'categoryTiles' => $this->categoryTiles(),
                'brandNames' => DB::table('brands')
                    ->where('status', true)
                    ->orderBy('name')
                    ->limit(6)
                    ->pluck('name'),
                'stats' => [
                    'products' => DB::table('products')->where('status', 'active')->count(),
                    'brands' => DB::table('brands')->where('status', true)->count(),
                ],
            ]);
        } catch (Throwable) {
            return view('frontend.index', [
                'featuredProducts' => collect(),
                'dealProducts' => collect(),
                'categoryTiles' => collect(),
                'brandNames' => collect(),
                'stats' => ['products' => 0, 'brands' => 0],
            ]);
        }
    }

    public function shop(Request $request)
    {
        try {
            $query = $this->productQuery();
            $filters = [
                'q' => trim((string) $request->query('q', '')),
                'category' => (string) $request->query('category', ''),
                'brand' => (string) $request->query('brand', ''),
                'price' => (string) $request->query('price', ''),
                'sort' => (string) $request->query('sort', 'featured'),
            ];

            if ($filters['q'] !== '') {
                $keyword = '%'.$filters['q'].'%';
                $query->where(function ($query) use ($keyword): void {
                    $query->where('products.name', 'like', $keyword)
                        ->orWhere('products.sku', 'like', $keyword)
                        ->orWhere('brands.name', 'like', $keyword)
                        ->orWhere('categories.name', 'like', $keyword);
                });
            }

            if ($filters['category'] !== '') {
                $categoryIds = $this->categoryIdsForSlug($filters['category']);
                $categoryIds === []
                    ? $query->whereRaw('1 = 0')
                    : $query->whereIn('products.category_id', $categoryIds);
            }

            if ($filters['brand'] !== '') {
                $query->where('brands.slug', $filters['brand']);
            }

            $this->applyPriceFilter($query, $filters['price']);
            $this->applySort($query, $filters['sort']);

            $products = $query
                ->paginate(12)
                ->withQueryString();

            $products->setCollection($this->decorateProducts($products->getCollection()));

            return view('frontend.shop-side-version-2', [
                'products' => $products,
                'categories' => $this->rootCategories(),
                'brands' => DB::table('brands')->where('status', true)->orderBy('name')->get(),
                'filters' => $filters,
                'searchKeyword' => $filters['q'],
            ]);
        } catch (Throwable) {
            return view('frontend.shop-side-version-2', [
                'products' => new LengthAwarePaginator([], 0, 12),
                'categories' => collect(),
                'brands' => collect(),
                'filters' => ['q' => '', 'category' => '', 'brand' => '', 'price' => '', 'sort' => 'featured'],
                'searchKeyword' => '',
            ]);
        }
    }

    public function cart()
    {
        $cartItems = collect();
        $summary = [
            'regular_subtotal' => 0,
            'subtotal' => 0,
            'discount' => 0,
            'shipping' => 0,
            'total' => 0,
            'item_count' => 0,
        ];

        if (auth()->check()) {
            $cart = DB::table('carts')
                ->where('user_id', auth()->id())
                ->where('status', 'active')
                ->latest('updated_at')
                ->first();

            if ($cart) {
                $cartItems = DB::table('cart_items')
                    ->join('products', 'products.id', '=', 'cart_items.product_id')
                    ->leftJoin('product_variants', 'product_variants.id', '=', 'cart_items.product_variant_id')
                    ->where('cart_items.cart_id', $cart->id)
                    ->where('products.status', 'active')
                    ->select([
                        'cart_items.id',
                        'cart_items.product_id',
                        'cart_items.product_variant_id',
                        'cart_items.selected_color',
                        'cart_items.selected_size',
                        'cart_items.quantity',
                        'cart_items.price',
                        'products.name',
                        'products.slug',
                        'products.short_description',
                        'products.price as regular_price',
                        'products.quantity as stock_quantity',
                        'products.thumbnail',
                        'products.warranty_months',
                        'product_variants.sku as variant_sku',
                        'product_variants.color as variant_color',
                        'product_variants.size_label',
                        'product_variants.storage_label',
                        'product_variants.image_path as variant_image',
                    ])
                    ->orderBy('cart_items.created_at')
                    ->get()
                    ->map(function ($item) {
                        $quantity = max(1, (int) $item->quantity);
                        $unitPrice = (float) $item->price;
                        $regularPrice = (float) $item->regular_price;

                        $item->quantity = $quantity;
                        $item->stock_quantity = max(0, (int) $item->stock_quantity);
                        $item->unit_price = $unitPrice;
                        $item->regular_unit_price = $regularPrice;
                        $item->line_total = $unitPrice * $quantity;
                        $item->regular_line_total = $regularPrice * $quantity;
                        $item->display_unit_price = $this->formatCurrency($unitPrice);
                        $item->display_line_total = $this->formatCurrency($item->line_total);
                        $item->image = $item->variant_image ?: ($item->thumbnail ?: 'template/images/loading.gif');
                        $item->detail_url = route('frontend.product', $item->slug);
                        $item->variant_label = collect([
                            $item->selected_color ?: $item->variant_color,
                            $item->selected_size ?: $item->storage_label ?: $item->size_label,
                            $item->variant_sku,
                        ])->filter()->implode(' · ');

                        return $item;
                    });

                $summary['regular_subtotal'] = (float) $cartItems->sum('regular_line_total');
                $summary['subtotal'] = (float) $cartItems->sum('line_total');
                $summary['discount'] = max(0, $summary['regular_subtotal'] - $summary['subtotal']);
                $summary['total'] = $summary['subtotal'] + $summary['shipping'];
                $summary['item_count'] = $cartItems->count();
            }
        }

        return view('frontend.cart', [
            'cartItems' => $cartItems,
            'cartSummary' => $summary,
            'isGuestCart' => ! auth()->check(),
        ]);
    }

    public function dashboard()
    {
        $userId = (int) auth()->id();
        $warrantyItems = $this->activeWarrantyItems($userId);

        return view('frontend.dashboard', [
            'accountStats' => $this->accountStats($userId, $warrantyItems),
            'recentActivities' => $this->accountRecentActivities($userId, $warrantyItems),
            'latestOrders' => $this->accountOrdersForUser($userId, 3),
            'warrantyItems' => $warrantyItems->take(3),
        ]);
    }

    public function accountOrders()
    {
        return view('frontend.dash-my-order', [
            'orders' => $this->accountOrdersForUser((int) auth()->id(), 20),
        ]);
    }

    public function accountTrackOrder(Request $request)
    {
        $orders = $this->accountOrdersForUser((int) auth()->id(), 20);
        $selectedOrderId = (int) $request->query('order', 0);
        $order = $selectedOrderId > 0
            ? $orders->firstWhere('id', $selectedOrderId)
            : $orders->first();

        if (! $order) {
            return view('frontend.dash-track-order', [
                'orders' => $orders,
                'order' => null,
                'orderItems' => collect(),
                'orderHistory' => collect(),
            ]);
        }

        return view('frontend.dash-track-order', [
            'orders' => $orders,
            'order' => $order,
            'orderItems' => $this->accountOrderItems((int) $order->id),
            'orderHistory' => $this->accountOrderHistory($order),
        ]);
    }

    public function accountProfile()
    {
        return view('frontend.dash-my-profile', [
            'accountStats' => $this->accountStats((int) auth()->id()),
        ]);
    }

    public function accountAddresses()
    {
        return view('frontend.dash-address-book', [
            'addresses' => $this->accountAddressesForUser((int) auth()->id()),
        ]);
    }

    public function accountAddressEdit()
    {
        return view('frontend.dash-address-edit', [
            'address' => $this->accountAddressesForUser((int) auth()->id())->first(),
        ]);
    }

    public function accountPayments()
    {
        return view('frontend.dash-payment-option', [
            'paymentMethods' => $this->accountPaymentMethodsForUser((int) auth()->id()),
        ]);
    }

    public function accountCancellation()
    {
        $cancelableStatuses = ['pending', 'confirmed', 'processing'];
        $cancelableOrders = $this->accountOrdersForUser((int) auth()->id(), 20)
            ->filter(fn ($order): bool => in_array($order->order_status, $cancelableStatuses, true))
            ->values();

        return view('frontend.dash-cancellation', [
            'cancelableOrders' => $cancelableOrders,
        ]);
    }

    public function wishlist()
    {
        return view('frontend.wishlist', [
            'wishlistProducts' => auth()->check()
                ? $this->wishlistProductsForUser((int) auth()->id())
                : collect(),
            'isGuestWishlist' => ! auth()->check(),
        ]);
    }

    public function addToWishlist(Request $request): RedirectResponse
    {
        if (! Schema::hasTable('wishlists')) {
            return back()->with('error', 'Chức năng yêu thích chưa sẵn sàng.');
        }

        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'min:1'],
        ]);

        $product = DB::table('products')
            ->where('id', $validated['product_id'])
            ->where('status', 'active')
            ->first(['id', 'name']);

        if (! $product) {
            return back()->withErrors(['wishlist' => 'Sản phẩm không còn khả dụng.']);
        }

        $userId = (int) auth()->id();
        $exists = DB::table('wishlists')
            ->where('user_id', $userId)
            ->where('product_id', $product->id)
            ->exists();

        if (! $exists) {
            DB::table('wishlists')->insert([
                'user_id' => $userId,
                'product_id' => $product->id,
                'created_at' => now(),
            ]);
        }

        return back()->with(
            'status',
            $exists
                ? $product->name.' đã có trong danh sách yêu thích.'
                : 'Đã thêm '.$product->name.' vào danh sách yêu thích.'
        );
    }

    public function removeFromWishlist(int $product): RedirectResponse
    {
        if (! Schema::hasTable('wishlists')) {
            return back()->with('error', 'Chức năng yêu thích chưa sẵn sàng.');
        }

        DB::table('wishlists')
            ->where('user_id', auth()->id())
            ->where('product_id', $product)
            ->delete();

        return back()->with('status', 'Đã xóa sản phẩm khỏi danh sách yêu thích.');
    }

    public function checkout(Request $request)
    {
        if ($request->query('source') === 'cart') {
            $request->session()->forget('buy_now_checkout');
        }

        $buyNowPayload = $request->session()->get('buy_now_checkout');
        $buyNowData = is_array($buyNowPayload)
            ? $this->buyNowCheckoutData($buyNowPayload)
            : null;
        $checkoutSource = $buyNowData && $buyNowData['items']->isNotEmpty()
            ? 'buy_now'
            : 'cart';
        $checkoutData = $checkoutSource === 'buy_now'
            ? $buyNowData
            : $this->checkoutCartData((int) auth()->id());

        if ($checkoutData['items']->isEmpty()) {
            return redirect()
                ->route('frontend.cart')
                ->with('error', 'Giỏ hàng đang trống, vui lòng chọn sản phẩm trước khi thanh toán.');
        }

        return view('frontend.checkout', [
            'cartItems' => $checkoutData['items'],
            'checkoutSummary' => $checkoutData['summary'],
            'checkoutSource' => $checkoutSource,
            'defaultAddress' => $this->accountAddressesForUser((int) auth()->id())->first(),
            'shippingMethods' => $this->checkoutShippingMethods(),
        ]);
    }

    public function buyNowCheckout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'min:1'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $product = DB::table('products')
            ->where('id', $validated['product_id'])
            ->where('status', 'active')
            ->first(['id', 'quantity']);

        if (! $product) {
            return back()->withErrors(['cart' => 'Sản phẩm không còn khả dụng.']);
        }

        $stockQuantity = max(0, (int) $product->quantity);

        if ($stockQuantity === 0) {
            return back()->withErrors(['cart' => 'Sản phẩm đã hết hàng.']);
        }

        $request->session()->put('buy_now_checkout', [
            'product_id' => (int) $product->id,
            'quantity' => min((int) ($validated['quantity'] ?? 1), $stockQuantity),
        ]);

        return redirect()->route('frontend.checkout');
    }

    public function placeCodOrder(Request $request): RedirectResponse
    {
        if (! Schema::hasTable('orders') || ! Schema::hasTable('order_items') || ! Schema::hasTable('payments')) {
            return back()
                ->withInput()
                ->with('error', 'Chức năng đặt hàng chưa sẵn sàng.');
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_email' => ['required', 'email', 'max:255'],
            'shipping_address' => ['required', 'string', 'max:1000'],
            'shipping_method' => ['required', 'in:same_day,standard,pickup'],
            'payment_method' => ['required', 'in:cod'],
            'note' => ['nullable', 'string', 'max:1000'],
        ], [
            'customer_name.required' => 'Vui lòng nhập họ tên người nhận.',
            'customer_phone.required' => 'Vui lòng nhập số điện thoại.',
            'customer_email.required' => 'Vui lòng nhập email.',
            'customer_email.email' => 'Email không đúng định dạng.',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ nhận hàng.',
            'payment_method.in' => 'Hiện tại chỉ hỗ trợ thanh toán khi nhận hàng.',
        ]);

        $buyNowPayload = $request->session()->get('buy_now_checkout');
        $checkoutSource = (string) $request->input('checkout_source', is_array($buyNowPayload) ? 'buy_now' : 'cart');
        $isBuyNowCheckout = $checkoutSource === 'buy_now';

        try {
            $result = DB::transaction(function () use ($validated, $buyNowPayload, $isBuyNowCheckout): array {
                $userId = (int) auth()->id();
                if ($isBuyNowCheckout) {
                    if (! is_array($buyNowPayload)) {
                        throw new \RuntimeException('Phiên mua ngay đã hết hạn, vui lòng chọn lại sản phẩm.');
                    }

                    $cartData = $this->buyNowCheckoutData($buyNowPayload, true);
                } else {
                    $cartData = $this->checkoutCartData($userId, true);
                }

                $cart = $cartData['cart'];
                $cartItems = $cartData['items'];
                $summary = $cartData['summary'];

                if ($cartItems->isEmpty() || (! $isBuyNowCheckout && ! $cart)) {
                    $message = $isBuyNowCheckout
                        ? 'Sản phẩm mua ngay không còn khả dụng hoặc đã hết hàng.'
                        : 'Giỏ hàng đang trống, vui lòng chọn sản phẩm trước khi thanh toán.';

                    throw new \RuntimeException($message);
                }

                $cartItems->each(function ($item): void {
                    if ($item->stock_quantity <= 0) {
                        throw new \RuntimeException('Sản phẩm '.$item->name.' đã hết hàng.');
                    }

                    if ($item->quantity > $item->stock_quantity) {
                        throw new \RuntimeException('Sản phẩm '.$item->name.' chỉ còn '.$item->stock_quantity.' sản phẩm.');
                    }

                    if ($item->variant_stock_quantity !== null && $item->quantity > $item->variant_stock_quantity) {
                        throw new \RuntimeException('Phiên bản '.$item->name.' chỉ còn '.$item->variant_stock_quantity.' sản phẩm.');
                    }
                });

                $orderCode = $this->generateOrderCode();
                $shippingMethod = $this->checkoutShippingMethods()[$validated['shipping_method']];

                $orderId = DB::table('orders')->insertGetId([
                    'user_id' => $userId,
                    'order_code' => $orderCode,
                    'customer_name' => $validated['customer_name'],
                    'customer_email' => $validated['customer_email'],
                    'customer_phone' => $validated['customer_phone'],
                    'shipping_address' => $validated['shipping_address'],
                    'shipping_full_name' => $validated['customer_name'],
                    'shipping_phone' => $validated['customer_phone'],
                    'shipping_country' => 'Vietnam',
                    'billing_address' => $validated['shipping_address'],
                    'billing_full_name' => $validated['customer_name'],
                    'billing_phone' => $validated['customer_phone'],
                    'billing_country' => 'Vietnam',
                    'note' => trim(collect([$shippingMethod, $validated['note'] ?? null])->filter()->implode(' - ')),
                    'subtotal' => $summary['regular_subtotal'],
                    'discount_amount' => $summary['discount'],
                    'shipping_fee' => $summary['shipping'],
                    'tax_amount' => 0,
                    'total_amount' => $summary['total'],
                    'shipping_method' => $validated['shipping_method'],
                    'order_status' => 'pending',
                    'payment_status' => 'unpaid',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $cartItems->each(function ($item) use ($orderId): void {
                    DB::table('order_items')->insert([
                        'order_id' => $orderId,
                        'product_id' => $item->product_id,
                        'product_variant_id' => $item->product_variant_id,
                        'product_sku' => $item->variant_sku ?: $item->product_sku,
                        'selected_color' => $item->selected_color ?: $item->variant_color,
                        'selected_size' => $item->selected_size ?: $item->storage_label ?: $item->size_label,
                        'product_name' => $item->name,
                        'product_image' => $item->image,
                        'price' => $item->unit_price,
                        'quantity' => $item->quantity,
                        'total' => $item->line_total,
                    ]);

                    DB::table('products')
                        ->where('id', $item->product_id)
                        ->decrement('quantity', $item->quantity);

                    DB::table('products')
                        ->where('id', $item->product_id)
                        ->increment('sold_count', $item->quantity);

                    if ($item->product_variant_id && Schema::hasTable('product_variants')) {
                        DB::table('product_variants')
                            ->where('id', $item->product_variant_id)
                            ->decrement('stock_quantity', $item->quantity);
                    }
                });

                DB::table('payments')->insert([
                    'order_id' => $orderId,
                    'payment_method' => 'cod',
                    'payment_status' => 'unpaid',
                    'amount' => $summary['total'],
                    'transaction_code' => null,
                    'paid_at' => null,
                    'created_at' => now(),
                ]);

                if (Schema::hasTable('order_status_histories')) {
                    try {
                        DB::table('order_status_histories')->insert([
                            'order_id' => $orderId,
                            'status' => 'pending',
                            'note' => $isBuyNowCheckout
                                ? 'Đơn hàng COD được tạo từ mua ngay.'
                                : 'Đơn hàng COD được tạo từ checkout.',
                            'created_at' => now(),
                        ]);
                    } catch (Throwable) {
                        // The order itself is the source of truth; history is optional.
                    }
                }

                if (! $isBuyNowCheckout && $cart) {
                    DB::table('carts')
                        ->where('id', $cart->id)
                        ->update([
                            'status' => 'converted',
                            'note' => 'Converted to order #'.$orderCode,
                            'updated_at' => now(),
                        ]);
                }

                return [
                    'order_id' => $orderId,
                    'order_code' => $orderCode,
                ];
            });
        } catch (\RuntimeException $exception) {
            return back()
                ->withInput()
                ->with('error', $exception->getMessage());
        } catch (Throwable) {
            return back()
                ->withInput()
                ->with('error', 'Không thể tạo đơn hàng, vui lòng thử lại.');
        }

        if ($isBuyNowCheckout) {
            $request->session()->forget('buy_now_checkout');
        }

        return redirect()
            ->route('frontend.account.track', ['order' => $result['order_id']])
            ->with('status', 'Đã đặt hàng COD thành công. Mã đơn #'.$result['order_code']);
    }

    public function addToCart(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'min:1'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        if (! auth()->check()) {
            return back()->with('cart_login_required', true);
        }

        $product = DB::table('products')
            ->where('id', $validated['product_id'])
            ->where('status', 'active')
            ->first();

        if (! $product) {
            return back()->withErrors(['cart' => 'Sản phẩm không còn khả dụng.']);
        }

        $stockQuantity = max(0, (int) $product->quantity);

        if ($stockQuantity === 0) {
            return back()->withErrors(['cart' => 'Sản phẩm đã hết hàng.']);
        }

        $requestedQuantity = min((int) ($validated['quantity'] ?? 1), $stockQuantity);
        $regularPrice = (float) $product->price;
        $salePrice = $product->sale_price !== null ? (float) $product->sale_price : null;
        $unitPrice = $salePrice !== null && $salePrice > 0 && $salePrice < $regularPrice
            ? $salePrice
            : $regularPrice;
        $userId = (int) auth()->id();

        DB::transaction(function () use ($product, $requestedQuantity, $stockQuantity, $unitPrice, $userId): void {
            $cart = DB::table('carts')
                ->where('user_id', $userId)
                ->where('status', 'active')
                ->latest('updated_at')
                ->first();

            $cartId = $cart?->id ?? DB::table('carts')->insertGetId([
                'user_id' => $userId,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $existingItem = DB::table('cart_items')
                ->where('cart_id', $cartId)
                ->where('product_id', $product->id)
                ->whereNull('product_variant_id')
                ->first();

            if ($existingItem) {
                DB::table('cart_items')
                    ->where('id', $existingItem->id)
                    ->update([
                        'quantity' => min($stockQuantity, (int) $existingItem->quantity + $requestedQuantity),
                        'price' => $unitPrice,
                        'updated_at' => now(),
                    ]);
            } else {
                DB::table('cart_items')->insert([
                    'cart_id' => $cartId,
                    'product_id' => $product->id,
                    'quantity' => $requestedQuantity,
                    'price' => $unitPrice,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::table('carts')
                ->where('id', $cartId)
                ->update(['updated_at' => now()]);
        });

        return redirect()
            ->route('frontend.cart')
            ->with('status', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    public function updateCartItem(Request $request, int $item): RedirectResponse|JsonResponse
    {
        if (! auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Vui lòng đăng nhập để cập nhật giỏ hàng.'], 401);
            }

            return redirect()->route('frontend.cart')->with('cart_login_required', true);
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cartItem = $this->activeCartItemForCurrentUser($item);

        if (! $cartItem) {
            return $this->cartActionError($request, 'Không tìm thấy sản phẩm trong giỏ hàng.', 404);
        }

        if ($cartItem->product_status !== 'active') {
            return $this->cartActionError($request, 'Sản phẩm không còn khả dụng.');
        }

        $stockQuantity = max(0, (int) $cartItem->stock_quantity);

        if ($stockQuantity === 0) {
            return $this->cartActionError($request, 'Sản phẩm đã hết hàng.');
        }

        $quantity = min((int) $validated['quantity'], $stockQuantity);

        DB::table('cart_items')
            ->where('id', $cartItem->id)
            ->update([
                'quantity' => $quantity,
                'updated_at' => now(),
            ]);

        DB::table('carts')
            ->where('id', $cartItem->cart_id)
            ->update(['updated_at' => now()]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Đã cập nhật số lượng sản phẩm.',
                'item' => $this->cartItemPayload($cartItem, $quantity),
                'summary' => $this->cartSummaryPayload(),
            ]);
        }

        return back()->with('status', 'Đã cập nhật số lượng sản phẩm.');
    }

    public function removeCartItem(Request $request, int $item): RedirectResponse|JsonResponse
    {
        if (! auth()->check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Vui lòng đăng nhập để cập nhật giỏ hàng.'], 401);
            }

            return redirect()->route('frontend.cart')->with('cart_login_required', true);
        }

        $cartItem = $this->activeCartItemForCurrentUser($item);

        if (! $cartItem) {
            return $this->cartActionError($request, 'Không tìm thấy sản phẩm trong giỏ hàng.', 404);
        }

        DB::table('cart_items')
            ->where('id', $cartItem->id)
            ->delete();

        DB::table('carts')
            ->where('id', $cartItem->cart_id)
            ->update(['updated_at' => now()]);

        if ($request->expectsJson()) {
            $summary = $this->cartSummaryPayload();

            return response()->json([
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
                'removed_item_id' => $cartItem->id,
                'is_empty' => $summary['item_count'] === 0,
                'summary' => $summary,
            ]);
        }

        return back()->with('status', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    public function product(?string $slug = null)
    {
        try {
            $query = $this->productQuery();

            if ($slug !== null) {
                $query->where('products.slug', $slug);
            } else {
                $query->orderByDesc('products.is_featured')->orderByDesc('products.created_at');
            }

            $product = $query->first();

            if (! $product) {
                abort(404);
            }

            $product = $this->decorateProducts(collect([$product]))->first();

            $images = DB::table('product_images')
                ->where('product_id', $product->id)
                ->orderByDesc('is_main')
                ->orderBy('sort_order')
                ->pluck('image_path')
                ->filter()
                ->values();

            if ($images->isEmpty() && $product->thumbnail) {
                $images = collect([$product->thumbnail]);
            }

            $specifications = DB::table('product_specifications')
                ->where('product_id', $product->id)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();

            $relatedProducts = $this->relatedProducts($product);
            $reviewData = $this->productReviewData((int) $product->id);

            return view('frontend.product-detail', [
                'product' => $product,
                'productImages' => $images,
                'specifications' => $specifications,
                'relatedProducts' => $relatedProducts,
                'reviews' => $reviewData['reviews'],
                'reviewSummary' => $reviewData['summary'],
            ]);
        } catch (Throwable) {
            abort(404);
        }
    }

    public function storeReview(Request $request, int $product): RedirectResponse
    {
        if (! Schema::hasTable('reviews')) {
            return back()->with('error', 'Chức năng đánh giá chưa sẵn sàng.');
        }

        $productRow = DB::table('products')
            ->where('id', $product)
            ->where('status', 'active')
            ->first(['id', 'slug']);

        if (! $productRow) {
            abort(404);
        }

        $user = $request->user();

        if (! $user) {
            return redirect(route('frontend.product', $productRow->slug).'#reviews')
                ->with('error', 'Vui lòng đăng nhập để gửi đánh giá sản phẩm.');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'title' => ['nullable', 'string', 'max:120'],
            'comment' => ['required', 'string', 'min:10', 'max:1200'],
        ]);

        DB::table('reviews')->insert([
            'user_id' => $user->id,
            'product_id' => $productRow->id,
            'reviewer_name' => $user->name,
            'reviewer_email' => $user->email,
            'rating' => (int) $validated['rating'],
            'title' => $validated['title'] ?? null,
            'comment' => $validated['comment'],
            'status' => true,
            'created_at' => now(),
        ]);

        return redirect(route('frontend.product', $productRow->slug).'#reviews')
            ->with('status', 'Cảm ơn bạn đã gửi đánh giá sản phẩm.');
    }

    private function buyNowCheckoutData(?array $payload, bool $lock = false): array
    {
        $emptyItems = collect();
        $empty = [
            'cart' => null,
            'items' => $emptyItems,
            'summary' => $this->checkoutSummaryFromItems($emptyItems),
        ];

        $productId = (int) ($payload['product_id'] ?? 0);
        $quantity = max(1, min(99, (int) ($payload['quantity'] ?? 1)));

        if ($productId <= 0 || ! Schema::hasTable('products')) {
            return $empty;
        }

        $query = DB::table('products')
            ->where('id', $productId)
            ->where('status', 'active')
            ->select([
                'id',
                'name',
                'slug',
                'sku as product_sku',
                'short_description',
                'price as regular_price',
                'sale_price',
                'quantity as stock_quantity',
                'thumbnail',
                'warranty_months',
            ]);

        if ($lock) {
            $query->lockForUpdate();
        }

        $product = $query->first();

        if (! $product) {
            return $empty;
        }

        $stockQuantity = max(0, (int) $product->stock_quantity);

        if ($stockQuantity === 0) {
            return $empty;
        }

        $quantity = min($quantity, $stockQuantity);
        $regularPrice = (float) $product->regular_price;
        $salePrice = $product->sale_price !== null ? (float) $product->sale_price : null;
        $unitPrice = $salePrice !== null && $salePrice > 0 && $salePrice < $regularPrice
            ? $salePrice
            : $regularPrice;
        $lineTotal = $unitPrice * $quantity;
        $regularLineTotal = $regularPrice * $quantity;
        $item = (object) [
            'id' => null,
            'product_id' => (int) $product->id,
            'product_variant_id' => null,
            'selected_color' => null,
            'selected_size' => null,
            'quantity' => $quantity,
            'price' => $unitPrice,
            'name' => $product->name,
            'slug' => $product->slug,
            'product_sku' => $product->product_sku,
            'short_description' => $product->short_description,
            'regular_price' => $regularPrice,
            'stock_quantity' => $stockQuantity,
            'thumbnail' => $product->thumbnail,
            'warranty_months' => (int) $product->warranty_months,
            'variant_sku' => null,
            'variant_color' => null,
            'size_label' => null,
            'storage_label' => null,
            'variant_image' => null,
            'variant_stock_quantity' => null,
            'unit_price' => $unitPrice,
            'regular_unit_price' => $regularPrice,
            'line_total' => $lineTotal,
            'regular_line_total' => $regularLineTotal,
            'display_unit_price' => $this->formatCurrency($unitPrice),
            'display_line_total' => $this->formatCurrency($lineTotal),
            'image' => $product->thumbnail ?: 'template/images/loading.gif',
            'detail_url' => route('frontend.product', $product->slug),
            'variant_label' => 'Mua ngay',
        ];
        $items = collect([$item]);

        return [
            'cart' => null,
            'items' => $items,
            'summary' => $this->checkoutSummaryFromItems($items),
        ];
    }

    private function checkoutCartData(int $userId, bool $lock = false): array
    {
        if (! Schema::hasTable('carts') || ! Schema::hasTable('cart_items')) {
            return [
                'cart' => null,
                'items' => collect(),
                'summary' => $this->checkoutSummaryFromItems(collect()),
            ];
        }

        $cartQuery = DB::table('carts')
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->latest('updated_at');

        if ($lock) {
            $cartQuery->lockForUpdate();
        }

        $cart = $cartQuery->first();
        $items = $cart ? $this->checkoutCartItems((int) $cart->id, $lock) : collect();

        return [
            'cart' => $cart,
            'items' => $items,
            'summary' => $this->checkoutSummaryFromItems($items),
        ];
    }

    private function checkoutCartItems(int $cartId, bool $lock = false): Collection
    {
        $query = DB::table('cart_items')
            ->join('products', 'products.id', '=', 'cart_items.product_id')
            ->leftJoin('product_variants', 'product_variants.id', '=', 'cart_items.product_variant_id')
            ->where('cart_items.cart_id', $cartId)
            ->where('products.status', 'active')
            ->select([
                'cart_items.id',
                'cart_items.product_id',
                'cart_items.product_variant_id',
                'cart_items.selected_color',
                'cart_items.selected_size',
                'cart_items.quantity',
                'cart_items.price',
                'products.name',
                'products.slug',
                'products.sku as product_sku',
                'products.short_description',
                'products.price as regular_price',
                'products.quantity as stock_quantity',
                'products.thumbnail',
                'products.warranty_months',
                'product_variants.sku as variant_sku',
                'product_variants.color as variant_color',
                'product_variants.size_label',
                'product_variants.storage_label',
                'product_variants.image_path as variant_image',
                'product_variants.stock_quantity as variant_stock_quantity',
            ])
            ->orderBy('cart_items.created_at');

        if ($lock) {
            $query->lockForUpdate();
        }

        return $query
            ->get()
            ->map(function ($item) {
                $quantity = max(1, (int) $item->quantity);
                $unitPrice = (float) $item->price;
                $regularPrice = (float) $item->regular_price;

                $item->quantity = $quantity;
                $item->stock_quantity = max(0, (int) $item->stock_quantity);
                $item->variant_stock_quantity = $item->variant_stock_quantity !== null
                    ? max(0, (int) $item->variant_stock_quantity)
                    : null;
                $item->unit_price = $unitPrice;
                $item->regular_unit_price = $regularPrice;
                $item->line_total = $unitPrice * $quantity;
                $item->regular_line_total = $regularPrice * $quantity;
                $item->display_unit_price = $this->formatCurrency($unitPrice);
                $item->display_line_total = $this->formatCurrency($item->line_total);
                $item->image = $item->variant_image ?: ($item->thumbnail ?: 'template/images/loading.gif');
                $item->detail_url = route('frontend.product', $item->slug);
                $item->variant_label = collect([
                    $item->selected_color ?: $item->variant_color,
                    $item->selected_size ?: $item->storage_label ?: $item->size_label,
                    $item->variant_sku,
                ])->filter()->implode(' · ');

                return $item;
            });
    }

    private function checkoutSummaryFromItems(Collection $items): array
    {
        $regularSubtotal = (float) $items->sum('regular_line_total');
        $subtotal = (float) $items->sum('line_total');
        $discount = max(0, $regularSubtotal - $subtotal);
        $shipping = 0.0;

        return [
            'regular_subtotal' => $regularSubtotal,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'total' => $subtotal + $shipping,
            'item_count' => $items->count(),
        ];
    }

    private function checkoutShippingMethods(): array
    {
        return [
            'same_day' => 'Giao nhanh trong ngày',
            'standard' => 'Giao tiêu chuẩn',
            'pickup' => 'Nhận tại cửa hàng',
        ];
    }

    private function generateOrderCode(): string
    {
        do {
            $code = 'ORD'.now()->format('YmdHis').random_int(10, 99);
        } while (
            Schema::hasTable('orders')
            && DB::table('orders')->where('order_code', $code)->exists()
        );

        return $code;
    }

    private function accountStats(int $userId, ?Collection $warrantyItems = null): array
    {
        $processingStatuses = ['pending', 'confirmed', 'processing', 'shipping', 'shipped'];
        $warrantyItems ??= $this->activeWarrantyItems($userId);

        $stats = [
            'processing_orders' => 0,
            'wishlist_products' => 0,
            'active_warranties' => (int) $warrantyItems->sum('quantity'),
            'total_orders' => 0,
            'completed_orders' => 0,
            'purchased_items' => 0,
            'address_count' => 0,
            'payment_count' => 0,
        ];

        if (Schema::hasTable('orders')) {
            $stats['processing_orders'] = DB::table('orders')
                ->where('user_id', $userId)
                ->whereIn('order_status', $processingStatuses)
                ->count();

            $stats['total_orders'] = DB::table('orders')
                ->where('user_id', $userId)
                ->count();

            $stats['completed_orders'] = DB::table('orders')
                ->where('user_id', $userId)
                ->whereIn('order_status', ['delivered', 'completed'])
                ->count();
        }

        if (Schema::hasTable('wishlists')) {
            $stats['wishlist_products'] = DB::table('wishlists')
                ->where('user_id', $userId)
                ->count();
        }

        if (Schema::hasTable('orders') && Schema::hasTable('order_items')) {
            $stats['purchased_items'] = (int) DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where('orders.user_id', $userId)
                ->whereNotIn('orders.order_status', ['cancelled', 'returned'])
                ->sum('order_items.quantity');
        }

        if (Schema::hasTable('user_addresses')) {
            $stats['address_count'] = DB::table('user_addresses')
                ->where('user_id', $userId)
                ->where('status', true)
                ->count();
        }

        if (Schema::hasTable('user_payment_methods')) {
            $stats['payment_count'] = DB::table('user_payment_methods')
                ->where('user_id', $userId)
                ->where('status', 'active')
                ->count();
        }

        return $stats;
    }

    private function accountRecentActivities(int $userId, Collection $warrantyItems): Collection
    {
        $activities = collect();

        $this->accountOrdersForUser($userId, 3)->each(function ($order) use ($activities): void {
            $activities->push((object) [
                'icon' => $this->orderStatusIcon($order->order_status),
                'title' => 'Đơn #'.$order->order_code.' '.$order->status_label,
                'meta' => trim($order->item_summary.' · '.$order->display_total, ' ·'),
                'display_time' => $order->display_date,
                'sort_at' => $this->dateTimestamp($order->created_at),
                'url' => $order->track_url,
            ]);
        });

        if (Schema::hasTable('wishlists') && Schema::hasTable('products')) {
            DB::table('wishlists')
                ->join('products', 'products.id', '=', 'wishlists.product_id')
                ->where('wishlists.user_id', $userId)
                ->select([
                    'products.name',
                    'products.price',
                    'products.sale_price',
                    'wishlists.created_at as added_at',
                ])
                ->orderByDesc('wishlists.created_at')
                ->limit(3)
                ->get()
                ->each(function ($wishlist) use ($activities): void {
                    $price = (float) ($wishlist->sale_price ?: $wishlist->price);

                    $activities->push((object) [
                        'icon' => 'fas fa-heart',
                        'title' => 'Đã thêm '.$wishlist->name.' vào yêu thích',
                        'meta' => 'Giá hiện tại '.$this->formatCurrency($price),
                        'display_time' => $this->formatDate($wishlist->added_at),
                        'sort_at' => $this->dateTimestamp($wishlist->added_at),
                        'url' => route('frontend.wishlist'),
                    ]);
                });
        }

        $warrantyItems->take(2)->each(function ($item) use ($activities): void {
            $activities->push((object) [
                'icon' => 'fas fa-shield-alt',
                'title' => 'Bảo hành '.$item->product_name.' còn '.$item->remaining_label,
                'meta' => 'Đơn #'.$item->order_code.' · hết hạn '.$item->warranty_ends_at_label,
                'display_time' => $item->order_date_label,
                'sort_at' => $this->dateTimestamp($item->order_created_at),
                'url' => $item->track_url,
            ]);
        });

        return $activities
            ->sortByDesc('sort_at')
            ->take(5)
            ->values();
    }

    private function accountOrdersForUser(int $userId, ?int $limit = null): Collection
    {
        if (! Schema::hasTable('orders')) {
            return collect();
        }

        $query = DB::table('orders')
            ->where('user_id', $userId)
            ->orderByDesc('created_at');

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query
            ->get()
            ->map(fn ($order) => $this->decorateAccountOrder($order));
    }

    private function decorateAccountOrder(object $order): object
    {
        $order->status_label = $this->orderStatusLabel($order->order_status);
        $order->status_badge_class = $this->orderStatusBadgeClass($order->order_status);
        $order->payment_label = $this->paymentStatusLabel($order->payment_status);
        $order->payment_badge_class = $this->paymentStatusBadgeClass($order->payment_status);
        $order->display_total = $this->formatCurrency((float) $order->total_amount);
        $order->display_date = $this->formatDate($order->created_at);
        $order->item_summary = $this->accountOrderItemSummary((int) $order->id);
        $order->track_url = url('/dash-track-order.html').'?order='.$order->id;
        $order->cancelable = in_array($order->order_status, ['pending', 'confirmed', 'processing'], true);

        return $order;
    }

    private function accountOrderItemSummary(int $orderId): string
    {
        if (! Schema::hasTable('order_items')) {
            return 'Chưa có sản phẩm';
        }

        $items = DB::table('order_items')
            ->where('order_id', $orderId)
            ->orderBy('id')
            ->get(['product_name', 'quantity']);

        if ($items->isEmpty()) {
            return 'Chưa có sản phẩm';
        }

        $firstItem = $items->first();
        $firstLabel = $firstItem->product_name.($firstItem->quantity > 1 ? ' x'.$firstItem->quantity : '');

        return $items->count() > 1
            ? $firstLabel.' + '.($items->count() - 1).' sản phẩm khác'
            : $firstLabel;
    }

    private function accountOrderItems(int $orderId): Collection
    {
        if (! Schema::hasTable('order_items')) {
            return collect();
        }

        return DB::table('order_items')
            ->where('order_id', $orderId)
            ->orderBy('id')
            ->get()
            ->map(function ($item) {
                $item->display_price = $this->formatCurrency((float) $item->price);
                $item->display_total = $this->formatCurrency((float) $item->total);
                $item->image = $item->product_image ?: 'template/images/loading.gif';

                return $item;
            });
    }

    private function accountOrderHistory(object $order): Collection
    {
        $history = collect();

        if (Schema::hasTable('order_status_histories')) {
            $history = DB::table('order_status_histories')
                ->where('order_id', $order->id)
                ->orderBy('created_at')
                ->get(['status', 'note', 'created_at']);
        }

        if ($history->isEmpty()) {
            $history = collect([
                (object) [
                    'status' => $order->order_status,
                    'note' => 'Trạng thái hiện tại của đơn hàng.',
                    'created_at' => $order->updated_at ?: $order->created_at,
                ],
            ]);
        }

        return $history->map(function ($row) {
            $row->status_label = $this->orderStatusLabel($row->status);
            $row->icon = $this->orderStatusIcon($row->status);
            $row->display_date = $this->formatDate($row->created_at);

            return $row;
        });
    }

    private function accountAddressesForUser(int $userId): Collection
    {
        if (! Schema::hasTable('user_addresses')) {
            return collect();
        }

        return DB::table('user_addresses')
            ->where('user_id', $userId)
            ->where('status', true)
            ->orderByDesc('is_default_shipping')
            ->orderByDesc('is_default_billing')
            ->orderByDesc('updated_at')
            ->get()
            ->map(function ($address) {
                $address->full_name = trim($address->first_name.' '.$address->last_name);
                $address->full_address = collect([
                    $address->address_line,
                    $address->address_line2,
                    $address->state,
                    $address->city,
                    $address->country,
                    $address->postal_code,
                ])->filter()->implode(', ');
                $address->type_label = match ($address->type) {
                    'shipping' => 'Giao hàng',
                    'billing' => 'Thanh toán',
                    default => 'Giao hàng và thanh toán',
                };
                $address->is_default = (bool) $address->is_default_shipping || (bool) $address->is_default_billing;

                return $address;
            });
    }

    private function accountPaymentMethodsForUser(int $userId): Collection
    {
        if (! Schema::hasTable('user_payment_methods')) {
            return collect();
        }

        return DB::table('user_payment_methods')
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->orderByDesc('is_default')
            ->orderByDesc('updated_at')
            ->get()
            ->map(function ($method) {
                $method->title = match ($method->type) {
                    'card' => trim(($method->card_brand ?: 'Thẻ').' ·•••• '.($method->last_four ?: '----')),
                    'paypal' => 'PayPal',
                    'bank_transfer' => $method->bank_name ?: 'Chuyển khoản ngân hàng',
                    default => $method->provider ?: 'Phương thức thanh toán',
                };

                $method->detail = match ($method->type) {
                    'card' => collect([
                        $method->card_holder,
                        $method->expiry_month && $method->expiry_year
                            ? 'hết hạn '.sprintf('%02d/%d', $method->expiry_month, $method->expiry_year)
                            : null,
                    ])->filter()->implode(' · '),
                    'paypal' => $method->paypal_email ?: 'Ví PayPal đã liên kết',
                    'bank_transfer' => $method->bank_name ?: 'Thanh toán chuyển khoản',
                    default => $method->provider ?: 'Đã lưu trong tài khoản',
                };

                $method->type_label = match ($method->type) {
                    'card' => 'Thẻ',
                    'paypal' => 'Ví điện tử',
                    'bank_transfer' => 'Ngân hàng',
                    default => 'Thanh toán',
                };

                return $method;
            });
    }

    private function activeWarrantyItems(int $userId): Collection
    {
        if (! Schema::hasTable('orders') || ! Schema::hasTable('order_items') || ! Schema::hasTable('products')) {
            return collect();
        }

        return DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.user_id', $userId)
            ->whereIn('orders.order_status', ['shipped', 'delivered', 'completed'])
            ->where('products.warranty_months', '>', 0)
            ->select([
                'order_items.id',
                'order_items.product_id',
                'order_items.product_name',
                'order_items.product_image',
                'order_items.quantity',
                'orders.id as order_id',
                'orders.order_code',
                'orders.created_at as order_created_at',
                'products.slug as product_slug',
                'products.warranty_months',
            ])
            ->orderByDesc('orders.created_at')
            ->get()
            ->map(function ($item) {
                $startedAt = Carbon::parse($item->order_created_at);
                $endsAt = $startedAt->copy()->addMonths((int) $item->warranty_months);
                $remainingDays = (int) now()->startOfDay()->diffInDays($endsAt, false);

                $item->quantity = max(1, (int) $item->quantity);
                $item->warranty_ends_at = $endsAt;
                $item->warranty_ends_at_label = $endsAt->format('d/m/Y');
                $item->remaining_days = $remainingDays;
                $item->remaining_label = $this->warrantyRemainingLabel($remainingDays);
                $item->order_date_label = $startedAt->format('d/m/Y');
                $item->track_url = url('/dash-track-order.html').'?order='.$item->order_id;
                $item->product_url = route('frontend.product', $item->product_slug);

                return $item;
            })
            ->filter(fn ($item): bool => $item->remaining_days >= 0)
            ->values();
    }

    private function wishlistProductsForUser(int $userId): Collection
    {
        if (! Schema::hasTable('wishlists') || ! Schema::hasTable('products')) {
            return collect();
        }

        return $this->decorateProducts(
            DB::table('wishlists')
                ->join('products', 'products.id', '=', 'wishlists.product_id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->join('categories', 'categories.id', '=', 'products.category_id')
                ->where('wishlists.user_id', $userId)
                ->where('products.status', 'active')
                ->select([
                    'products.*',
                    'brands.name as brand_name',
                    'brands.slug as brand_slug',
                    'categories.name as category_name',
                    'categories.slug as category_slug',
                    'wishlists.created_at as wishlist_added_at',
                ])
                ->orderByDesc('wishlists.created_at')
                ->get()
        );
    }

    private function orderStatusLabel(?string $status): string
    {
        return [
            'pending' => 'chờ xác nhận',
            'confirmed' => 'đã xác nhận',
            'processing' => 'đang xử lý',
            'shipping' => 'đang giao',
            'shipped' => 'đã giao',
            'delivered' => 'đã giao',
            'completed' => 'hoàn tất',
            'cancelled' => 'đã hủy',
            'returned' => 'đã trả hàng',
        ][$status] ?? 'đang cập nhật';
    }

    private function paymentStatusLabel(?string $status): string
    {
        return [
            'unpaid' => 'Chưa thanh toán',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thanh toán lỗi',
            'refunded' => 'Đã hoàn tiền',
        ][$status] ?? 'Đang cập nhật';
    }

    private function orderStatusBadgeClass(?string $status): string
    {
        return match ($status) {
            'completed', 'delivered', 'shipped' => 'status-badge',
            'cancelled', 'returned' => 'status-badge status-badge--muted',
            default => 'status-badge status-badge--warn',
        };
    }

    private function paymentStatusBadgeClass(?string $status): string
    {
        return $status === 'paid'
            ? 'status-badge'
            : 'status-badge status-badge--muted';
    }

    private function orderStatusIcon(?string $status): string
    {
        return match ($status) {
            'pending' => 'fas fa-clock',
            'confirmed' => 'fas fa-check',
            'processing' => 'fas fa-box',
            'shipping', 'shipped', 'delivered' => 'fas fa-truck',
            'completed' => 'fas fa-check-circle',
            'cancelled', 'returned' => 'fas fa-ban',
            default => 'fas fa-receipt',
        };
    }

    private function warrantyRemainingLabel(int $remainingDays): string
    {
        if ($remainingDays <= 30) {
            return max(0, $remainingDays).' ngày';
        }

        return max(1, (int) floor($remainingDays / 30)).' tháng';
    }

    private function formatDate(?string $value, string $format = 'd/m/Y H:i'): string
    {
        if (! $value) {
            return '';
        }

        try {
            return Carbon::parse($value)->format($format);
        } catch (Throwable) {
            return (string) $value;
        }
    }

    private function dateTimestamp(?string $value): int
    {
        if (! $value) {
            return 0;
        }

        try {
            return Carbon::parse($value)->timestamp;
        } catch (Throwable) {
            return 0;
        }
    }

    private function productQuery()
    {
        return DB::table('products')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('products.status', 'active')
            ->select([
                'products.*',
                'brands.name as brand_name',
                'brands.slug as brand_slug',
                'categories.name as category_name',
                'categories.slug as category_slug',
            ]);
    }

    private function categoryTiles(): Collection
    {
        $prioritySlugs = ['laptop', 'smartphone', 'monitor', 'audio', 'keyboard', 'pc-components'];
        $priorityOrder = collect($prioritySlugs)
            ->map(fn (string $slug, int $index): string => "WHEN '{$slug}' THEN {$index}")
            ->implode(' ');

        $tiles = DB::table('categories')
            ->whereNull('parent_id')
            ->where('status', true)
            ->whereIn('slug', $prioritySlugs)
            ->orderByRaw("CASE slug {$priorityOrder} ELSE 99 END")
            ->get();

        if ($tiles->count() < 6) {
            $tiles = $tiles->concat(
                $this->rootCategories()
                    ->whereNotIn('slug', $tiles->pluck('slug')->all())
                    ->take(6 - $tiles->count())
            );
        }

        return $tiles
            ->map(function ($category) {
                $meta = $this->categoryMeta($category->slug);
                $category->icon = $meta['icon'];
                $category->subtitle = $meta['subtitle'];

                return $category;
            });
    }

    private function rootCategories(): Collection
    {
        return DB::table('categories')
            ->whereNull('parent_id')
            ->where('status', true)
            ->orderBy('name')
            ->get();
    }

    private function categoryIdsForSlug(string $slug): array
    {
        $category = DB::table('categories')
            ->select('id')
            ->where('slug', $slug)
            ->where('status', true)
            ->first();

        if (! $category) {
            return [];
        }

        $childIds = DB::table('categories')
            ->where('parent_id', $category->id)
            ->where('status', true)
            ->pluck('id')
            ->all();

        return array_merge([$category->id], $childIds);
    }

    private function applyPriceFilter($query, string $price): void
    {
        $currentPrice = 'COALESCE(products.sale_price, products.price)';

        match ($price) {
            'under_5' => $query->whereRaw($currentPrice.' < ?', [5000000]),
            '5_15' => $query->whereRaw($currentPrice.' BETWEEN ? AND ?', [5000000, 15000000]),
            'over_15' => $query->whereRaw($currentPrice.' > ?', [15000000]),
            default => null,
        };
    }

    private function applySort($query, string $sort): void
    {
        match ($sort) {
            'price_asc' => $query->orderByRaw('COALESCE(products.sale_price, products.price) ASC'),
            'price_desc' => $query->orderByRaw('COALESCE(products.sale_price, products.price) DESC'),
            'newest' => $query->orderByDesc('products.created_at'),
            'best_selling' => $query->orderByDesc('products.sold_count'),
            default => $query->orderByDesc('products.is_featured')->orderByDesc('products.sold_count')->orderBy('products.name'),
        };
    }

    private function relatedProducts(object $product): Collection
    {
        $related = $this->decorateProducts(
            $this->productQuery()
                ->where('products.category_id', $product->category_id)
                ->where('products.id', '<>', $product->id)
                ->limit(4)
                ->get()
        );

        if ($related->count() >= 4) {
            return $related;
        }

        $moreProducts = $this->decorateProducts(
            $this->productQuery()
                ->where('products.id', '<>', $product->id)
                ->whereNotIn('products.id', $related->pluck('id')->all())
                ->orderByDesc('products.is_featured')
                ->limit(4 - $related->count())
                ->get()
        );

        return $related->concat($moreProducts)->values();
    }

    private function productReviewData(int $productId): array
    {
        if (! Schema::hasTable('reviews')) {
            return [
                'reviews' => collect(),
                'summary' => $this->emptyReviewSummary(),
            ];
        }

        $reviews = DB::table('reviews')
            ->leftJoin('users', 'users.id', '=', 'reviews.user_id')
            ->where('reviews.product_id', $productId)
            ->where('reviews.status', true)
            ->select('reviews.*', 'users.name as user_name')
            ->orderByDesc('reviews.created_at')
            ->limit(20)
            ->get()
            ->map(function ($review) {
                $displayName = $review->reviewer_name ?: ($review->user_name ?: 'Khách hàng');

                $review->display_name = $displayName;
                $review->initials = $this->reviewInitials($displayName);
                $review->display_date = $review->created_at
                    ? Carbon::parse($review->created_at)->format('d/m/Y')
                    : '';

                return $review;
            });

        $stats = DB::table('reviews')
            ->where('product_id', $productId)
            ->where('status', true)
            ->selectRaw('COUNT(*) as total, COALESCE(AVG(rating), 0) as average')
            ->first();

        $total = (int) ($stats->total ?? 0);
        $average = round((float) ($stats->average ?? 0), 1);
        $counts = DB::table('reviews')
            ->where('product_id', $productId)
            ->where('status', true)
            ->select('rating', DB::raw('COUNT(*) as total'))
            ->groupBy('rating')
            ->pluck('total', 'rating');

        $distribution = collect(range(5, 1))
            ->map(function (int $rating) use ($counts, $total): array {
                $count = (int) $counts->get($rating, 0);

                return [
                    'rating' => $rating,
                    'count' => $count,
                    'percent' => $total > 0 ? (int) round(($count / $total) * 100) : 0,
                ];
            })
            ->all();

        return [
            'reviews' => $reviews,
            'summary' => [
                'total' => $total,
                'average' => $average,
                'average_label' => number_format($average, 1, ',', '.'),
                'distribution' => $distribution,
            ],
        ];
    }

    private function emptyReviewSummary(): array
    {
        return [
            'total' => 0,
            'average' => 0.0,
            'average_label' => '0,0',
            'distribution' => collect(range(5, 1))
                ->map(fn (int $rating): array => [
                    'rating' => $rating,
                    'count' => 0,
                    'percent' => 0,
                ])
                ->all(),
        ];
    }

    private function reviewInitials(string $name): string
    {
        $words = collect(preg_split('/\s+/u', trim($name)) ?: [])
            ->filter()
            ->take(2)
            ->map(fn ($word): string => strtoupper(mb_substr((string) $word, 0, 1)))
            ->implode('');

        return $words !== '' ? $words : 'KH';
    }

    private function decorateProducts(Collection $products): Collection
    {
        $products = $products->map(fn ($product) => $this->decorateProduct($product));

        return $this->attachWishlistState($products);
    }

    private function attachWishlistState(Collection $products): Collection
    {
        if (! auth()->check() || $products->isEmpty() || ! Schema::hasTable('wishlists')) {
            return $products;
        }

        $productIds = $products
            ->pluck('id')
            ->filter()
            ->map(fn ($id): int => (int) $id)
            ->unique()
            ->values();

        if ($productIds->isEmpty()) {
            return $products;
        }

        $wishlistIds = DB::table('wishlists')
            ->where('user_id', auth()->id())
            ->whereIn('product_id', $productIds->all())
            ->pluck('product_id')
            ->map(fn ($id): int => (int) $id)
            ->all();

        return $products->map(function ($product) use ($wishlistIds) {
            $product->is_wishlisted = in_array((int) $product->id, $wishlistIds, true);

            return $product;
        });
    }

    private function activeCartItemForCurrentUser(int $itemId): ?object
    {
        return DB::table('cart_items')
            ->join('carts', 'carts.id', '=', 'cart_items.cart_id')
            ->join('products', 'products.id', '=', 'cart_items.product_id')
            ->where('cart_items.id', $itemId)
            ->where('carts.user_id', auth()->id())
            ->where('carts.status', 'active')
            ->select([
                'cart_items.id',
                'cart_items.cart_id',
                'cart_items.quantity',
                'cart_items.price',
                'products.price as regular_price',
                'products.quantity as stock_quantity',
                'products.status as product_status',
            ])
            ->first();
    }

    private function cartActionError(Request $request, string $message, int $status = 422): RedirectResponse|JsonResponse
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message], $status);
        }

        return back()->withErrors(['cart' => $message]);
    }

    private function cartItemPayload(object $cartItem, int $quantity): array
    {
        $stockQuantity = max(0, (int) $cartItem->stock_quantity);
        $unitPrice = (float) $cartItem->price;
        $regularPrice = (float) $cartItem->regular_price;

        return [
            'id' => (int) $cartItem->id,
            'quantity' => $quantity,
            'stock_quantity' => $stockQuantity,
            'decrease_quantity' => max(1, $quantity - 1),
            'increase_quantity' => min($stockQuantity, $quantity + 1),
            'decrease_disabled' => $quantity <= 1,
            'increase_disabled' => $quantity >= $stockQuantity,
            'display_line_total' => $this->formatCurrency($unitPrice * $quantity),
            'display_regular_line_total' => $this->formatCurrency($regularPrice * $quantity),
        ];
    }

    private function cartSummaryPayload(): array
    {
        $regularSubtotal = 0.0;
        $subtotal = 0.0;
        $itemCount = 0;

        if (auth()->check()) {
            $cartId = DB::table('carts')
                ->where('user_id', auth()->id())
                ->where('status', 'active')
                ->latest('updated_at')
                ->value('id');

            if ($cartId) {
                DB::table('cart_items')
                    ->join('products', 'products.id', '=', 'cart_items.product_id')
                    ->where('cart_items.cart_id', $cartId)
                    ->where('products.status', 'active')
                    ->select([
                        'cart_items.quantity',
                        'cart_items.price',
                        'products.price as regular_price',
                    ])
                    ->orderBy('cart_items.id')
                    ->get()
                    ->each(function ($item) use (&$regularSubtotal, &$subtotal, &$itemCount): void {
                        $quantity = max(1, (int) $item->quantity);

                        $regularSubtotal += (float) $item->regular_price * $quantity;
                        $subtotal += (float) $item->price * $quantity;
                        $itemCount++;
                    });
            }
        }

        $discount = max(0, $regularSubtotal - $subtotal);
        $total = $subtotal;

        return [
            'item_count' => $itemCount,
            'item_count_label' => $itemCount.' sản phẩm',
            'regular_subtotal' => $this->formatCurrency($regularSubtotal),
            'discount' => '-'.$this->formatCurrency($discount),
            'total' => $this->formatCurrency($total),
        ];
    }

    private function decorateProduct(object $product): object
    {
        $regularPrice = (float) $product->price;
        $salePrice = $product->sale_price !== null ? (float) $product->sale_price : null;
        $hasDiscount = $salePrice !== null && $salePrice > 0 && $salePrice < $regularPrice;
        $currentPrice = $hasDiscount ? $salePrice : $regularPrice;

        $product->current_price = $currentPrice;
        $product->has_discount = $hasDiscount;
        $product->display_price = $this->formatCurrency($currentPrice);
        $product->display_original_price = $hasDiscount ? $this->formatCurrency($regularPrice) : null;
        $product->discount_label = $hasDiscount
            ? '-'.max(1, (int) round((($regularPrice - $salePrice) / $regularPrice) * 100)).'%'
            : ((bool) $product->is_featured ? 'Hot' : 'Mới');
        $product->stock_label = ((int) $product->quantity > 0)
            ? 'Còn '.(int) $product->quantity.' sản phẩm'
            : 'Hết hàng';
        $product->teaser = Str::limit($product->short_description ?: strip_tags((string) $product->description), 86);
        $product->is_wishlisted = false;

        return $product;
    }

    private function formatCurrency(float $value): string
    {
        return number_format($value, 0, ',', '.').'đ';
    }

    private function categoryMeta(string $slug): array
    {
        return [
            'laptop' => ['icon' => 'fas fa-laptop', 'subtitle' => 'Văn phòng, học tập, gaming'],
            'smartphone' => ['icon' => 'fas fa-mobile-alt', 'subtitle' => 'iPhone và Android'],
            'monitor' => ['icon' => 'fas fa-desktop', 'subtitle' => 'Làm việc và giải trí'],
            'audio' => ['icon' => 'fas fa-headphones-alt', 'subtitle' => 'Tai nghe, loa, micro'],
            'keyboard' => ['icon' => 'fas fa-keyboard', 'subtitle' => 'Bàn phím văn phòng và cơ'],
            'pc-components' => ['icon' => 'fas fa-memory', 'subtitle' => 'SSD, RAM, VGA, mainboard'],
            'network' => ['icon' => 'fas fa-wifi', 'subtitle' => 'Router và mesh Wi-Fi'],
            'smart-home' => ['icon' => 'fas fa-plug', 'subtitle' => 'Sạc, camera, pin dự phòng'],
        ][$slug] ?? ['icon' => 'fas fa-microchip', 'subtitle' => 'Thiết bị công nghệ'];
    }
}
