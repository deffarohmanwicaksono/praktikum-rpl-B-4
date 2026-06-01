<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ChatController;
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
        // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.list');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/{chat}', [ChatController::class, 'show'])->name('chat.session');
    Route::post('/chat/{chat}/message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
    Route::post('/chat/{chat}/purchase-link', [ChatController::class, 'sendPurchaseLink'])->name('chat.sendPurchaseLink');


    // Kirim Link Pembelian
    Route::view('/checkout/purchase-link', 'checkout.purchase-link')
        ->name('checkout.purchase-link');

    // Checkout
    
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
    Route::get('/seller/edit-product/{id}', [ProductController::class, 'edit'])
        ->name('seller.product.edit');
    Route::put('/seller/edit-product/{id}', [ProductController::class, 'update'])
        ->name('seller.product.update');
    Route::delete('/seller/edit-product/{id}', [ProductController::class, 'destroy'])
        ->name('seller.product.destroy');
    // Profile
    Route::view('/profile', 'profile.profileuser')
        ->name('profile.profileuser');

});
