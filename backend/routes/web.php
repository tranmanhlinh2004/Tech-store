<?php

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

Route::view('/', 'frontend.index')->name('frontend.home');

Route::view('/shop', 'frontend.shop-side-version-2')->name('frontend.shop');
Route::view('/product', 'frontend.product-detail')->name('frontend.product');
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
