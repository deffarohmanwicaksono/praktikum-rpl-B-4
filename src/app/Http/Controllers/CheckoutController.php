<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseLink;
use App\Models\Transaction;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout berdasarkan token purchase link
     */
    public function showCheckout(string $token)
    {
        $purchaseLink = PurchaseLink::where('token', $token)
            ->with(['chat.buyer', 'chat.seller', 'chat.product.productImages'])
            ->firstOrFail();

        // Cek apakah link masih valid
        if (!$purchaseLink->isValid()) {
            return view('checkout.checkout-expired', [
                'message' => 'Link sudah tidak valid. Tautan telah kedaluwarsa atau sudah digunakan sebelumnya.'
            ]);
        }

        $chat    = $purchaseLink->chat;
        $product = $chat->product;
        $seller  = $chat->seller;

        return view('checkout.checkout', [
            'purchaseLink' => $purchaseLink,
            'product'      => $product,
            'seller'       => $seller,
            'chat'         => $chat,
        ]);
    }

    /**
     * Proses checkout — buat transaksi
     */
    public function store(Request $request, string $token)
    {
        $purchaseLink = PurchaseLink::where('token', $token)->firstOrFail();

        if (!$purchaseLink->isValid()) {
            return back()->withErrors(['token' => 'Link pembelian sudah tidak valid.']);
        }

        $validated = $request->validate([
            'payment_method' => 'required|string',
        ]);

        $chat = $purchaseLink->chat;

        // Update status transaksi setelah buyer upload bukti payment
        $transaction = $purchaseLink->transaction;
        $transaction->update([
            'payment_method' => $validated['payment_method'],
        ]);

        return redirect()->route('checkout.uploadProofForm', $transaction->id)
            ->with('success', 'Checkout berhasil! Silakan upload bukti pembayaran.');
    }

    /**
     * Form upload bukti pembayaran
     */
    public function showUploadProof(Transaction $transaction)
    {
        if ($transaction->buyer_id !== auth()->id()) {
            abort(403);
        }

        $transaction->load(['product.productImages', 'purchaseLink']);

        return view('checkout.upload-proof', [
            'transaction' => $transaction,
        ]);
    }

    /**
     * Upload bukti pembayaran
     */
    public function uploadProof(Request $request, Transaction $transaction)
    {
        if ($transaction->buyer_id !== auth()->id()) {
            abort(403);
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

        return redirect()->route('home')
            ->with('success', 'Bukti pembayaran berhasil dikirim! Menunggu konfirmasi seller.');
    }
}
