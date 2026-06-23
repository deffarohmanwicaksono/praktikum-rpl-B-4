<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PurchaseLink;
use App\Models\Transaction;
use App\Models\PaymentAccount;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Tampilkan detail checkout berdasarkan token purchase link.
     */
    public function show(string $token)
    {
        $purchaseLink = PurchaseLink::where('token', $token)
            ->with(['chat.buyer', 'chat.seller.paymentAccounts', 'chat.product.productImages'])
            ->firstOrFail();

        if (!$purchaseLink->isValid()) {
            return response()->json([
                'message' => 'Link sudah tidak valid. Tautan telah kedaluwarsa atau sudah digunakan.',
                'is_valid' => false,
            ], 422);
        }

        $chat    = $purchaseLink->chat;
        $product = $chat->product;
        $seller  = $chat->seller;

        $imageUrl = $product->productImages->first()?->image_url ?? null;
        if ($imageUrl && !str_starts_with($imageUrl, 'http')) {
            if (str_starts_with($imageUrl, 'products/')) {
                $imageUrl = asset('storage/' . $imageUrl);
            } else {
                $imageUrl = asset($imageUrl);
            }
        }

        // Ambil filter metode pembayaran yang dipilih seller saat membuat link
        $allowedMethods = $purchaseLink->payment_methods;
        if (!is_array($allowedMethods)) {
            $allowedMethods = [];
        }

        $formattedAccounts = collect($allowedMethods)->map(function($m, $index) {
            return [
                'id'             => $index + 1,
                'provider_name'  => $m['provider'] ?? ($m['label'] ?? 'Metode'),
                'account_number' => $m['number'] ?? '',
                'account_name'   => $m['owner'] ?? '',
                'type'           => (isset($m['type']) && $m['type'] === 'ewallet') ? 'E-Wallet' : 'Transfer Bank'
            ];
        })->values();

        // FALLBACK: Jika payment_methods kosong, gunakan dari seller
        if ($formattedAccounts->isEmpty() && $seller->paymentAccounts->isNotEmpty()) {
            $formattedAccounts = $seller->paymentAccounts->map(function($acc) {
                $methodLower = strtolower($acc->payment_method);
                return [
                    'id'             => $acc->id,
                    'provider_name'  => $acc->payment_method,
                    'account_number' => $acc->account_number,
                    'account_name'   => $acc->account_name,
                    'type'           => (str_contains($methodLower, 'bca') || str_contains($methodLower, 'mandiri') || str_contains($methodLower, 'bri') || str_contains($methodLower, 'bank'))
                                        ? 'Transfer Bank'
                                        : 'E-Wallet'
                ];
            })->values();
        }

        return response()->json([
            'is_valid'      => true,
            'purchase_link' => [
                'token'          => $purchaseLink->token,
                'deal_price'     => $purchaseLink->deal_price,
                'price_label'    => 'Rp ' . number_format($purchaseLink->deal_price, 0, ',', '.'),
                'expired_at'     => $purchaseLink->expired_at?->toDateTimeString(),
                'note'           => $purchaseLink->note,
                'payment_methods'=> $purchaseLink->payment_methods,
            ],
            'product'       => [
                'id'        => $product->id,
                'name'      => $product->name,
                'image_url' => $imageUrl ?? asset('images/placeholder.png'),
            ],
            'seller'        => [
                'id'   => $seller->id,
                'name' => $seller->name,
            ],
            'payment_accounts' => $formattedAccounts
        ]);
    }

    /**
     * Proses checkout — buat transaksi dari purchase link.
     */
    public function store(Request $request, string $token)
    {
        $purchaseLink = PurchaseLink::where('token', $token)->firstOrFail();

        if (!$purchaseLink->isValid()) {
            return response()->json([
                'message' => 'Link pembelian sudah tidak valid.',
            ], 422);
        }

        $validated = $request->validate([
            'payment_method' => 'required|string',
        ]);

        $transaction = Transaction::where(
            'purchase_link_id',
            $purchaseLink->id
        )->first();

        if (!$transaction) {
            return response()->json([
                'message' => 'Transaksi tidak ditemukan.'
            ], 404);
        }

        $transaction->update([
            'payment_method' => $validated['payment_method'],
        ]);

        return response()->json([
            'message'        => 'Checkout berhasil! Silakan upload bukti pembayaran.',
            'transaction_id' => $transaction->id,
            'status'         => $transaction->status,
            'total_price'    => $transaction->total_price,
            'price_label'    => 'Rp ' . number_format($transaction->total_price, 0, ',', '.'),
            'payment_method' => $transaction->payment_method,
        ], 201);
    }

    /**
     * Upload bukti pembayaran untuk transaksi.
     */
    public function uploadProof(Request $request, Transaction $transaction)
    {
        if ($transaction->buyer_id !== auth()->id()) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        $validated = $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $transaction->update([
            'payment_proof' => $path,
            'status'        => 'dibayar',
        ]);

        // Tandai link sudah dipakai setelah bukti pembayaran berhasil dikirim
        $transaction->purchaseLink->update(['is_used' => true]);

        return response()->json([
            'message'           => 'Bukti pembayaran berhasil dikirim! Menunggu konfirmasi seller.',
            'transaction_id'    => $transaction->id,
            'status'            => 'dibayar',
            'payment_proof_url' => asset('storage/' . $path),
        ]);
    }
}
