<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ChatController;
use App\Http\Middleware\RoleMiddleware;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::redirect('/', '/login');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Pages (Butuh Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ==========================================
    // ADMIN
    // ==========================================
    Route::middleware(RoleMiddleware::class . ':admin')->group(function () {
        
        // Dashboard
        Route::get('/admin/dashboard-admin', function () {
            return view('admin.dashboard-admin');
        })->name('admin.dashboard-admin');

        // Verifikasi Barang
        Route::get('/admin/verification', function () {
            return view('admin.verification');
        })->name('admin.verification');

        // Daftar Laporan
        Route::get('/admin/reports', [\App\Http\Controllers\AdminController::class, 'reportsIndex'])->name('admin.reports');
        Route::post('/admin/reports/{report}/action', [\App\Http\Controllers\AdminController::class, 'actionReport'])->name('admin.actionReport');
        Route::post('/admin/reports/{report}/reject', [\App\Http\Controllers\AdminController::class, 'rejectReport'])->name('admin.rejectReport');

        // Daftar User
        Route::get('/admin/users', function () {
            return view('admin.users');
        })->name('admin.users');

        // Daftar Produk
        Route::get('/admin/products', function () {
            return view('admin.products');
        })->name('admin.products');

        // Daftar Transaksi
        Route::get('/admin/transactions', function () {
            return view('admin.transactions');
        })->name('admin.transactions');

    });

    // ==========================================
    // USER (Buyer & Seller)
    // ==========================================
    
    // Home & Pencarian
    Route::get('/home', function () {
        return view('home.home');
    })->name('home');

    Route::get('/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.detail-product');
    Route::view('/wishlist', 'wishlist.wishlist')->name('wishlist');
    Route::post('/reports', [\App\Http\Controllers\ReportController::class, 'store'])->name('report.store');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.list');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/{chat}', [ChatController::class, 'show'])->name('chat.session');
    Route::post('/chat/{chat}/message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
    Route::post('/chat/{chat}/purchase-link', [ChatController::class, 'sendPurchaseLink'])->name('chat.sendPurchaseLink');

    // Kirim Link Pembelian
    Route::get('/chat/{chat}/purchase-link', [ChatController::class, 'showPurchaseLinkForm'])
        ->name('chat.purchaseLinkForm');

    // Checkout & Pembayaran
    Route::get('/checkout/{token}', [CheckoutController::class, 'showCheckout'])->name('checkout');
    Route::post('/checkout/{token}', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/{transaction}/upload-proof', [CheckoutController::class, 'showUploadProof'])->name('checkout.uploadProofForm');
    Route::post('/checkout/{transaction}/upload-proof', [CheckoutController::class, 'uploadProof'])->name('checkout.uploadProof');
    
    // Notifikasi & Profil
    Route::view('/notification', 'notification.notification')->name('notification');
    Route::view('/profile', 'profile.profile-user')->name('profile.profile-user');
    Route::post('/profile/become-seller', function () {
        $user = auth()->user();
        if ($user->role === 'buyer') {
            $user->update(['role' => 'seller']);
        }
        return back()->with('success', 'Akun Seller Anda berhasil diaktifkan! Silakan mulai mengunggah produk.');
    })->name('profile.become-seller');

    // Riwayat (Purchase & Sales)
    Route::view('/purchase-history', 'history.purchase-history')->name('history.purchase-history');
    Route::view('/sales-history', 'history.sales-history')->name('history.sales-history');

    // Seller
    Route::view('/dashboard-seller', 'seller.dashboard-seller')->name('seller.dashboard-seller');
    Route::view('/seller/upload-product', 'seller.upload-product')->name('seller.product.upload');
    Route::get('/seller/edit-product/{id}', [ProductController::class, 'edit'])->name('seller.product.edit');
    Route::put('/seller/edit-product/{id}', [ProductController::class, 'update'])->name('seller.product.update');
    Route::delete('/seller/edit-product/{id}', [ProductController::class, 'destroy'])->name('seller.product.destroy');
    Route::get('/seller/{id}', function ($id) {
        return view('profile.profile-seller');
        })->name('seller.profile');

});
