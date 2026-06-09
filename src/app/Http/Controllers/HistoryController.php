<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Review;
use App\Models\Notification;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    /**
     * Display the purchase history for the buyer.
     */
    public function purchaseHistory()
    {
        $transactionsQuery = Transaction::with(['product.productImages', 'product.user', 'purchaseLink'])
            ->where('buyer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $purchaseHistory = [];
        foreach ($transactionsQuery as $trx) {
            $images = $trx->product->productImages->pluck('image_url')->toArray();
            $mainImage = empty($images) ? asset('images/default-product.jpg') : (str_starts_with($images[0], 'http') ? $images[0] : asset($images[0]));
            
            $statusClass = '';
            $statusText = '';
            switch ($trx->status) {
                case 'menunggu_pembayaran':
                case 'dibayar':
                    $statusClass = 'status-menunggu';
                    $statusText = 'Menunggu Konfirmasi';
                    break;
                case 'selesai':
                    $statusClass = 'status-selesai';
                    $statusText = 'Selesai';
                    break;
                case 'gagal':
                    $statusClass = 'status-gagal';
                    $statusText = 'Gagal';
                    break;
            }

            // Check if already reviewed
            $hasReviewed = Review::where('transaction_id', $trx->id)->exists();

            $purchaseHistory[] = [
                'id' => $trx->transaction_code ?? ('TRX-' . str_pad($trx->id, 4, '0', STR_PAD_LEFT)),
                'raw_id' => $trx->id,
                'product_name' => $trx->product->name,
                'seller' => $trx->product->user->name,
                'price' => 'Rp ' . number_format($trx->total_price, 0, ',', '.'),
                'price_raw' => $trx->total_price,
                'date' => $trx->created_at->format('d M Y'),
                'time' => $trx->created_at->format('H:i') . ' WIB',
                'timestamp' => $trx->created_at->toIso8601String(),
                'status' => $statusText,
                'status_class' => $statusClass,
                'image' => $mainImage,
                'note' => $trx->purchaseLink->note ?? '',
                'payment_proof' => $trx->payment_proof ? asset($trx->payment_proof) : '',
                'has_reviewed' => $hasReviewed
            ];
        }

        return view('history.purchase-history', compact('purchaseHistory'));
    }

    /**
     * Display the sales history for the seller.
     */
    public function salesHistory()
    {
        $transactionsQuery = Transaction::with(['product.productImages', 'buyer', 'purchaseLink'])
            ->whereHas('product', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $salesHistory = [];
        foreach ($transactionsQuery as $trx) {
            $images = $trx->product->productImages->pluck('image_url')->toArray();
            $mainImage = empty($images) ? asset('images/default-product.jpg') : (str_starts_with($images[0], 'http') ? $images[0] : asset($images[0]));
            
            $statusClass = '';
            $statusText = '';
            switch ($trx->status) {
                case 'menunggu_pembayaran':
                    $statusClass = 'status-menunggu';
                    $statusText = 'Menunggu Pembayaran';
                    break;
                case 'dibayar':
                    $statusClass = 'status-menunggu';
                    $statusText = 'Sudah Dibayar';
                    break;
                case 'selesai':
                    $statusClass = 'status-selesai';
                    $statusText = 'Selesai';
                    break;
                case 'gagal':
                    $statusClass = 'status-gagal';
                    $statusText = 'Gagal';
                    break;
            }

            $salesHistory[] = [
                'id' => $trx->transaction_code ?? ('TRX-' . str_pad($trx->id, 4, '0', STR_PAD_LEFT)),
                'raw_id' => $trx->id,
                'product_name' => $trx->product->name,
                'buyer' => $trx->buyer->name,
                'income' => 'Rp ' . number_format($trx->total_price, 0, ',', '.'),
                'income_raw' => $trx->total_price,
                'date' => $trx->created_at->format('d M Y'),
                'time' => $trx->created_at->format('H:i') . ' WIB',
                'timestamp' => $trx->created_at->toIso8601String(),
                'status' => $statusText,
                'status_class' => $statusClass,
                'image' => $mainImage,
                'payment_proof' => $trx->payment_proof ? asset($trx->payment_proof) : '',
            ];
        }

        return view('history.sales-history', compact('salesHistory'));
    }

    /**
     * Seller closes a sale to mark it as completed.
     */
    public function closeSale(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id'
        ]);

        $transaction = Transaction::with('product')->findOrFail($validated['transaction_id']);

        // Pastikan hanya pemilik produk yang bisa menutup penjualan
        if ($transaction->product->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak menyelesaikan transaksi ini.');
        }

        DB::transaction(function () use ($transaction) {
            $transaction->update([
                'status' => 'selesai',
                'completed_at' => now(),
            ]);

            // Beri notifikasi ke buyer bahwa transaksi selesai
            Notification::create([
                'user_id' => $transaction->buyer_id,
                'type' => 'transaction_completed',
                'content' => 'Transaksi ' . ($transaction->transaction_code ?? $transaction->id) . ' telah diselesaikan oleh Penjual.',
                'is_read' => false,
            ]);
        });

        return back()->with('success', 'Penjualan berhasil ditandai sebagai selesai!');
    }

    /**
     * Buyer submits a review for a completed transaction.
     */
    public function submitReview(Request $request)
    {
        $validated = $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
            'rating_value' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $transaction = Transaction::findOrFail($validated['transaction_id']);

        // Pastikan hanya buyer yang bersangkutan yang bisa review
        if ($transaction->buyer_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak memberikan ulasan pada transaksi ini.');
        }

        if ($transaction->status !== 'selesai') {
            return back()->with('error', 'Ulasan hanya bisa diberikan untuk transaksi yang sudah selesai.');
        }

        // Cek jika sudah di-review
        $existingReview = Review::where('transaction_id', $transaction->id)->first();
        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk transaksi ini.');
        }

        Review::create([
            'transaction_id' => $transaction->id,
            'rating' => $validated['rating_value'],
            'comment' => $validated['comment']
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil disimpan.');
    }
}
