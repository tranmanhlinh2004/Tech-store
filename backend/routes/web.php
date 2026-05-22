<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\StorefrontController;
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

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin.role'])->group(function (): void {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/products', [AdminController::class, 'products'])->name('products.index');
    Route::get('/products/create', [AdminController::class, 'productCreate'])->name('products.create');
    Route::post('/products', [AdminController::class, 'productStore'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'productEdit'])->name('products.edit');
    Route::put('/products/{id}', [AdminController::class, 'productUpdate'])->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'productDestroy'])->name('products.destroy');

    Route::get('/product-images', [AdminController::class, 'productImages'])->name('product-images.index');
    Route::post('/product-images', [AdminController::class, 'productImagesUpdate'])->name('product-images.update');

    Route::get('/product-specifications', [AdminController::class, 'productSpecifications'])->name('product-specifications.index');
    Route::post('/product-specifications', [AdminController::class, 'productSpecificationsUpdate'])->name('product-specifications.update');

    Route::get('/orders', [AdminController::class, 'orders'])->name('orders.index');
    Route::patch('/orders/{id}', [AdminController::class, 'orderUpdate'])->name('orders.update');

    Route::get('/coupons', [AdminController::class, 'coupons'])->name('coupons.index');
    Route::get('/coupons/create', [AdminController::class, 'couponCreate'])->name('coupons.create');
    Route::post('/coupons', [AdminController::class, 'couponStore'])->name('coupons.store');
    Route::get('/coupons/{id}/edit', [AdminController::class, 'couponEdit'])->name('coupons.edit');
    Route::put('/coupons/{id}', [AdminController::class, 'couponUpdate'])->name('coupons.update');
    Route::delete('/coupons/{id}', [AdminController::class, 'couponDestroy'])->name('coupons.destroy');

    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews.index');
    Route::patch('/reviews/{id}', [AdminController::class, 'reviewUpdate'])->name('reviews.update');
    Route::delete('/reviews/{id}', [AdminController::class, 'reviewDestroy'])->name('reviews.destroy');

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
Route::get('/cart', [StorefrontController::class, 'cart'])->name('frontend.cart');
Route::post('/cart/items', [StorefrontController::class, 'addToCart'])->name('frontend.cart.store');
Route::patch('/cart/items/{item}', [StorefrontController::class, 'updateCartItem'])->name('frontend.cart.items.update');
Route::delete('/cart/items/{item}', [StorefrontController::class, 'removeCartItem'])->name('frontend.cart.items.destroy');
Route::view('/checkout', 'frontend.checkout')->name('frontend.checkout');
Route::view('/contact', 'frontend.contact')->name('frontend.contact');
Route::view('/about', 'frontend.about')->name('frontend.about');
Route::get('/login', fn () => redirect()->route('frontend.signin'))->name('login');
Route::get('/signin', [AuthController::class, 'signin'])->name('frontend.signin');
Route::post('/signin', [AuthController::class, 'login'])->name('frontend.signin.store');
Route::get('/signup', [AuthController::class, 'signup'])->name('frontend.signup');
Route::post('/signup', [AuthController::class, 'register'])->name('frontend.signup.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('frontend.logout');
Route::view('/wishlist', 'frontend.wishlist')->name('frontend.wishlist');
Route::view('/dashboard', 'frontend.dashboard')->middleware('auth')->name('frontend.dashboard');

Route::get('/{page}.html', function (string $page) {
    abort_unless(View::exists("frontend.$page"), 404);

    if (str_starts_with($page, 'dash-') && ! auth()->check()) {
        return redirect()->guest(route('frontend.signin'));
    }

    return view("frontend.$page");
})->where('page', '[A-Za-z0-9\-]+')->name('frontend.page');
