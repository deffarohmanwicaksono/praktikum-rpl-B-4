@extends('layouts.app')

@section('title', 'Detail Produk - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite('resources/css/pages/detail-product.css')
@endpush

{{-- PAGE JS --}}
@push('scripts')
    @vite('resources/js/products/detail-product.js')
@endpush

@section('content')

<div class="detail-layout">

    {{-- LEFT --}}
    <div class="detail-left">

        {{-- MAIN IMAGE --}}
        <div class="main-image-wrap" id="mainImageWrap">

            <img
                src="{{ asset('images/Elemen-1.png') }}"
                alt="MacBook Air M1 2020"
                class="main-image"
                id="mainImage"
            >

            <div class="zoom-hint">
                <i class="bi bi-zoom-in"></i>
                Klik untuk perbesar
            </div>

        </div>

        {{-- THUMBNAILS --}}
        <div class="thumbnail-strip">

            <div class="thumbnails-wrap" id="thumbnailsWrap">

                @for ($i = 1; $i <= 5; $i++)
                    <button
                        class="thumb {{ $i === 1 ? 'active' : '' }}"
                        data-img="{{ asset('images/Elemen-1.png') }}"
                        data-idx="{{ $i - 1 }}"
                    >
                        <img
                            src="{{ asset('images/Elemen-1.png') }}"
                            alt="Foto {{ $i }}"
                        >
                    </button>
                @endfor

            </div>

            <button
                class="thumb-arrow"
                id="thumbArrow"
                aria-label="Foto lainnya"
            >
                <i class="bi bi-chevron-right"></i>
            </button>

        </div>

        {{-- SELLER CARD --}}
        <div class="seller-card">

            <div class="seller-left">

                <p class="seller-label">
                    Dijual oleh
                </p>

                <div class="seller-main">

                    {{-- AVATAR ICON --}}
                    <div class="seller-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div class="seller-details">

                        <div class="seller-name-row">

                            <span class="seller-name">
                                Andi Pratama
                            </span>

                            <span
                                class="seller-verified"
                                title="Terverifikasi"
                            >
                                <i class="bi bi-patch-check-fill"></i>
                            </span>

                        </div>

                        <div class="seller-rating">

                            <span class="rating-val">
                                4.9
                            </span>

                            <div class="stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>

                            <span class="rating-count">
                                (128 ulasan)
                            </span>

                        </div>

                        <div class="seller-location">

                            <i class="bi bi-geo-alt"></i>

                            <span>
                                Kampus UNS
                            </span>

                        </div>

                    </div>

                </div>

            </div>

            <a href="#" class="seller-profile-btn">
                Lihat Profil Seller
                <i class="bi bi-arrow-right"></i>
            </a>

        </div>

        {{-- ACTION BUTTONS --}}
        <div class="action-cards-row">

            <button class="action-card" id="wishlistCardBtn">

                <div class="action-icon-wrap">
                    <i class="bi bi-heart" id="wishlistCardIcon"></i>
                </div>

                <div class="action-text">

                    <span
                        class="action-title"
                        id="wishlistCardTitle"
                    >
                        Simpan ke Wishlist
                    </span>

                    <span class="action-sub">
                        Simpan untuk nanti
                    </span>

                </div>

            </button>

            <button class="action-card action-card--report">

                <div class="action-icon-wrap action-icon--report">
                    <i class="bi bi-flag"></i>
                </div>

                <div class="action-text">

                    <span class="action-title">
                        Laporkan Produk
                    </span>

                    <span class="action-sub">
                        Laporkan jika melanggar aturan
                    </span>

                </div>

            </button>

        </div>

    </div>

    {{-- RIGHT --}}
    <div class="detail-right">

        <span class="category-tag">
            Elektronik
        </span>

        <h1 class="product-title">
            Laptop MacBook Air M1 2020
        </h1>

        <p class="product-price">
            Rp 7.500.000
        </p>

        <div class="condition-row">
            <span class="cond-pill bekas-baik">
                Bekas Seperti Baru
            </span>
        </div>

        {{-- DESCRIPTION --}}
        <div class="desc-section">

            <h3 class="desc-title">
                Deskripsi
            </h3>

            <div class="desc-text">

                <p>
                    <strong>MacBook Air M1 2020 (Space Gray)</strong><br>
                    Laptop andalan dengan performa chip M1 yang masih sangat kencang untuk kebutuhan kuliah, browsing, desain grafis ringan, hingga editing video/foto. Sangat cocok bagi mahasiswa atau pekerja kreatif yang membutuhkan mobilitas tinggi.
                </p>

                <p class="desc-extra" id="descExtra" style="display:none">

                    <strong>Spesifikasi Singkat:</strong><br>
                    • RAM: 8GB Unified Memory<br>
                    • SSD: 256GB (Super cepat)<br>
                    • Layar: Retina Display 13.3 inci yang jernih<br>
                    • Baterai: Health masih sangat awet (di atas 90%)<br><br>

                    <strong>Kondisi:</strong><br>
                    • Body mulus 98%, tidak ada dent atau goresan berarti.<br>
                    • Layar bersih, tidak ada dead pixel.<br>
                    • Semua fitur (Keyboard, Trackpad, Webcam, Speaker) berjalan normal tanpa kendala.<br>
                    • Kelengkapan: Unit MacBook dan Charger original (Box sudah tidak ada).<br><br>

                    <strong>Alasan Dijual:</strong><br>
                    Upgrade ke seri Pro karena kebutuhan project yang lebih berat.

                </p>

            </div>

            <button class="desc-toggle" id="descToggle">
                Lihat selengkapnya
                <i class="bi bi-chevron-down"></i>
            </button>

        </div>

        {{-- CHAT CTA --}}
        <div class="chat-cta">

            <div class="chat-cta-left">

                <div class="chat-cta-icon">
                    <i class="bi bi-chat-dots-fill"></i>
                </div>

                <div class="chat-cta-info">

                    <span class="chat-cta-title">
                        Chat dengan Seller
                    </span>

                    <span class="chat-cta-sub">
                        Tanyakan detail barang sebelum membeli.
                    </span>

                </div>

            </div>

            <a
                href="{{ route('chat.session', [
                    'from' => 'search',
                    'pov' => 'buyer',
                    'partner' => 'Andi Pratama'
                ]) }}"
                class="chat-cta-btn"
            >
                Mulai Chat
            </a>

        </div>

    </div>

</div>

{{-- LIGHTBOX --}}
<div class="lightbox" id="lightbox">

    <button class="lb-close" id="lbClose">
        <i class="bi bi-x-lg"></i>
    </button>

    <button class="lb-nav lb-prev" id="lbPrev">
        <i class="bi bi-chevron-left"></i>
    </button>

    <div class="lb-content">
        <img src="" alt="" id="lbImg" class="lb-img">
    </div>

    <button class="lb-nav lb-next" id="lbNext">
        <i class="bi bi-chevron-right"></i>
    </button>

    <div class="lb-counter" id="lbCounter">
        1 / 5
    </div>

</div>

@endsection