<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Views
|--------------------------------------------------------------------------
*/

Route::view('/login', 'auth.login')
    ->name('login');

Route::post('/login', function () {

    $validatedCredentials = request()->validate([

        'email' => [
            'required',
            'email',
            'ends_with:@student.uns.ac.id'
        ],

        'password' => [
            'required'
        ]

    ], [

        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.ends_with' => 'Gunakan email SSO UNS.',

        'password.required' => 'Password wajib diisi.'

    ]);

    if (Auth::attempt($validatedCredentials)) {

        request()->session()->regenerate();

        return redirect()->route('home');
    }

    return back()->withErrors([
        'login' => 'Email atau password salah.'
    ]);

})->name('login.process');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', function () {

    Auth::logout();

    request()->session()->invalidate();

    request()->session()->regenerateToken();

    return redirect()->route('login');

})->name('logout');

/*
|--------------------------------------------------------------------------
| DUMMY PRODUCTS DATA
|--------------------------------------------------------------------------
*/

$dummyProducts = [

    1 => [
        'id' => 1,
        'name' => 'Laptop MacBook Air M1 2020',
        'price' => 'Rp 7.500.000',
        'category' => 'Elektronik',
        'condition' => 'Bekas Seperti Baru',
        'description' => 'Laptop andalan dengan performa chip M1 yang masih sangat kencang untuk kebutuhan kuliah, browsing, desain grafis ringan, hingga editing video/foto. Sangat cocok bagi mahasiswa atau pekerja kreatif yang membutuhkan mobilitas tinggi.',
        'image' => asset('images/Elemen-1.png'),
        'gallery' => [
            asset('images/Elemen-1.png'),
            asset('images/Elemen-1.png'),
            asset('images/Elemen-1.png'),
            asset('images/Elemen-1.png'),
        ]
    ]

];

/*
|--------------------------------------------------------------------------
| Home Page
|--------------------------------------------------------------------------
*/

Route::get('/home', function () use ($dummyProducts) {

    return view('home.home', [
        'products' => $dummyProducts
    ]);

})->name('home');

/*
|--------------------------------------------------------------------------
| Search Page
|--------------------------------------------------------------------------
*/

Route::get('/search', function () use ($dummyProducts) {

    $keyword = request('q');

    return view('products.search', [
        'keyword' => $keyword,
        'products' => $dummyProducts
    ]);

})->name('products.search');

/*
|--------------------------------------------------------------------------
| Detail Product Page
|--------------------------------------------------------------------------
*/

Route::get('/products/{id}', function ($id) use ($dummyProducts) {

    return view('products.detail-product', [
        'product' => $dummyProducts[1]
    ]);

})->name('products.detail-product');

/*
|--------------------------------------------------------------------------
| Wishlist Page
|--------------------------------------------------------------------------
*/

Route::view('/wishlist', 'wishlist.wishlist')
    ->name('wishlist');

/*
|--------------------------------------------------------------------------
| Chat Page
|--------------------------------------------------------------------------
*/

Route::view('/chat', 'chat.chat-list')
    ->name('chat.list');

Route::view('/chat/session', 'chat.chat-session')
    ->name('chat.session');

/*
|--------------------------------------------------------------------------
| Notification Page
|--------------------------------------------------------------------------
*/

Route::view('/notification', 'notification.notification')
    ->name('notification');

/*
|--------------------------------------------------------------------------
| Purchase History Page
|--------------------------------------------------------------------------
*/

Route::view('/purchase-history', 'purchase.purchase-history')
    ->name('purchase.history');

/*
|--------------------------------------------------------------------------
| Sales History Page
|--------------------------------------------------------------------------
*/

Route::view('/sales-history', 'sales.sales-history')
    ->name('sales.history');

/*
|--------------------------------------------------------------------------
| Seller Dashboard Page
|--------------------------------------------------------------------------
*/

Route::view('/dashboard-seller', 'seller.dashboard-seller')
    ->name('seller.dashboard-seller');

/*
|--------------------------------------------------------------------------
| Upload Product Page
|--------------------------------------------------------------------------
*/

Route::view('/seller/upload-product', 'seller.upload-product')
    ->name('seller.product.upload');

    
/*
|--------------------------------------------------------------------------
| Edit Product Page
|--------------------------------------------------------------------------
*/

Route::view('/seller/edit-product', 'seller.edit-product')
    ->name('seller.product.edit');

/*
|--------------------------------------------------------------------------
| Profile Page
|--------------------------------------------------------------------------
*/

Route::view('/profile', 'profile.profileuser')
    ->name('profile.profileuser');