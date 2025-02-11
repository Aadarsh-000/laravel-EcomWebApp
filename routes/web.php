<?php

use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;

Route::get('/', [MainController::class, 'index'])->name('home');
Route::get('/cart', [MainController::class, 'cart'])->name('cart');
Route::get('/checkout', [MainController::class, 'checkout'])->name('checkout');
Route::get('/shop', [MainController::class, 'shop'])->name('shop');
Route::get('/single/{id}', [MainController::class, 'singleProduct'])->name('single');

Route::get('/register', [MainController::class, 'register'])->name('register.form');
Route::post('/register', [MainController::class, 'registerUser'])->name('register.submit');

Route::get('/login', [MainController::class, 'login'])->name('login');
// Route::post('/login', [MainController::class, 'login'])->name('login');
Route::post('/login', [MainController::class, 'loginUser'])->name('login.submit');

Route::get('/logout', [MainController::class, 'logout'])->name('logout');

Route::view('/addToCart', 'addToCart')->name('addToCart'); 
Route::post('/addToCart',[MainController::class, 'addToCart'])->name('addToCart.submit');

Route::get('/deleteCartItem/{id}', [MainController::class, 'deleteCartItem'])->name('deleteCartItem');

Route::post('/updateCart', [MainController::class, 'updateCart'])->name('updateCart');

Route::post('/checkout', [MainController::class, 'checkoutItem'])->name('checkoutItem');

Route::post('/cart', [StripeController::class, 'stripePost'])->name('stripe.form');
Route::post('/stripe', [StripeController::class, 'charge'])->name('stripe.charge');