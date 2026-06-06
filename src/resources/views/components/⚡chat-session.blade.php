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

    public $deal_price;
    public $duration = 180;

    public function mount(Chat $chat)
    {
        $userId = auth()->id();

        if ($chat->buyer_id !== $userId && $chat->seller_id !== $userId){
            abort(403);
        }

        $this->chat = $chat;
        $this->chat->load(['buyer', 'seller', 'product.productImages', 'messages.sender', 'purchaseLinks']);
        
        // Set default deal price dari harga produk
        $this->deal_price = $this->chat->product->price;
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

    public function sendPurchaseLink()
    {
        if ($this->chat->seller_id !== auth()->id()) {
            abort(403);
        }

        $this->validate([
            'deal_price' => 'required|numeric|min:1',
            'duration'   => 'required|integer|min:15',
        ]);

        $token = Str::uuid()->toString();

        PurchaseLink::create([
            'chat_id'    => $this->chat->id,
            'token'      => $token,
            'deal_price' => $this->deal_price,
            'expired_at' => now()->addMinutes((int) $this->duration),
            'is_used'    => false,
        ]);

        $message = Message::create([
            'chat_id'   => $this->chat->id,
            'sender_id' => auth()->id(),
            'message'   => 'dY"- Link Pembelian telah dikirim! Harga: Rp ' . number_format($this->deal_price, 0, ',', '.') . ' ?" Klik untuk checkout: ' . route('checkout', $token),
        ]);

        $this->chat->touch();

        broadcast(new MessageSent($message))->toOthers();

        $this->chat->load(['messages.sender', 'purchaseLinks']);
        $this->reset(['deal_price', 'duration']);

        session()->flash('success', 'Link pembelian berhasil dikirim!');
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

            <button type="button" class="btn-kirim-link" onclick="document.getElementById('purchaseLinkModal').style.display='flex'">
                <i class="bi bi-link-45deg"></i>
                Kirim Link
            </button>
        </div>

        {{-- Modal Kirim Link --}}
        <div class="modal-overlay" id="purchaseLinkModal" style="display:none" wire:ignore.self>
            <div class="modal-card">
                <div class="modal-header-custom">
                    <h3 class="modal-title-custom">Kirim Link Pembelian</h3>
                    <button type="button" class="modal-close-btn" onclick="document.getElementById('purchaseLinkModal').style.display='none'" aria-label="Tutup">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <form wire:submit.prevent="sendPurchaseLink">
                    <div class="modal-body-custom">
                        @if (session()->has('success'))
                            <div style="color: green; margin-bottom: 10px; font-weight: bold;">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="form-group-custom">
                            <label class="form-label-custom">Harga Kesepakatan (Rp) <span class="required-star">*</span></label>
                            <input type="number" wire:model="deal_price" class="form-input-custom" min="1" required>
                        </div>
                        <div class="form-group-custom">
                            <label class="form-label-custom">Masa Berlaku Link <span class="required-star">*</span></label>
                            <select wire:model="duration" class="form-input-custom" required>
                                <option value="15">15 Menit</option>
                                <option value="30">30 Menit</option>
                                <option value="60">1 Jam</option>
                                <option value="180">3 Jam</option>
                                <option value="360">6 Jam</option>
                                <option value="720">12 Jam</option>
                                <option value="1440">24 Jam</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn-modal-cancel" onclick="document.getElementById('purchaseLinkModal').style.display='none'">Batal</button>
                        <button type="submit" class="btn-modal-submit" onclick="document.getElementById('purchaseLinkModal').style.display='none'">
                            <i class="bi bi-send-fill"></i> Kirim Link
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
