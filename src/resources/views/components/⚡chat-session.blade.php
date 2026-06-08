<?php

use Livewire\Component; // Menggunakan Livewire\Component bawaan, bukan Volt
use App\Models\Chat;
use App\Models\Message;
use App\Models\PurchaseLink;
use App\Events\MessageSent;
use Illuminate\Support\Str;

new class extends Component
{
    public Chat $chat;
    public string $textMessage = '';

    public function mount(Chat $chat)
    {
        $userId = auth()->id();

        if ($chat->buyer_id !== $userId && $chat->seller_id !== $userId){
            abort(403);
        }

        $this->chat = $chat;
        $this->chat->load(['buyer', 'seller', 'product.productImages', 'messages.sender', 'purchaseLinks']);
    }

    public function getListeners()
    {
        // PENTING: Menggunakan titik (.) di depan nama event karena ada broadcastAs() di class event
        return ["echo-private:chat.{$this->chat->id},.MessageSent" => 'broadcastMessageReceived'];
    }

    public function sendMessage()
    {
        $this->validate([
            'textMessage' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'chat_id'   => $this->chat->id,
            'sender_id' => auth()->id(),
            'message'   => $this->textMessage,
        ]);

        $this->chat->touch();

        broadcast(new MessageSent($message))->toOthers();

        $this->chat->load('messages.sender');
        $this->textMessage = '';
    }

    public function broadcastMessageReceived($event)
    {
        $this->chat->load(['messages.sender', 'purchaseLinks']);
    }
};
?>

@php
    $userId = auth()->id();
    $partner = ($chat->seller_id === $userId) ? $chat->buyer : $chat->seller;
    $productImage = $chat->product->productImages->first();
    $imageUrl = $productImage
        ? asset('storage/' . $productImage->image_path)
        : asset('images/Elemen-1.png');
    $currentPOV = ($chat->seller_id === $userId) ? 'seller' : 'buyer';
@endphp

<div class="chat-shell">

    <div class="chat-head">
        <span class="chat-head-sep"></span>

        <div class="chat-head-contact">
            <div class="chat-head-foto">
                <img
                    src="{{ $imageUrl }}"
                    alt="Produk"
                    class="chat-head-foto-img"
                >
            </div>

            <div class="chat-head-info">
                <span class="chat-head-name" id="chatHeaderName">
                    {{ $partner->name }}
                </span>

                <span class="chat-head-product">
                    <i class="bi bi-tag-fill"></i>
                    {{ $chat->product->name }}
                </span>
            </div>
        </div>
    </div>

    {{-- MESSAGES --}}
    <div class="chat-messages" 
         id="chatMessages"
         x-data
         x-init="$el.scrollTop = $el.scrollHeight; new MutationObserver(() => $el.scrollTop = $el.scrollHeight).observe($el, { childList: true })">
        @foreach ($chat->messages as $msg)
            @if(str_starts_with($msg->message, '[PURCHASE_LINK:'))
                @php
                    $token = str_replace(['[PURCHASE_LINK:', ']'], '', $msg->message);
                    $link = $chat->purchaseLinks->where('token', $token)->first();
                    $imgSrc = $chat->product->productImages->first() 
                        ? asset('storage/' . $chat->product->productImages->first()->image_path)
                        : asset('images/Elemen-1.png');
                    $isExpired = !$link || $link->expired_at->isPast() || $link->is_used;
                    $cardClass = $isExpired ? 'msg-purchase-card msg-purchase-card--expired' : 'msg-purchase-card';
                    $btnClass = $isExpired ? 'msg-purchase-btn msg-purchase-btn--expired' : 'msg-purchase-btn';
                    $btnText = $isExpired ? 'Sesi Berakhir' : 'Bayar Sekarang';
                @endphp
                <div class="msg-row msg-system">
                    <div class="{{ $cardClass }}">
                        <div class="msg-purchase-info">
                            <img src="{{ $imgSrc }}" alt="Produk" class="msg-purchase-img">
                            <div>
                                <span class="msg-purchase-title">{{ $chat->product->name }}</span>
                                <span class="msg-purchase-price">Rp {{ number_format($link->deal_price ?? 0, 0, ',', '.') }}</span>
                                <span class="msg-purchase-cond">
                                     @if($isExpired)
                                         <i class="bi bi-exclamation-circle-fill"></i> Link Kadaluwarsa
                                     @else
                                         <i class="bi bi-tag-fill"></i> Sesuai Kesepakatan
                                     @endif
                                </span>
                            </div>
                        </div>
                        @if($isExpired)
                            <button type="button" class="{{ $btnClass }}" disabled>
                                {{ $btnText }}
                            </button>
                        @else
                            <button type="button" class="{{ $btnClass }}" onclick="window.location.href='{{ url('/checkout/' . $token) }}'">
                                {{ $btnText }}
                            </button>
                        @endif
                    </div>
                </div>
            @else
                @php
                    $isMe = $msg->sender_id === $userId;
                    $rowClass = $isMe ? 'msg-out' : 'msg-in';
                    $bubbleClass = $isMe ? 'msg-bubble--out' : 'msg-bubble--in';
                @endphp

                <div class="msg-row {{ $rowClass }}">
                    @if (!$isMe)
                        <div class="msg-avatar"><i class="bi bi-person-circle"></i></div>
                    @endif

                    <div class="msg-bubble {{ $bubbleClass }}">
                        <p class="msg-text">{{ $msg->message }}</p>

                        @if ($isMe)
                            <div class="msg-out-meta">
                                <span class="msg-time msg-time--out">{{ $msg->created_at->format('H:i') }}</span>
                                <span class="msg-tick"><i class="bi bi-check2-all"></i></span>
                            </div>
                        @else
                            <span class="msg-time">{{ $msg->created_at->format('H:i') }}</span>
                        @endif
                    </div>

                    @if ($isMe)
                        <div class="msg-avatar"><i class="bi bi-person-circle"></i></div>
                    @endif
                </div>
            @endif
        @endforeach
    </div>

    {{-- INPUT PESAN --}}
    <form wire:submit.prevent="sendMessage" class="chat-input-bar">
        <div class="chat-input-wrap">
            <textarea
                class="chat-textarea"
                id="chatInput"
                wire:model="textMessage"
                placeholder="Tulis pesan..."
                rows="1"
                required
            ></textarea>

            <button type="button" class="chat-emoji-btn" id="emojiBtn">
                <i class="bi bi-emoji-smile"></i>
            </button>
        </div>

        <button type="submit" class="btn-kirim" id="sendBtn">
            <i class="bi bi-send-fill"></i>
        </button>
    </form>

    {{-- KIRIM LINK PEMBELIAN (hanya untuk seller) --}}
    @if ($currentPOV === 'seller')
        <div class="kirim-link-bar" id="kirimLinkBar">
            <div class="kirim-link-bar-left">
                <div class="kirim-link-bar-icon">
                    <i class="bi bi-link-45deg"></i>
                </div>

                <div>
                    <span class="kirim-link-bar-title">
                        Kirim Link Pembelian
                    </span>

                    <span class="kirim-link-bar-desc">
                        Gunakan fitur ini untuk mengirim link pembelian setelah mencapai kesepakatan dengan buyer.
                    </span>
                </div>
            </div>

            <!-- Diubah menjadi link ke halaman pembuatan link pembelian khusus -->
            <a href="{{ route('chat.purchaseLinkForm', $chat->id) }}" class="btn-kirim-link">
                <i class="bi bi-link-45deg"></i>
                Kirim Link
            </a>
        </div>
    @endif

</div>
