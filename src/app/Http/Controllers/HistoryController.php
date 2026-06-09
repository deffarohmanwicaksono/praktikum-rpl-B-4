<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class HistoryController extends Controller
{
    private function mapTransactionData($transactions)
    {
        $statusLabelMap = [
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'dibayar' => 'Menunggu Konfirmasi',
            'selesai' => 'Selesai',
            'gagal' => 'Gagal',
        ];

        $statusClassMap = [
            'menunggu_pembayaran' => 'status-menunggu',
            'dibayar' => 'status-menunggu',
            'selesai' => 'status-selesai',
            'gagal' => 'status-gagal',
        ];

        return $transactions->map(function ($trx) use ($statusLabelMap, $statusClassMap) {
            $imageUrl = $trx->product->productImages->first()?->image_url ?? 'images/placeholder.png';
            if (!str_starts_with($imageUrl, 'http')) {
                $imageUrl = str_starts_with($imageUrl, 'products/') ? asset('storage/' . $imageUrl) : asset($imageUrl);
            }

            $paymentProofUrl = $trx->payment_proof ? asset('storage/' . $trx->payment_proof) : '';

            $trx->mapped_status = $statusLabelMap[$trx->status] ?? $trx->status;
            $trx->status_class = $statusClassMap[$trx->status] ?? '';
            $trx->mapped_price = 'Rp ' . number_format($trx->total_price, 0, ',', '.');
            $trx->formatted_date = $trx->created_at->translatedFormat('d F Y');
            $trx->formatted_time = $trx->created_at->format('H:i') . ' WIB';
            $trx->image_url = $imageUrl;
            $trx->payment_proof_url = $paymentProofUrl;
            return $trx;
        });
    }

    /**
     * Tampilkan riwayat pembelian milik user saat ini (sebagai buyer).
     */
    public function purchaseHistory()
    {
        $transactions = Transaction::with(['product.productImages', 'product.user', 'purchaseLink.chat'])
            ->where('buyer_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $transactions = $this->mapTransactionData($transactions);

        return view('history.purchase-history', compact('transactions'));
    }

    /**
     * Tampilkan riwayat penjualan milik user saat ini (sebagai seller).
     */
    public function salesHistory()
    {
        // Cari semua transaksi di mana produk dari transaksi tersebut dimiliki oleh user saat ini
        $transactions = Transaction::with(['product.productImages', 'buyer', 'purchaseLink.chat'])
            ->whereHas('product', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $transactions = $this->mapTransactionData($transactions);

        return view('history.sales-history', compact('transactions'));
    }
}
