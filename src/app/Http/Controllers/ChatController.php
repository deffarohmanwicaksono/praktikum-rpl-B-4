<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use App\Models\PurchaseLink;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Events\MessageSent;

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

        $message = Message::create([
            'chat_id'   => $chat->id,
            'sender_id' => $userId,
            'message'   => $validated['message'],
        ]);

        // Create notification for the recipient
        $recipientId = ($chat->buyer_id === $userId) ? $chat->seller_id : $chat->buyer_id;
        \App\Models\Notification::create([
            'user_id' => $recipientId,
            'type'    => 'message',
            'content' => 'Anda menerima pesan baru dari ' . auth()->user()->name,
            'is_read' => false,
        ]);

        // Update timestamp chat agar muncul paling atas di list
        $chat->touch();

        // Broadcast event ke user lain secara real-time
        broadcast(new MessageSent($message))->toOthers();

        return redirect()->route('chat.session', $chat->id);
    }

    /**
     * Tampilkan form pembuatan link pembelian (halaman penuh)
     */
    public function showPurchaseLinkForm(Chat $chat)
    {
        $userId = auth()->id();

        // Hanya seller yang berhak membuat link
        if ($chat->seller_id !== $userId) {
            abort(403, 'Hanya seller yang dapat mengirim link pembelian.');
        }

        $chat->load(['buyer', 'product.productImages']);

        return view('checkout.purchase-link', [
            'chat' => $chat,
        ]);
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

        // Cek apakah masih ada link aktif yang belum kedaluwarsa untuk chat ini
        $activeLink = PurchaseLink::where('chat_id', $chat->id)
            ->where('is_used', false)
            ->where('expired_at', '>', now())
            ->latest()
            ->first();

        if ($activeLink) {
            return back()->withErrors([
                'active_link' => 'Masih ada link pembelian aktif yang belum kedaluwarsa. Tunggu hingga link tersebut digunakan oleh buyer atau habis masa berlakunya.',
            ]);
        }

        // Bersihkan titik ribuan Rupiah dari input
        if ($request->has('deal_price')) {
            $request->merge([
                'deal_price' => str_replace('.', '', $request->input('deal_price'))
            ]);
        }

        $validated = $request->validate([
            'deal_price'      => 'required|numeric|min:1',
            'duration'        => 'required|integer|min:15',
            'note'            => 'nullable|string|max:500',
            'payment_methods' => 'nullable|string', // Berisi JSON array metode pembayaran
        ]);

        $paymentMethodsArray = null;
        if (!empty($validated['payment_methods'])) {
            $paymentMethodsArray = json_decode($validated['payment_methods'], true);
        }

        $token = Str::uuid()->toString();

        $product = $chat->product;
        if ($product->status === 'sold_out') {
            return back()->withErrors([
                'product' => 'Produk sudah terjual dan tidak dapat dibuatkan link pembelian lagi.'
            ]);
        }

        $purchaseLink = PurchaseLink::create([
            'chat_id'         => $chat->id,
            'token'           => $token,
            'deal_price'      => $validated['deal_price'],
            'expired_at'      => now()->addMinutes((int) $validated['duration']),
            'is_used'         => false,
            'note'            => $validated['note'] ?? null,
            'payment_methods' => $paymentMethodsArray,
        ]);

        $transaction = Transaction::create([
            'purchase_link_id' => $purchaseLink->id,
            'buyer_id'         => $chat->buyer_id,
            'product_id'       => $chat->product_id,
            'total_price'      => $purchaseLink->deal_price,
            'status'           => 'menunggu_pembayaran',
        ]);

        $transaction->update([
            'transaction_code' =>
                'TRX-' .
                now()->format('Y') .
                '-' .
                str_pad($transaction->id, 3, '0', STR_PAD_LEFT),
        ]);
        $transaction->save();

        $message = Message::create([
            'chat_id'   => $chat->id,
            'sender_id' => $userId,
            'message'   => '[PURCHASE_LINK:' . $token . ']',
        ]);

        //Reload livewire
        $chat->touch();
        $chat->load(['messages.sender', 'purchaseLinks']);

        // Kirim Notifikasi Link Pembelian ke buyer
        \App\Models\Notification::create([
            'user_id' => $chat->buyer_id,
            'type'    => 'purchase_link',
            'content' => 'Seller mengirimkan link pembelian untuk Anda.',
            'is_read' => false,
        ]);

        $chat->touch();

        // Broadcast event ke user lain secara real-time
        broadcast(new MessageSent($message))->toOthers();

        return redirect()->route('chat.session', $chat->id)
            ->with('success', 'Link pembelian berhasil dikirim!');
    }
}
