<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Events\MessageSent;
use App\Models\Chat;
use App\Models\Message;
use App\Models\Notification;
use App\Models\PurchaseLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    /**
     * Helper: format data satu chat untuk response.
     */
    private function formatChat(Chat $chat, int $userId): array
    {
        $product      = $chat->product;
        $imageUrl     = $product?->productImages?->first()?->image_url ?? null;
        $latestMsg    = $chat->latestMessage;

        if ($imageUrl && !str_starts_with($imageUrl, 'http')) {
            if (str_starts_with($imageUrl, 'products/')) {
                $imageUrl = asset('storage/' . $imageUrl);
            } else {
                $imageUrl = asset($imageUrl);
            }
        }

        return [
            'id'             => $chat->id,
            'product'        => [
                'id'        => $product?->id,
                'name'      => $product?->name,
                'image_url' => $imageUrl ?? asset('images/placeholder.png'),
            ],
            'buyer'          => [
                'id'   => $chat->buyer?->id,
                'name' => $chat->buyer?->name,
            ],
            'seller'         => [
                'id'   => $chat->seller?->id,
                'name' => $chat->seller?->name,
            ],
            'current_pov'    => ($chat->seller_id === $userId) ? 'seller' : 'buyer',
            'latest_message' => $latestMsg ? [
                'message'    => $latestMsg->message,
                'created_at' => $latestMsg->created_at?->toDateTimeString(),
            ] : null,
            'updated_at'     => $chat->updated_at?->toDateTimeString(),
        ];
    }

    /**
     * Helper: format satu pesan (termasuk deteksi PURCHASE_LINK).
     */
    private function formatMessage(Message $msg, Chat $chat): array
    {
        $isPurchaseLink = str_starts_with($msg->message, '[PURCHASE_LINK:');
        $purchaseLinkData = null;

        if ($isPurchaseLink) {
            preg_match('/\[PURCHASE_LINK:(.+?)\]/', $msg->message, $matches);
            $token = $matches[1] ?? null;

            if ($token) {
                $link = $chat->purchaseLinks->firstWhere('token', $token);
                if ($link) {
                    $purchaseLinkData = [
                        'token'          => $link->token,
                        'deal_price'     => $link->deal_price,
                        'price_label'    => 'Rp ' . number_format($link->deal_price, 0, ',', '.'),
                        'expired_at'     => $link->expired_at?->toDateTimeString(),
                        'is_used'        => $link->is_used,
                        'is_valid'       => $link->isValid(),
                        'note'           => $link->note,
                        'payment_methods'=> $link->payment_methods,
                        'checkout_url'   => route('checkout.show', $link->token),
                    ];
                }
            }
        }

        return [
            'id'               => $msg->id,
            'sender_id'        => $msg->sender_id,
            'sender_name'      => $msg->sender?->name,
            'is_purchase_link' => $isPurchaseLink,
            'message'          => $isPurchaseLink ? null : $msg->message,
            'purchase_link'    => $purchaseLinkData,
            'created_at'       => $msg->created_at?->toDateTimeString(),
        ];
    }

    /**
     * Daftar semua chat milik user (sebagai buyer atau seller).
     */
    public function index()
    {
        $userId = auth()->id();

        $chats = Chat::with(['buyer', 'seller', 'product.productImages', 'latestMessage'])
            ->where('buyer_id', $userId)
            ->orWhere('seller_id', $userId)
            ->latest('updated_at')
            ->get();

        return response()->json([
            'data' => $chats->map(fn($c) => $this->formatChat($c, $userId)),
        ]);
    }

    /**
     * Buat room chat baru antara buyer dan seller untuk produk tertentu.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'seller_id'  => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $buyerId = auth()->id();

        // Cegah buyer chat dengan diri sendiri
        if ($buyerId == $validated['seller_id']) {
            return response()->json([
                'message' => 'Tidak dapat memulai chat dengan produk sendiri.',
            ], 422);
        }

        $existingChat = Chat::where('buyer_id', $buyerId)
            ->where('seller_id', $validated['seller_id'])
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingChat) {
            return response()->json([
                'message' => 'Chat sudah ada.',
                'chat_id' => $existingChat->id,
            ]);
        }

        $chat = Chat::create([
            'buyer_id'   => $buyerId,
            'seller_id'  => $validated['seller_id'],
            'product_id' => $validated['product_id'],
        ]);

        return response()->json([
            'message' => 'Chat berhasil dibuat.',
            'chat_id' => $chat->id,
        ], 201);
    }

    /**
     * Tampilkan isi sesi chat tertentu beserta semua pesan.
     */
    public function show(Chat $chat)
    {
        $userId = auth()->id();

        if ($chat->buyer_id !== $userId && $chat->seller_id !== $userId) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        $chat->load(['buyer', 'seller', 'product.productImages', 'messages.sender', 'purchaseLinks']);

        $currentPOV = ($chat->seller_id === $userId) ? 'seller' : 'buyer';

        return response()->json([
            'chat'        => $this->formatChat($chat, $userId),
            'current_pov' => $currentPOV,
            'messages'    => $chat->messages->map(fn($m) => $this->formatMessage($m, $chat)),
        ]);
    }

    /**
     * Kirim pesan teks biasa.
     */
    public function sendMessage(Request $request, Chat $chat)
    {
        $userId = auth()->id();

        if ($chat->buyer_id !== $userId && $chat->seller_id !== $userId) {
            return response()->json(['message' => 'Akses ditolak.'], 403);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'chat_id'   => $chat->id,
            'sender_id' => $userId,
            'message'   => $validated['message'],
        ]);

        $recipientId = ($chat->buyer_id === $userId) ? $chat->seller_id : $chat->buyer_id;
        Notification::create([
            'user_id' => $recipientId,
            'type'    => 'message',
            'content' => 'Anda menerima pesan baru dari ' . auth()->user()->name,
            'is_read' => false,
        ]);

        $chat->touch();
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'message' => 'Pesan berhasil dikirim.',
            'data'    => $this->formatMessage($message, $chat),
        ], 201);
    }

    /**
     * Seller kirim purchase link ke buyer melalui chat.
     */
    public function sendPurchaseLink(Request $request, Chat $chat)
    {
        $userId = auth()->id();

        if ($chat->seller_id !== $userId) {
            return response()->json(['message' => 'Hanya seller yang dapat mengirim link pembelian.'], 403);
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

        // Bersihkan titik ribuan dari deal_price
        if ($request->has('deal_price')) {
            $request->merge([
                'deal_price' => str_replace('.', '', $request->input('deal_price')),
            ]);
        }

        $validated = $request->validate([
            'deal_price'      => 'required|numeric|min:1',
            'duration'        => 'required|integer|min:15',
            'note'            => 'nullable|string|max:500',
            'payment_methods' => 'nullable|array',
            'payment_methods.*' => 'string',
        ]);

        $token = Str::uuid()->toString();

        $product = $chat->product;
        if ($product->status === 'sold_out') {
            return response()->json([
                'message' => 'Produk sudah terjual.'
            ], 422);
        }

        $purchaseLink = PurchaseLink::create([
            'chat_id'         => $chat->id,
            'token'           => $token,
            'deal_price'      => $validated['deal_price'],
            'expired_at'      => now()->addMinutes((int) $validated['duration']),
            'is_used'         => false,
            'note'            => $validated['note'] ?? null,
            'payment_methods' => $validated['payment_methods'] ?? null,
        ]);

        $message = Message::create([
            'chat_id'   => $chat->id,
            'sender_id' => $userId,
            'message'   => '[PURCHASE_LINK:' . $token . ']',
        ]);

        Notification::create([
            'user_id' => $chat->buyer_id,
            'type'    => 'purchase_link',
            'content' => 'Seller mengirimkan link pembelian untuk Anda.',
            'is_read' => false,
        ]);

        $chat->touch();
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'message'      => 'Link pembelian berhasil dikirim.',
            'purchase_link' => [
                'token'          => $purchaseLink->token,
                'deal_price'     => $purchaseLink->deal_price,
                'price_label'    => 'Rp ' . number_format($purchaseLink->deal_price, 0, ',', '.'),
                'expired_at'     => $purchaseLink->expired_at?->toDateTimeString(),
                'checkout_url'   => route('checkout.show', $purchaseLink->token),
            ],
        ], 201);
    }
}