<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

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
