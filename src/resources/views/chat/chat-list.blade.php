@extends('layouts.app')

@section('title', 'Daftar Chat - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite('resources/css/pages/chat-list.css')
@endpush

{{-- PAGE JS --}}
@push('scripts')
    @vite('resources/js/chat/chat-list.js')
@endpush

@section('content')

@php
    $userId = auth()->id();
    $totalUnread = 0; // Bisa diimplementasi nanti dengan kolom is_read
@endphp

{{-- PAGE HEADER --}}
<section class="page-header">

    <div class="page-header-left">
        <h1 class="page-title">Chat</h1>
        <p class="page-subtitle">
            Semua percakapan dengan lawan bicara kamu
        </p>
    </div>

    <div class="page-header-right">
        <div class="unread-summary-chip">
            <i class="bi bi-chat-dots-fill"></i>

            <span class="unread-num">
                {{ $totalUnread }}
            </span>

            <span>pesan belum dibaca</span>
        </div>
    </div>

</section>

{{-- SEARCH & FILTER --}}
<section class="chat-filter-bar">

    <div class="chat-search-wrap">
        <i class="bi bi-search chat-search-icon"></i>

        <input
            type="text"
            class="chat-search-input"
            id="chatSearchInput"
            placeholder="Cari nama atau barang..."
            autocomplete="off"
        >

        <button
            class="chat-search-clear"
            id="chatSearchClear"
            aria-label="Hapus pencarian"
            style="display: none;"
        >
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="chat-filter-tabs" role="tablist">

        <button
            class="chat-filter-tab active"
            data-filter="semua"
            role="tab"
            aria-selected="true"
        >
            Semua

            <span class="chat-filter-count">
                {{ count($chats) }}
            </span>
        </button>

        <button
            class="chat-filter-tab"
            data-filter="unread"
            role="tab"
            aria-selected="false"
        >
            Belum Dibaca

            <span class="chat-filter-count">
                {{ collect($chats)->where('unread', '>', 0)->count() }}
            </span>
        </button>

    </div>

</section>

{{-- CHAT LIST --}}
<section class="chat-list-section" id="chatListSection">

        @forelse ($chats as $chat)

            @php
                $partner = ($chat->seller_id === $userId) ? $chat->buyer : $chat->seller;
                $pov = ($chat->seller_id === $userId) ? 'seller' : 'buyer';
                $productImage = $chat->product->productImages->first();
                $imageUrl = $productImage
                    ? asset('storage/' . $productImage->image_path)
                    : asset('images/Elemen-1.png');
                $preview = $chat->latestMessage
                    ? $chat->latestMessage->message
                    : 'Belum ada pesan';
                $time = $chat->updated_at ? $chat->updated_at->format('H:i') : '-';
            @endphp

            <a
                href="{{ route('chat.session', $chat->id) }}"
                class="chat-item"
                data-unread="false"
                data-name="{{ strtolower($partner->name) }}"
                data-barang="{{ strtolower($chat->product->name) }}"
            >

            <div class="chat-foto-wrap">
                <img
                    src="{{ $imageUrl }}"
                    alt="{{ $chat->product->name }}"
                    class="chat-foto"
                    loading="lazy"
                >
            </div>

            <div class="chat-body">

                <div class="chat-row-top">
                    <span class="chat-nama">
                        {{ $partner->name }}
                    </span>
                    <span class="chat-waktu">
                        {{ $time }}
                    </span>
                </div>

                <div class="chat-row-mid">
                    <span class="chat-barang">
                        {{ $chat->product->name }}
                    </span>
                </div>

                <div class="chat-row-bot">
                    <span class="chat-preview chat-preview--read">
                        {{ Str::limit($preview, 50) }}
                    </span>
                </div>

            </div>

            <div class="chat-arrow">
                <i class="bi bi-chevron-right"></i>
            </div>

        </a>

    @empty

        <div class="chat-empty" style="display:flex;">

            <div class="chat-empty-icon">
                <i class="bi bi-chat-dots"></i>
            </div>

            <p class="chat-empty-title">
                Tidak Ada Percakapan
            </p>

            <p class="chat-empty-desc">
                Tidak ditemukan percakapan yang sesuai.
            </p>

        </div>

    @endforelse

    {{-- EMPTY SEARCH STATE --}}
    <div
        class="chat-empty"
        id="chatEmpty"
        style="display:none;"
        aria-live="polite"
    >

        <div class="chat-empty-icon">
            <i class="bi bi-chat-dots"></i>
        </div>

        <p class="chat-empty-title">
            Tidak Ada Percakapan
        </p>

        <p class="chat-empty-desc">
            Tidak ditemukan percakapan yang sesuai.
        </p>

    </div>

</section>

{{-- INFO BANNER --}}
<section class="info-banner mt-4">

    <div class="info-banner-inner">

        <i class="bi bi-info-circle-fill info-banner-icon"></i>

        <div>
            <span class="info-banner-text">
                Badge angka menunjukkan jumlah pesan yang belum dibaca.<br>
                Pesan yang masuk terlebih dahulu akan ditampilkan paling atas.
            </span>
        </div>

    </div>

</section>

@endsection
