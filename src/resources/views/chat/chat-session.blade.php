@extends('layouts.app')

@section('title', 'Sesi Chat - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite('resources/css/pages/chat-session.css')
@endpush

{{-- PAGE JS --}}
@push('scripts')
    @vite('resources/js/chat/chat-session.js')
@endpush

@section('content')

@php
    $userId = auth()->id();
    $partner = ($chat->seller_id === $userId) ? $chat->buyer : $chat->seller;
    $productImage = $chat->product->productImages->first();
    $imageUrl = $productImage
        ? asset('storage/' . $productImage->image_path)
        : asset('images/Elemen-1.png');
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
    <div class="chat-messages" id="chatMessages">
        @foreach ($messages as $msg)
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
    <form action="{{ route('chat.sendMessage', $chat->id) }}" method="POST" class="chat-input-bar">
        @csrf
        <div class="chat-input-wrap">
            <textarea
                class="chat-textarea"
                id="chatInput"
                name="message"
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
        <div class="modal-overlay" id="purchaseLinkModal" style="display:none">
            <div class="modal-card">
                <div class="modal-header-custom">
                    <h3 class="modal-title-custom">Kirim Link Pembelian</h3>
                    <button class="modal-close-btn" onclick="document.getElementById('purchaseLinkModal').style.display='none'" aria-label="Tutup">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
                <form action="{{ route('chat.sendPurchaseLink', $chat->id) }}" method="POST">
                    @csrf
                    <div class="modal-body-custom">
                        <div class="form-group-custom">
                            <label class="form-label-custom">Harga Kesepakatan (Rp) <span class="required-star">*</span></label>
                            <input type="number" name="deal_price" class="form-input-custom"
                                   value="{{ $chat->product->price }}" min="1" required>
                        </div>
                        <div class="form-group-custom">
                            <label class="form-label-custom">Masa Berlaku Link <span class="required-star">*</span></label>
                            <select name="duration" class="form-input-custom" required>
                                <option value="15">15 Menit</option>
                                <option value="30">30 Menit</option>
                                <option value="60">1 Jam</option>
                                <option value="180" selected>3 Jam</option>
                                <option value="360">6 Jam</option>
                                <option value="720">12 Jam</option>
                                <option value="1440">24 Jam</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer-custom">
                        <button type="button" class="btn-modal-cancel" onclick="document.getElementById('purchaseLinkModal').style.display='none'">Batal</button>
                        <button type="submit" class="btn-modal-submit">
                            <i class="bi bi-send-fill"></i> Kirim Link
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>

<script>
    window.currentPOV = @json($currentPOV);

    // Auto-scroll ke pesan terbawah
    document.addEventListener('DOMContentLoaded', function() {
        const chatMessages = document.getElementById('chatMessages');
        if (chatMessages) {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    });
</script>
@endsection
