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

            $product = $this->decorateProduct($product);

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
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'title' => ['nullable', 'string', 'max:120'],
            'comment' => ['required', 'string', 'min:10', 'max:1200'],
            'reviewer_name' => [$user ? 'nullable' : 'required', 'string', 'max:255'],
            'reviewer_email' => [$user ? 'nullable' : 'required', 'email', 'max:255'],
        ]);

        DB::table('reviews')->insert([
            'user_id' => $user?->id,
            'product_id' => $productRow->id,
            'reviewer_name' => $user?->name ?: ($validated['reviewer_name'] ?? null),
            'reviewer_email' => $user?->email ?: ($validated['reviewer_email'] ?? null),
            'rating' => (int) $validated['rating'],
            'title' => $validated['title'] ?? null,
            'comment' => $validated['comment'],
            'status' => true,
            'created_at' => now(),
        ]);

        return redirect(route('frontend.product', $productRow->slug).'#reviews')
            ->with('status', 'Cảm ơn bạn đã gửi đánh giá sản phẩm.');
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
            ->map(fn (string $word): string => Str::upper(Str::substr($word, 0, 1)))
            ->implode('');

        return $words !== '' ? $words : 'KH';
    }

    private function decorateProducts(Collection $products): Collection
    {
        return $products->map(fn ($product) => $this->decorateProduct($product));
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
