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
    Route::get('/', [AdminController::class, 'dashboard'])->middleware('admin.permission:dashboard.view')->name('dashboard');

    Route::get('/users', [AdminController::class, 'users'])->middleware('admin.permission:users.view')->name('users.index');
    Route::patch('/users/{id}/role', [AdminController::class, 'userRoleUpdate'])->middleware('admin.permission:users.update')->name('users.role.update');

    Route::get('/roles', [AdminController::class, 'roles'])->middleware('admin.permission:roles.manage')->name('roles.index');
    Route::post('/roles', [AdminController::class, 'roleStore'])->middleware('admin.permission:roles.manage')->name('roles.store');
    Route::put('/roles/{id}', [AdminController::class, 'roleUpdate'])->middleware('admin.permission:roles.manage')->name('roles.update');
    Route::delete('/roles/{id}', [AdminController::class, 'roleDestroy'])->middleware('admin.permission:roles.manage')->name('roles.destroy');

    Route::get('/products', [AdminController::class, 'products'])->middleware('admin.permission:products.view')->name('products.index');
    Route::get('/products/create', [AdminController::class, 'productCreate'])->middleware('admin.permission:products.create')->name('products.create');
    Route::post('/products', [AdminController::class, 'productStore'])->middleware('admin.permission:products.create')->name('products.store');
    Route::get('/products/{id}/edit', [AdminController::class, 'productEdit'])->middleware('admin.permission:products.update')->name('products.edit');
    Route::put('/products/{id}', [AdminController::class, 'productUpdate'])->middleware('admin.permission:products.update')->name('products.update');
    Route::delete('/products/{id}', [AdminController::class, 'productDestroy'])->middleware('admin.permission:products.delete')->name('products.destroy');

    Route::get('/product-images', [AdminController::class, 'productImages'])->middleware('admin.permission:products.update')->name('product-images.index');
    Route::post('/product-images', [AdminController::class, 'productImagesUpdate'])->middleware('admin.permission:products.update')->name('product-images.update');

    Route::get('/product-specifications', [AdminController::class, 'productSpecifications'])->middleware('admin.permission:products.update')->name('product-specifications.index');
    Route::post('/product-specifications', [AdminController::class, 'productSpecificationsUpdate'])->middleware('admin.permission:products.update')->name('product-specifications.update');

    Route::get('/orders', [AdminController::class, 'orders'])->middleware('admin.permission:orders.view')->name('orders.index');
    Route::patch('/orders/{id}', [AdminController::class, 'orderUpdate'])->middleware('admin.permission:orders.update')->name('orders.update');

    Route::get('/coupons', [AdminController::class, 'coupons'])->middleware('admin.permission:coupons.manage')->name('coupons.index');
    Route::get('/coupons/create', [AdminController::class, 'couponCreate'])->middleware('admin.permission:coupons.manage')->name('coupons.create');
    Route::post('/coupons', [AdminController::class, 'couponStore'])->middleware('admin.permission:coupons.manage')->name('coupons.store');
    Route::get('/coupons/{id}/edit', [AdminController::class, 'couponEdit'])->middleware('admin.permission:coupons.manage')->name('coupons.edit');
    Route::put('/coupons/{id}', [AdminController::class, 'couponUpdate'])->middleware('admin.permission:coupons.manage')->name('coupons.update');
    Route::delete('/coupons/{id}', [AdminController::class, 'couponDestroy'])->middleware('admin.permission:coupons.manage')->name('coupons.destroy');

    Route::get('/reviews', [AdminController::class, 'reviews'])->middleware('admin.permission:reviews.manage')->name('reviews.index');
    Route::patch('/reviews/{id}', [AdminController::class, 'reviewUpdate'])->middleware('admin.permission:reviews.manage')->name('reviews.update');
    Route::delete('/reviews/{id}', [AdminController::class, 'reviewDestroy'])->middleware('admin.permission:reviews.manage')->name('reviews.destroy');

    Route::get('/categories', [AdminController::class, 'categories'])->middleware('admin.permission:categories.manage')->name('categories.index');
    Route::get('/categories/create', [AdminController::class, 'categoryCreate'])->middleware('admin.permission:categories.manage')->name('categories.create');
    Route::post('/categories', [AdminController::class, 'categoryStore'])->middleware('admin.permission:categories.manage')->name('categories.store');
    Route::get('/categories/{id}/edit', [AdminController::class, 'categoryEdit'])->middleware('admin.permission:categories.manage')->name('categories.edit');
    Route::put('/categories/{id}', [AdminController::class, 'categoryUpdate'])->middleware('admin.permission:categories.manage')->name('categories.update');
    Route::delete('/categories/{id}', [AdminController::class, 'categoryDestroy'])->middleware('admin.permission:categories.manage')->name('categories.destroy');

    Route::get('/brands', [AdminController::class, 'brands'])->middleware('admin.permission:brands.manage')->name('brands.index');
    Route::get('/brands/create', [AdminController::class, 'brandCreate'])->middleware('admin.permission:brands.manage')->name('brands.create');
    Route::post('/brands', [AdminController::class, 'brandStore'])->middleware('admin.permission:brands.manage')->name('brands.store');
    Route::get('/brands/{id}/edit', [AdminController::class, 'brandEdit'])->middleware('admin.permission:brands.manage')->name('brands.edit');
    Route::put('/brands/{id}', [AdminController::class, 'brandUpdate'])->middleware('admin.permission:brands.manage')->name('brands.update');
    Route::delete('/brands/{id}', [AdminController::class, 'brandDestroy'])->middleware('admin.permission:brands.manage')->name('brands.destroy');

    Route::get('/banners', [AdminController::class, 'banners'])->middleware('admin.permission:banners.manage')->name('banners.index');
    Route::get('/banners/create', [AdminController::class, 'bannerCreate'])->middleware('admin.permission:banners.manage')->name('banners.create');
    Route::post('/banners', [AdminController::class, 'bannerStore'])->middleware('admin.permission:banners.manage')->name('banners.store');
    Route::get('/banners/{id}/edit', [AdminController::class, 'bannerEdit'])->middleware('admin.permission:banners.manage')->name('banners.edit');
    Route::put('/banners/{id}', [AdminController::class, 'bannerUpdate'])->middleware('admin.permission:banners.manage')->name('banners.update');
    Route::delete('/banners/{id}', [AdminController::class, 'bannerDestroy'])->middleware('admin.permission:banners.manage')->name('banners.destroy');
});

