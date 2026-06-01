<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\PurchaseLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Daftar semua chat milik user (sebagai buyer atau seller)
     */
    public function index()
    {
        $userId = auth()->id();

        $chats = Chat::with(['buyer', 'seller', 'product.productImages', 'latestMessage'])
            ->where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->latest('updated_at')
            ->get();

        return view('chat.chat-list', [
            'chats' => $chats
        ]);
    }

    /**
     * Buat room chat baru (buyer klik "Chat Seller" di detail produk)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'seller_id'  => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $buyerId = auth()->id();

        // Cek apakah chat sudah ada untuk kombinasi buyer-seller-product ini
        $existingChat = Chat::where('buyer_id', $buyerId)
            ->where('seller_id', $validated['seller_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingChat) {
            return redirect()->route('chat.session', $existingChat->id);
        }

        $chat = Chat::create([
            'buyer_id'   => $buyerId,
            'seller_id'  => $validated['seller_id'],
            'product_id' => $validated['product_id'],
        ]);

        return redirect()->route('chat.session', $chat->id);
    }

    /**
     * Tampilkan sesi chat tertentu
     */
    public function show(Chat $chat)
    {
        $userId = auth()->id();

        // Pastikan user adalah buyer atau seller di chat ini
        if ($chat->buyer_id !== $userId && $chat->seller_id !== $userId) {
            abort(403, 'Anda tidak memiliki akses ke chat ini.');
        }

        $chat->load(['buyer', 'seller', 'product.productImages', 'messages.sender', 'purchaseLinks']);

        // Tentukan POV (point of view)
        $currentPOV = ($chat->seller_id === $userId) ? 'seller' : 'buyer';

        return view('chat.chat-session', [
            'chat'       => $chat,
            'messages'   => $chat->messages,
            'currentPOV' => $currentPOV,
        ]);
    }

    /**
     * Kirim pesan baru
     */
    public function sendMessage(Request $request, Chat $chat)
    {
        $userId = auth()->id();

        if ($chat->buyer_id !== $userId && $chat->seller_id !== $userId) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Message::create([
            'chat_id'   => $chat->id,
            'sender_id' => $userId,
            'message'   => $validated['message'],
        ]);

        // Update timestamp chat agar muncul paling atas di list
        $chat->touch();

        return redirect()->route('chat.session', $chat->id);
    }

    /**
     * Seller kirim link pembelian
     */
    public function sendPurchaseLink(Request $request, Chat $chat)
    {
        $userId = auth()->id();

        // Hanya seller yang bisa kirim link
        if ($chat->seller_id !== $userId) {
            abort(403, 'Hanya seller yang dapat mengirim link pembelian.');
        }

        $validated = $request->validate([
            'deal_price' => 'required|numeric|min:1',
            'duration'   => 'required|integer|min:15', // dalam menit
        ]);

        $token = Str::uuid()->toString();

        $purchaseLink = PurchaseLink::create([
            'chat_id'    => $chat->id,
            'token'      => $token,
            'deal_price' => $validated['deal_price'],
            'expired_at' => now()->addMinutes($validated['duration']),
            'is_used'    => false,
        ]);

        // Kirim pesan otomatis di chat berisi link pembelian
        Message::create([
            'chat_id'   => $chat->id,
            'sender_id' => $userId,
            'message'   => '🔗 Link Pembelian telah dikirim! Harga: Rp ' . number_format($validated['deal_price'], 0, ',', '.') . ' — Klik untuk checkout: ' . route('checkout', $token),
        ]);

        $chat->touch();

        return redirect()->route('chat.session', $chat->id)
            ->with('success', 'Link pembelian berhasil dikirim!');
    }
}
