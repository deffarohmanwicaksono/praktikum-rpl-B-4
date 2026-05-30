<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Pages (butuh login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Home
    Route::get('/home', function () {
        return view('home.home');
    })->name('home');

    // Search
    Route::get('/search', [ProductController::class, 'search'])
    ->name('products.search');

    // Detail Product
    Route::get('/products/{id}', [ProductController::class, 'show'])
    ->name('products.detail-product');

    // Wishlist
    Route::view('/wishlist', 'wishlist.wishlist')
        ->name('wishlist');

    // Chat
    Route::view('/chat', 'chat.chat-list')
        ->name('chat.list');
    Route::view('/chat/session', 'chat.chat-session')
        ->name('chat.session');

    // Notification
    Route::view('/notification', 'notification.notification')
        ->name('notification');

    // Purchase History
    Route::view('/purchase-history', 'purchase.purchase-history')
        ->name('purchase.history');

    // Sales History
    Route::view('/sales-history', 'sales.sales-history')
        ->name('sales.history');

    // Seller
    Route::view('/dashboard-seller', 'seller.dashboard-seller')
        ->name('seller.dashboard-seller');
    Route::view('/seller/upload-product', 'seller.upload-product')
        ->name('seller.product.upload');
    Route::view('/seller/edit-product', 'seller.edit-product')
        ->name('seller.product.edit');

    // Profile
    Route::view('/profile', 'profile.profileuser')
        ->name('profile.profileuser');

});
