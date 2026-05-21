<?php

<<<<<<< HEAD
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Frontend\StorefrontController;
=======
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
>>>>>>> c26fec94b452115294db3ed22132452432b20e10
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

Route::get('/template/{path}', function (string $path) {
    $basePath = realpath(base_path('../frontend/public/template'));

    abort_if($basePath === false, 404);

    $filePath = realpath($basePath.DIRECTORY_SEPARATOR.$path);

    abort_if($filePath === false || ! is_file($filePath), 404);

    $normalizedBasePath = rtrim(str_replace('\\', '/', $basePath), '/').'/';
    $normalizedFilePath = str_replace('\\', '/', $filePath);

    abort_unless(str_starts_with($normalizedFilePath, $normalizedBasePath), 404);

    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    $mimeTypes = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
        'webp' => 'image/webp',
        'eot' => 'application/vnd.ms-fontobject',
        'ttf' => 'font/ttf',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'mp3' => 'audio/mpeg',
        'mp4' => 'video/mp4',
    ];

    return response()->file($filePath, [
        'Content-Type' => $mimeTypes[$extension] ?? 'application/octet-stream',
    ]);
})->where('path', '.*')->name('frontend.asset');

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

<<<<<<< HEAD
    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::get('/products/create', [AdminController::class, 'productCreate'])->name('products.create');
    Route::post('/products', [AdminController::class, 'productStore'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'productEdit'])->name('products.edit');
    Route::put('/products/{id}', [AdminController::class, 'productUpdate'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'productDestroy'])->name('products.destroy');

    Route::get('/categories', [AdminController::class, 'categories'])->name('categories.index');
    Route::get('/categories/create', [AdminController::class, 'categoryCreate'])->name('categories.create');
    Route::post('/categories', [AdminController::class, 'categoryStore'])->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminController::class, 'categoryEdit'])->name('categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'categoryUpdate'])->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'categoryDestroy'])->name('categories.destroy');

    Route::get('/brands', [AdminController::class, 'brands'])->name('brands.index');
    Route::get('/brands/create', [AdminController::class, 'brandCreate'])->name('brands.create');
    Route::post('/brands', [AdminController::class, 'brandStore'])->name('brands.store');
    Route::get('/brands/{id}/edit', [AdminController::class, 'brandEdit'])->name('brands.edit');
    Route::put('/brands/{id}', [AdminController::class, 'brandUpdate'])->name('brands.update');
    Route::delete('/brands/{id}', [AdminController::class, 'brandDestroy'])->name('brands.destroy');

    Route::get('/banners', [AdminController::class, 'banners'])->name('banners.index');
    Route::get('/banners/create', [AdminController::class, 'bannerCreate'])->name('banners.create');
    Route::post('/banners', [AdminController::class, 'bannerStore'])->name('banners.store');
    Route::get('/banners/{id}/edit', [AdminController::class, 'bannerEdit'])->name('banners.edit');
    Route::put('/banners/{id}', [AdminController::class, 'bannerUpdate'])->name('banners.update');
    Route::delete('/banners/{id}', [AdminController::class, 'bannerDestroy'])->name('banners.destroy');
});

Route::get('/', [StorefrontController::class, 'home'])->name('frontend.home');

