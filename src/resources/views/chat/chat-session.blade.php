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
    $currentPOV = request()->get('pov', 'buyer');
@endphp

<div class="chat-shell">

    <div class="chat-head">
        <span class="chat-head-sep"></span>

        <div class="chat-head-contact">
            <div class="chat-head-foto">
                <img
                    src="{{ asset('images/Elemen-1.png') }}"
                    alt="Produk"
                    class="chat-head-foto-img"
                >
            </div>

            <div class="chat-head-info">
                <span class="chat-head-name" id="chatHeaderName">
                    {{ $currentPOV === 'buyer' ? 'Andi Pratama' : 'Andi Pratama' }}
                </span>

                <span class="chat-head-product">
                    <i class="bi bi-tag-fill"></i>
                    Jaket Denim Pria
                </span>
            </div>
        </div>
    </div>

    <div class="chat-messages" id="chatMessages"></div>

    <div class="chat-input-bar">
        <div class="chat-input-wrap">
            <textarea
                class="chat-textarea"
                id="chatInput"
                placeholder="Tulis pesan..."
                rows="1"
            ></textarea>

            <button type="button" class="chat-emoji-btn" id="emojiBtn">
                <i class="bi bi-emoji-smile"></i>
            </button>
        </div>

        <button type="button" class="btn-kirim" id="sendBtn">
            <i class="bi bi-send-fill"></i>
        </button>
    </div>

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

            <button type="button" class="btn-kirim-link">
                <i class="bi bi-link-45deg"></i>
                Kirim Link
            </button>
        </div>
    @endif

</div>

<script>
    window.currentPOV = @json($currentPOV);
</script>

@endsection