<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WishlistController;
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
        Route::get('/admin/dashboard-admin', [AdminController::class, 'dashboardIndex'])->name('admin.dashboard-admin');

        // Verifikasi Barang
        Route::get('/admin/verification', [AdminController::class, 'verificationIndex'])->name('admin.verification');
        Route::post('/admin/verification/{product}/approve', [AdminController::class, 'approveProduct'])->name('admin.approveProduct');
        Route::post('/admin/verification/{product}/reject', [AdminController::class, 'rejectProduct'])->name('admin.rejectProduct');

        // Daftar Laporan
        Route::get('/admin/reports', [AdminController::class, 'reportsIndex'])->name('admin.reports');
        Route::post('/admin/reports/{report}/action', [AdminController::class, 'actionReport'])->name('admin.actionReport');
        Route::post('/admin/reports/{report}/reject', [AdminController::class, 'rejectReport'])->name('admin.rejectReport');

        // Daftar User
        Route::get('/admin/users', [AdminController::class, 'usersIndex'])->name('admin.users');
        Route::post('/admin/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');

        // Daftar Produk
        Route::get('/admin/products', [AdminController::class, 'productsIndex'])->name('admin.products');
        Route::delete('/admin/products/{product}', [AdminController::class, 'deleteProduct'])->name('admin.products.delete');

        // Daftar Transaksi
        Route::get('/admin/transactions', [AdminController::class, 'transactionsIndex'])->name('admin.transactions');
    });

    // ==========================================
    // USER (Buyer & Seller)
    // ==========================================

    // Home & Pencarian
    Route::get('/home', [ProductController::class, 'index'])->name('home');
    Route::get('/search', [ProductController::class, 'search'])->name('products.search');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.detail-product');
    Route::post('/reports', [ReportController::class, 'store'])->name('report.store');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');          // toggle tambah/hapus
    Route::delete('/wishlist/{productId}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::delete('/wishlist-clear', [WishlistController::class, 'clearAll'])->name('wishlist.clear');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.list');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/{chat}', [ChatController::class, 'show'])->name('chat.session');
    Route::post('/chat/{chat}/message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
    Route::post('/chat/{chat}/purchase-link', [ChatController::class, 'sendPurchaseLink'])->name('chat.sendPurchaseLink');

    // Kirim Link Pembelian
    Route::get('/chat/{chat}/purchase-link', [ChatController::class, 'showPurchaseLinkForm'])->name('chat.purchaseLinkForm');

    // Checkout & Pembayaran
    Route::get('/checkout/{token}', [CheckoutController::class, 'showCheckout'])->name('checkout');
    Route::post('/checkout/{token}', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/{transaction}/upload-proof', [CheckoutController::class, 'showUploadProof'])->name('checkout.uploadProofForm');
    Route::post('/checkout/{transaction}/upload-proof', [CheckoutController::class, 'uploadProof'])->name('checkout.uploadProof');

    // Notifikasi & Profil
    Route::get('/notification', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notification');
    Route::view('/profile', 'profile.profile-user')->name('profile.profile-user');
    Route::post('/profile/become-seller', function () {
        $user = auth()->user();
        $roles = $user->roles ?? [];
        if (!in_array('seller', $roles)) {
            $roles[] = 'seller';
            $user->update(['roles' => $roles]);
        }
        return back()->with('success', 'Akun Seller Anda berhasil diaktifkan! Silakan mulai mengunggah produk.');
    })->name('profile.become-seller');

    // Riwayat (Purchase & Sales)
    Route::get('/purchase-history', [\App\Http\Controllers\HistoryController::class, 'purchaseHistory'])->name('history.purchase-history');
    Route::get('/sales-history', [\App\Http\Controllers\HistoryController::class, 'salesHistory'])->name('history.sales-history');
    Route::post('/transactions/{transaction}/close', [\App\Http\Controllers\HistoryController::class, 'closeTransaction'])->name('history.close-transaction');

    // Seller
    Route::get('/dashboard-seller', [ProductController::class, 'sellerDashboard'])->name('seller.dashboard-seller');
    Route::view('/seller/upload-product', 'seller.upload-product')->name('seller.product.upload');
    Route::post('/seller/upload-product', [ProductController::class, 'store'])->name('seller.product.store');
    Route::get('/seller/edit-product/{id}', [ProductController::class, 'edit'])->name('seller.product.edit');
    Route::put('/seller/edit-product/{id}', [ProductController::class, 'update'])->name('seller.product.update');
    Route::delete('/seller/edit-product/{id}', [ProductController::class, 'destroy'])->name('seller.product.destroy');
    Route::get('/seller/{id}', [ProductController::class, 'sellerProfile'])->name('seller.profile');
});