Route::get('/shop', [StorefrontController::class, 'shop'])->name('frontend.shop');
Route::get('/product/{slug?}', [StorefrontController::class, 'product'])->name('frontend.product');
=======
Route::get('/shop', function (Request $request) {
    $selectedCategoryId = $request->integer('category') ?: null;
    $searchKeyword = trim((string) $request->query('q', ''));
    $sort = (string) $request->query('sort', 'featured');

    $categories = DB::table('categories')
        ->select(
            'categories.id',
            'categories.parent_id',
            'categories.name',
            'categories.slug',
            'categories.description',
            'categories.image'
        )
        ->where('categories.status', 1)
        ->orderByRaw('categories.parent_id IS NOT NULL')
        ->orderBy('categories.name')
        ->get();

    $productCountsByCategory = DB::table('products')
        ->select('category_id', DB::raw('COUNT(*) as total'))
        ->where('status', 'active')
        ->groupBy('category_id')
        ->pluck('total', 'category_id');

    $categories = $categories->map(function ($category) use ($categories, $productCountsByCategory) {
        $childIds = $categories
            ->where('parent_id', $category->id)
            ->pluck('id');

        $category->products_count = (int) ($productCountsByCategory[$category->id] ?? 0)
            + $childIds->sum(fn ($childId) => (int) ($productCountsByCategory[$childId] ?? 0));

        return $category;
    });

    $brands = DB::table('brands')
        ->select('id', 'name')
        ->where('status', 1)
        ->orderBy('name')
        ->get();

    $categoryIds = collect();

    if ($selectedCategoryId !== null) {
        $categoryIds = DB::table('categories')
            ->where('id', $selectedCategoryId)
            ->orWhere('parent_id', $selectedCategoryId)
            ->pluck('id');
    }

    $productsQuery = DB::table('products')
        ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
        ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
        ->select(
            'products.id',
            'products.category_id',
            'products.brand_id',
            'products.name',
            'products.slug',
            'products.sku',
            'products.short_description',
            'products.description',
            'products.price',
            'products.sale_price',
            'products.quantity',
            'products.warranty_months',
            'products.thumbnail',
            'products.is_featured',
            'products.sold_count',
            'products.view_count',
            'products.created_at',
            'categories.name as category_name',
            'brands.name as brand_name'
        )
        ->where('products.status', 'active');

    if ($categoryIds->isNotEmpty()) {
        $productsQuery->whereIn('products.category_id', $categoryIds);
    }

    if ($searchKeyword !== '') {
        $productsQuery->where(function ($query) use ($searchKeyword): void {
            $query->where('products.name', 'like', "%{$searchKeyword}%")
                ->orWhere('products.sku', 'like', "%{$searchKeyword}%")
                ->orWhere('products.short_description', 'like', "%{$searchKeyword}%")
                ->orWhere('brands.name', 'like', "%{$searchKeyword}%")
                ->orWhere('categories.name', 'like', "%{$searchKeyword}%");
        });
    }

    match ($sort) {
        'price_asc' => $productsQuery->orderByRaw('COALESCE(products.sale_price, products.price) asc'),
        'price_desc' => $productsQuery->orderByRaw('COALESCE(products.sale_price, products.price) desc'),
        'newest' => $productsQuery->orderByDesc('products.created_at'),
        default => $productsQuery->orderByDesc('products.is_featured')->orderByDesc('products.sold_count')->orderBy('products.name'),
    };

    $products = $productsQuery
        ->paginate(12)
        ->withQueryString();

    return view('frontend.shop-side-version-2', [
        'categories' => $categories,
        'brands' => $brands,
        'products' => $products,
        'totalProductsCount' => (int) $productCountsByCategory->sum(),
        'selectedCategoryId' => $selectedCategoryId,
        'searchKeyword' => $searchKeyword,
        'sort' => $sort,
    ]);
})->name('frontend.shop');

Route::get('/product/{product?}', function (?int $product = null) {
    $productRecord = DB::table('products')
        ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
        ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
        ->select(
            'products.id',
            'products.category_id',
            'products.brand_id',
            'products.name',
            'products.slug',
            'products.sku',
            'products.short_description',
            'products.description',
            'products.price',
            'products.sale_price',
            'products.quantity',
            'products.warranty_months',
            'products.thumbnail',
            'products.is_featured',
            'products.sold_count',
            'products.view_count',
            'categories.name as category_name',
            'brands.name as brand_name'
        )
        ->where('products.status', 'active')
        ->when($product !== null, fn ($query) => $query->where('products.id', $product))
        ->when($product === null, fn ($query) => $query->orderByDesc('products.is_featured')->orderBy('products.id'))
        ->first();

    abort_if($productRecord === null, 404);

    $images = DB::table('product_images')
        ->where('product_id', $productRecord->id)
        ->orderByDesc('is_main')
        ->orderBy('sort_order')
        ->get();

    $specifications = DB::table('product_specifications')
        ->where('product_id', $productRecord->id)
        ->orderBy('sort_order')
        ->get();

    $relatedProducts = DB::table('products')
        ->leftJoin('brands', 'products.brand_id', '=', 'brands.id')
        ->select(
            'products.id',
            'products.name',
            'products.short_description',
            'products.price',
            'products.sale_price',
            'products.thumbnail',
            'brands.name as brand_name'
        )
        ->where('products.status', 'active')
        ->where('products.category_id', $productRecord->category_id)
        ->where('products.id', '<>', $productRecord->id)
        ->orderByDesc('products.is_featured')
        ->limit(4)
        ->get();

    return view('frontend.product-detail', [
        'product' => $productRecord,
        'images' => $images,
        'specifications' => $specifications,
        'relatedProducts' => $relatedProducts,
    ]);
})->whereNumber('product')->name('frontend.product');
>>>>>>> c26fec94b452115294db3ed22132452432b20e10
Route::view('/cart', 'frontend.cart')->name('frontend.cart');
Route::view('/checkout', 'frontend.checkout')->name('frontend.checkout');
Route::view('/contact', 'frontend.contact')->name('frontend.contact');
Route::view('/about', 'frontend.about')->name('frontend.about');
Route::view('/signin', 'frontend.signin')->name('frontend.signin');
Route::view('/signup', 'frontend.signup')->name('frontend.signup');
Route::view('/wishlist', 'frontend.wishlist')->name('frontend.wishlist');
Route::view('/dashboard', 'frontend.dashboard')->name('frontend.dashboard');

Route::get('/{page}.html', function (string $page) {
    abort_unless(View::exists("frontend.$page"), 404);

    return view("frontend.$page");
})->where('page', '[A-Za-z0-9\-]+')->name('frontend.page');