Route::get('/', [StorefrontController::class, 'home'])->name('frontend.home');

Route::get('/shop', [StorefrontController::class, 'shop'])->name('frontend.shop');
Route::get('/product/{slug?}', [StorefrontController::class, 'product'])->name('frontend.product');
Route::post('/product/{product}/reviews', [StorefrontController::class, 'storeReview'])->name('frontend.product.reviews.store');
Route::get('/cart', [StorefrontController::class, 'cart'])->name('frontend.cart');
Route::post('/cart/items', [StorefrontController::class, 'addToCart'])->name('frontend.cart.store');
Route::patch('/cart/items/{item}', [StorefrontController::class, 'updateCartItem'])->name('frontend.cart.items.update');
Route::delete('/cart/items/{item}', [StorefrontController::class, 'removeCartItem'])->name('frontend.cart.items.destroy');
Route::middleware('auth')->group(function (): void {
    Route::get('/checkout', [StorefrontController::class, 'checkout'])->name('frontend.checkout');
    Route::post('/checkout/buy-now', [StorefrontController::class, 'buyNowCheckout'])->name('frontend.checkout.buy-now');
    Route::post('/checkout', [StorefrontController::class, 'placeCodOrder'])->name('frontend.checkout.store');
});
Route::view('/contact', 'frontend.contact')->name('frontend.contact');
Route::view('/about', 'frontend.about')->name('frontend.about');
Route::get('/login', fn () => redirect()->route('frontend.signin'))->name('login');
Route::get('/signin', [AuthController::class, 'signin'])->name('frontend.signin');
Route::post('/signin', [AuthController::class, 'login'])->name('frontend.signin.store');
Route::get('/signup', [AuthController::class, 'signup'])->name('frontend.signup');
Route::post('/signup', [AuthController::class, 'register'])->name('frontend.signup.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('frontend.logout');
Route::get('/wishlist', [StorefrontController::class, 'wishlist'])->name('frontend.wishlist');
Route::middleware('auth')->group(function (): void {
    Route::post('/wishlist/items', [StorefrontController::class, 'addToWishlist'])->name('frontend.wishlist.items.store');
    Route::delete('/wishlist/items/{product}', [StorefrontController::class, 'removeFromWishlist'])->name('frontend.wishlist.items.destroy');
});
Route::get('/dashboard', [StorefrontController::class, 'dashboard'])->middleware('auth')->name('frontend.dashboard');
Route::middleware('auth')->group(function (): void {
    Route::get('/dash-my-order.html', [StorefrontController::class, 'accountOrders'])->name('frontend.account.orders');
    Route::get('/dash-manage-order.html', [StorefrontController::class, 'accountOrders'])->name('frontend.account.orders.manage');
    Route::get('/dash-track-order.html', [StorefrontController::class, 'accountTrackOrder'])->name('frontend.account.track');
    Route::get('/dash-my-profile.html', [StorefrontController::class, 'accountProfile'])->name('frontend.account.profile');
    Route::get('/dash-address-book.html', [StorefrontController::class, 'accountAddresses'])->name('frontend.account.addresses');
    Route::get('/dash-address-edit.html', [StorefrontController::class, 'accountAddressEdit'])->name('frontend.account.addresses.edit');
    Route::get('/dash-payment-option.html', [StorefrontController::class, 'accountPayments'])->name('frontend.account.payments');
    Route::get('/dash-cancellation.html', [StorefrontController::class, 'accountCancellation'])->name('frontend.account.cancellation');
});

Route::get('/{page}.html', function (string $page) {
    abort_unless(View::exists("frontend.$page"), 404);

    if (str_starts_with($page, 'dash-') && ! auth()->check()) {
        return redirect()->guest(route('frontend.signin'));
    }

    return view("frontend.$page");
})->where('page', '[A-Za-z0-9\-]+')->name('frontend.page');
