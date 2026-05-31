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
    $chats = [
        [
            'name' => 'Andi Pratama',
            'pov' => 'seller',
            'product' => 'Jaket Denim Pria',
            'preview' => 'Halo kak, masih ada jaketnya?',
            'time' => '14:30',
            'unread' => 3,
            'image' => asset('images/Elemen-1.png'),
        ],
        [
            'name' => 'Siti Aisyah',
            'pov' => 'buyer',
            'product' => 'Tas Ransel Eiger Original',
            'preview' => 'Terima kasih kak!',
            'time' => '10:15',
            'unread' => 1,
            'image' => asset('images/Elemen-1.png'),
        ],
        [
            'name' => 'Budi Santoso',
            'pov' => 'seller',
            'product' => 'Kalkulator Casio fx-991EX',
            'preview' => 'Oke, kapan bisa ketemunya?',
            'time' => '16:45',
            'unread' => 2,
            'image' => asset('images/Elemen-1.png'),
        ],
        [
            'name' => 'Dewi Lestari',
            'pov' => 'buyer',
            'product' => 'Buku Atomic Habits',
            'preview' => 'Baik kak, ditunggu ya 😊',
            'time' => '09:20',
            'unread' => 0,
            'image' => asset('images/Elemen-1.png'),
        ],
        [
            'name' => 'Rizky Aditya',
            'pov' => 'seller',
            'product' => 'Mouse Logitech MX Master',
            'preview' => 'Siap kak, noted!',
            'time' => 'Kemarin',
            'unread' => 0,
            'image' => asset('images/Elemen-1.png'),
        ],
    ];

    $totalUnread = collect($chats)->sum('unread');
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

            <a
                href="{{ route('chat.session', [
                    'pov' => $chat['pov'],
                    'partner' => $chat['name']
                ]) }}"
                class="chat-item {{ $chat['unread'] > 0 ? 'chat-item--unread' : '' }}"
                data-unread="{{ $chat['unread'] > 0 ? 'true' : 'false' }}"
                data-name="{{ strtolower($chat['name']) }}"
                data-barang="{{ strtolower($chat['product']) }}"
            >

            @if ($chat['image'])

                <div class="chat-foto-wrap">
                    <img
                        src="{{ $chat['image'] }}"
                        alt="{{ $chat['product'] }}"
                        class="chat-foto"
                        loading="lazy"
                    >
                </div>

            @else

                <div class="chat-foto-wrap chat-foto-wrap--placeholder">
                    <i class="bi bi-image chat-foto-placeholder-icon"></i>
                </div>

            @endif

            <div class="chat-body">

                <div class="chat-row-top">

                    <span class="chat-nama">
                        {{ $chat['name'] }}
                    </span>

                    <span class="chat-waktu">
                        {{ $chat['time'] }}
                    </span>

                </div>

                <div class="chat-row-mid">

                    <span class="chat-barang">
                        {{ $chat['product'] }}
                    </span>

                </div>

                <div class="chat-row-bot">

                    <span class="chat-preview {{ $chat['unread'] === 0 ? 'chat-preview--read' : '' }}">
                        {{ $chat['preview'] }}
                    </span>

                    @if ($chat['unread'] > 0)

                        <span class="chat-badge">
                            {{ $chat['unread'] }}
                        </span>

                    @endif

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