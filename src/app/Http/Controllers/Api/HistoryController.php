<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Helper: mapping status transaksi ke label & class.
     */
    private function mapStatus(string $status): array
    {
        $statusLabelMap = [
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'dibayar'             => 'Menunggu Konfirmasi',
            'selesai'             => 'Selesai',
            'gagal'               => 'Gagal',
        ];

        $statusClassMap = [
            'menunggu_pembayaran' => 'status-menunggu',
            'dibayar'             => 'status-dibayar',
            'selesai'             => 'status-selesai',
            'gagal'               => 'status-gagal',
        ];

        return [
            'label' => $statusLabelMap[$status] ?? $status,
            'class' => $statusClassMap[$status] ?? '',
        ];
    }

    /**
     * Helper: format satu transaksi untuk response JSON.
     */
    private function formatTransaction(Transaction $trx): array
    {
        $imageUrl = $trx->product->productImages->first()?->image_url ?? 'images/placeholder.png';
        if (!str_starts_with($imageUrl, 'http')) {
            $imageUrl = str_starts_with($imageUrl, 'products/')
                ? asset('storage/' . $imageUrl)
                : asset($imageUrl);
        }

        $paymentProofUrl = $trx->payment_proof ? asset('storage/' . $trx->payment_proof) : null;
        $statusData      = $this->mapStatus($trx->status);

        return [
            'id'               => $trx->id,
            'product'          => [
                'id'        => $trx->product?->id,
                'name'      => $trx->product?->name,
                'image_url' => $imageUrl,
            ],
            'seller'           => [
                'id'   => $trx->product?->user?->id,
                'name' => $trx->product?->user?->name,
            ],
            'buyer'            => [
                'id'   => $trx->buyer?->id,
                'name' => $trx->buyer?->name,
            ],
            'total_price'      => $trx->total_price,
            'price_label'      => 'Rp ' . number_format($trx->total_price, 0, ',', '.'),
            'status'           => $trx->status,
            'status_label'     => $statusData['label'],
            'status_class'     => $statusData['class'],
            'payment_method'   => $trx->payment_method,
            'payment_proof_url'=> $paymentProofUrl,
            'date'             => $trx->created_at?->toDateString(),
            'date_label'       => $trx->created_at?->translatedFormat('d F Y'),
            'time_label'       => $trx->created_at?->format('H:i') . ' WIB',
            'completed_at'     => $trx->completed_at?->toDateTimeString(),
            'review'           => $trx->review ? [
                'rating'  => $trx->review->rating,
                'comment' => $trx->review->comment,
            ] : null,
        ];
    }

    /**
     * Riwayat pembelian user saat ini (sebagai buyer).
     */
    public function purchaseHistory()
    {
        $transactions = Transaction::with([
                'product.productImages',
                'product.user',
                'purchaseLink.chat',
                'buyer',
                'review',
            ])
            ->where('buyer_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'data' => $transactions->map(fn($trx) => $this->formatTransaction($trx)),
        ]);
    }

    /**
     * Riwayat penjualan user saat ini (sebagai seller).
     */
    public function salesHistory()
    {
        $transactions = Transaction::with([
                'product.productImages',
                'buyer',
                'purchaseLink.chat',
                'review',
            ])
            ->whereHas('product', fn($q) => $q->where('user_id', auth()->id()))
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'data' => $transactions->map(fn($trx) => $this->formatTransaction($trx)),
        ]);
    }

    /**
     * Seller menutup / menyelesaikan transaksi.
     */
    public function closeTransaction(Transaction $transaction)
    {
        if ($transaction->product->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Anda tidak memiliki akses untuk menutup transaksi ini.',
            ], 403);
        }

        if ($transaction->status !== 'dibayar') {
            return response()->json([
                'message' => 'Transaksi belum dapat diselesaikan.'
            ], 400);
        }

        $transaction->update([
            'status'       => 'selesai',
            'completed_at' => now(),
        ]);

        $transaction->product->update([
            'status' => 'sold_out'
        ]);

        return response()->json([
            'message'      => 'Transaksi berhasil diselesaikan.',
            'status'       => 'selesai',
            'status_label' => 'Selesai',
            'completed_at' => $transaction->completed_at?->toDateTimeString(),
        ]);
    }
}