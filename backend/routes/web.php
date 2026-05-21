<?php

use App\Http\Controllers\Admin\AdminController;
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

Route::prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

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
