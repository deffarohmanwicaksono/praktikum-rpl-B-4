<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\HistoryController;

/*
|--------------------------------------------------------------------------
| API Routes — SeMart Mobile (Buyer POV)
|--------------------------------------------------------------------------
*/

// ── Public (tidak butuh token) ─────────────────────────────────────────
Route::post('/login', [AuthController::class, 'login']);

// ── Protected (butuh token Sanctum) ───────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth & Profil
    Route::post('/logout',  [AuthController::class, 'logout']);
    Route::get('/profile',  [AuthController::class, 'profile']);

    // Beranda & Produk
    Route::get('/home',                    [ProductController::class, 'index']);
    Route::get('/search',                  [ProductController::class, 'search']);
    Route::get('/products/{id}',           [ProductController::class, 'show']);
    Route::get('/seller/{id}/profile',     [ProductController::class, 'sellerProfile']);

    // Laporan Produk
    Route::post('/reports', [ReportController::class, 'store']);

    // Wishlist
    Route::get('/wishlist',                [WishlistController::class, 'index']);
    Route::post('/wishlist',               [WishlistController::class, 'store']);       // toggle tambah/hapus
    Route::delete('/wishlist/{productId}', [WishlistController::class, 'destroy']);
    Route::delete('/wishlist-clear',       [WishlistController::class, 'clearAll']);

    // Chat
    Route::get('/chat',                                  [ChatController::class, 'index']);
    Route::post('/chat',                                 [ChatController::class, 'store']);          // buat sesi baru
    Route::get('/chat/{chat}',                           [ChatController::class, 'show']);           // isi chat + pesan
    Route::post('/chat/{chat}/message',                  [ChatController::class, 'sendMessage']);    // kirim pesan
    Route::post('/chat/{chat}/purchase-link',            [ChatController::class, 'sendPurchaseLink']); // seller kirim link

    // Checkout & Pembayaran
    Route::get('checkout/{token}',                           [CheckoutController::class, 'show'])->name('checkout.show'); // detail link
    Route::post('/checkout/{token}',                         [CheckoutController::class, 'store']);        // proses checkout
    Route::post('/checkout/{transaction}/upload-proof',      [CheckoutController::class, 'uploadProof']);  // upload bukti

    // Notifikasi
    Route::get('/notification',       [NotificationController::class, 'index']);       // list + mark all read
    Route::get('/notification/count', [NotificationController::class, 'unreadCount']); // badge count saja

    // Riwayat Transaksi
    Route::get('/purchase-history',                  [HistoryController::class, 'purchaseHistory']);
    Route::get('/sales-history',                     [HistoryController::class, 'salesHistory']);
    Route::patch('/transaction/{transaction}/close', [HistoryController::class, 'closeTransaction']); // seller selesaikan
    Route::post('/transaction/{transaction}/review', [\App\Http\Controllers\Api\ReviewController::class, 'store']);
});