@extends('layouts.app')

@section('title', 'Profil Seller - SeMart')

@push('styles')
    @vite('resources/css/pages/profile-seller.css')
@endpush

@push('scripts')
    @vite('resources/js/profile/profile-seller.js')
@endpush

@section('content')

{{-- HEADER --}}
<section class="page-header-section">
    <div>
        <h1 class="page-title">Profil Seller</h1>
        <p class="page-subtitle">
            Informasi lengkap dan ulasan tentang penjual.
        </p>
    </div>
</section>

{{-- SELLER PROFILE CARD --}}
<section class="seller-profile-card">
    <div class="profile-header">
        <div class="seller-avatar-icon">
            <i class="bi bi-person-fill"></i>
        </div>

        <div class="seller-info">
            <h2>{{ $seller['name'] }}</h2>
            <div class="seller-badges">
                <div class="verified-badge">
                    <i class="bi bi-patch-check-fill"></i>
                    Seller Terverifikasi
                </div>
            </div>
            <div class="seller-joined">
                <i class="bi bi-calendar-event"></i>
                Bergabung {{ $seller['joined'] }}
            </div>
        </div>
    </div>

    {{-- STATS --}}
    <div class="profile-stats">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <h3>{{ $seller['sold_count'] }}</h3>
                <p>Barang Terjual</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-star"></i>
            </div>
            <div>
                <h3 class="rating-wrapper">
                    {{ $seller['rating'] }}
                    <span class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($seller['rating'] >= $i)
                                <i class="bi bi-star-fill"></i>
                            @elseif($seller['rating'] >= $i - 0.5)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </span>
                </h3>
                <p>{{ $seller['reviews_count'] }} Ulasan Pembeli</p>
            </div>
        </div>
    </div>
</section>

{{-- REVIEWS SECTION --}}
<section class="review-section">
    <h3 class="review-title">Ulasan dari Pembeli</h3>
    <div class="reviews-list-container">
        @foreach($reviews as $review)
        <div class="review-card">
            <div class="review-header">
                <div class="buyer-avatar-icon">
                    <i class="bi bi-person-fill"></i>
                </div>
                <div>
                    <h4>{{ $review['buyer'] }}</h4>
                    <div class="review-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($review['rating'] >= $i)
                                <i class="bi bi-star-fill"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </div>
                </div>
            </div>

            <p class="review-comment">"{{ $review['comment'] }}"</p>

            <div class="review-product">
                <img src="{{ $review['product_image'] }}" alt="Gambar Produk">
                <div>
                    <div class="product-name">{{ $review['product'] }}</div>
                    <div class="product-date">{{ $review['date'] }}</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

@endsection