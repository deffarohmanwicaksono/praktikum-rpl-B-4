@extends('layouts.app')

@section('title', 'Detail Produk - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite('resources/css/pages/detail-product.css')
@endpush

{{-- PAGE JS --}}
@push('scripts')
    <script>
        window.wishlistedProductIds = {!! json_encode($wishlistedIds ?? []) !!};
    </script>
    @vite('resources/js/products/detail-product.js')
@endpush

@section('content')

@php
    $images = $product->productImages->sortBy('order')->values();

    $processedImages = $images->map(function($img) {
        $url = $img->image_url;
        if (str_starts_with($url, 'http')) return $url;
        if (str_starts_with($url, 'images/')) return asset($url);
        return asset('storage/' . ltrim($url, '/'));
    });

    $mainImageUrl = $processedImages->first() ?? asset('images/placeholder.png');

    $condLabel = [
        'bekas_seperti_baru' => 'Bekas Seperti Baru',
        'bekas_baik'         => 'Bekas Baik',
        'bekas_layak_pakai'  => 'Bekas Layak Pakai',
    ];
    $condDisplay = $condLabel[$product->condition ?? 'bekas_baik'] ?? ucfirst(str_replace('_', ' ', $product->condition));
    $condClass   = $product->condition ?? 'bekas_baik';
@endphp

<div class="detail-layout">

    {{-- LEFT --}}
    <div class="detail-left">

        {{-- MAIN IMAGE --}}
        <div class="main-image-wrap" id="mainImageWrap">

            <img
                src="{{ $mainImageUrl }}"
                alt="{{ $product->name }}"
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

                @forelse ($processedImages as $idx => $imgUrl)
                    <button
                        class="thumb {{ $idx === 0 ? 'active' : '' }}"
                        data-img="{{ $imgUrl }}"
                        data-idx="{{ $idx }}"
                    >
                        <img
                            src="{{ $imgUrl }}"
                            alt="Foto {{ $idx + 1 }}"
                        >
                    </button>
                @empty
                    <button class="thumb active"
                        data-img="{{ asset('images/placeholder.png') }}"
                        data-idx="0">
                        <img src="{{ asset('images/placeholder.png') }}" alt="Foto 1">
                    </button>
                @endforelse

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
                                {{ $product->user->name ?? 'Seller SeMart' }}
                            </span>

                            <span
                                class="seller-verified"
                                title="Terverifikasi"
                            >
                                <i class="bi bi-patch-check-fill"></i>
                            </span>

                        </div>

                        <div class="seller-rating">
                            @if($sellerReviewsCount > 0)
                                <span class="rating-val">
                                    {{ $sellerRating }}
                                </span>

                                <div class="stars">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($sellerRating >= $i)
                                            <i class="bi bi-star-fill"></i>
                                        @elseif($sellerRating >= $i - 0.5)
                                            <i class="bi bi-star-half"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>

                                <span class="rating-count">
                                    ({{ $sellerReviewsCount }} ulasan)
                                </span>
                            @else
                                <span class="no-reviews">
                                    Belum ada ulasan
                                </span>
                            @endif
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

            <a href="{{ route('seller.profile', ['id' => $product->user_id ?? 1]) }}" class="seller-profile-btn">
                Lihat Profil Seller
                <i class="bi bi-arrow-right"></i>
            </a>

        </div>

        {{-- ACTION BUTTONS --}}
        <div class="action-cards-row">

            <button class="action-card" id="wishlistCardBtn" data-product-id="{{ $product->id }}">

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

            {{-- TOMBOL LAPORKAN BARANG --}}
            <button class="action-card action-card--report" id="openReportModalBtn">

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
            {{ $product->category->name ?? 'Lainnya' }}
        </span>

        <h1 class="product-title">
            {{ $product->name }}
        </h1>

        <p class="product-price">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </p>

        <div class="condition-row">
            <span class="cond-pill {{ $condClass }}">
                {{ $condDisplay }}
            </span>
        </div>

        {{-- DESCRIPTION --}}
        <div class="desc-section">

            <h3 class="desc-title">
                Deskripsi
            </h3>

            <div class="desc-text">
                @php
                    $fullDesc   = $product->description ?? 'Tidak ada deskripsi.';
                    $shortLimit = 200;
                    $isLong     = mb_strlen($fullDesc) > $shortLimit;
                    $shortDesc  = $isLong ? mb_substr($fullDesc, 0, $shortLimit) . '...' : $fullDesc;
                @endphp

                <p>{!! nl2br(e($isLong ? $shortDesc : $fullDesc)) !!}</p>

                @if ($isLong)
                <p class="desc-extra" id="descExtra" style="display:none">
                    {!! nl2br(e($fullDesc)) !!}
                </p>
                @endif

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

            @if (auth()->check() && auth()->id() !== ($product->user_id ?? 0))
                <form action="{{ route('chat.store') ?? '#' }}" method="POST">
                    @csrf
                    <input type="hidden" name="seller_id" value="{{ $product->user_id ?? '' }}">
                    <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">
                    <button type="submit" class="chat-cta-btn">
                        Mulai Chat
                    </button>
                </form>
            @else
                <span class="chat-cta-btn" style="opacity: 0.5; cursor: not-allowed;">
                    Produk Anda
                </span>
            @endif

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

{{-- REPORT MODAL --}}
<div class="report-modal-overlay" id="reportModal">
    <div class="report-modal-content">
        <div class="report-modal-header">
            <h3>Laporkan Produk</h3>
            <button class="report-modal-close" id="closeReportModalBtn">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <form action="{{ route('report.store') ?? '#' }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">

            <div class="report-modal-body">
                {{-- Info Produk --}}
                <div class="report-product-card">

                    <div class="report-product-image">
                        <img
                            src="{{ $mainImageUrl }}"
                            alt="{{ $product->name }}"
                        >
                    </div>

                    <div class="report-product-info">

                        <h4>
                            {{ $product->name }}
                        </h4>

                        <p class="report-product-price">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </p>

                        <span class="report-product-seller">
                            Seller:
                            {{ $product->user->name ?? 'Andi Pratama' }}
                        </span>

                    </div>

                </div>

                {{-- Info Pelapor --}}
                <div class="report-reporter-card">

                    <div class="report-reporter-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div class="report-reporter-info">

                        <span class="report-reporter-label">
                            Pelapor
                        </span>

                        <strong>
                            {{ auth()->user()->name ?? 'Nama Pelapor' }}
                        </strong>

                    </div>

                </div>

                {{-- Form Input Alasan --}}
                <div class="report-form-group">
                    <label for="reportReason">Alasan Laporan <span class="text-danger">*</span></label>
                    <textarea 
                        id="reportReason" 
                        name="reason" 
                        rows="4" 
                        placeholder="Jelaskan secara detail mengapa produk ini dilaporkan..." 
                        required></textarea>
                </div>
            </div>

            <div class="report-modal-footer">
                <button type="button" class="btn-cancel" id="cancelReportBtn">Batal</button>
                <button type="submit" class="btn-submit">Kirim Laporan</button>
            </div>
        </form>
    </div>
</div>

@endsection