@extends('layouts.app')

@section('title', 'Profil Seller - SeMart')

@push('styles')
    @vite('resources/css/pages/profile-seller.css')
@endpush

@push('scripts')
    @vite('resources/js/profile/profile-seller.js')
@endpush

@section('content')

@php

$seller = [
    'name'          => 'Andi Pratama',
    'joined'        => '12 Jan 2024', // Data bergabung ditambahkan di sini
    'sold_count'    => 342, 
    'rating'        => 4.2,
    'reviews_count' => 12
];

// Data dummy ulasan diperbanyak
$reviews = [
    [
        'buyer'         => 'Syifa Ramadhani',
        'rating'        => 5,
        'comment'       => 'Barang sesuai deskripsi, penjual ramah fast respon! Packing juga aman banget.',
        'product'       => 'MacBook Air M1 2020',
        'date'          => '20/05/2025',
        'product_image' => asset('images/Elemen-1.png')
    ],
    [
        'buyer'         => 'Raka Aditya',
        'rating'        => 4,
        'comment'       => 'Barang oke, tapi pengiriman agak lambat sedikit dari ekspedisinya.',
        'product'       => 'Buku Ekonomi Mikro',
        'date'          => '12/05/2025',
        'product_image' => asset('images/Elemen-1.png')
    ],
    [
        'buyer'         => 'Budi Santoso',
        'rating'        => 5,
        'comment'       => 'Mantap! Harga bersahabat dan kualitas original. Bakal langganan di sini.',
        'product'       => 'Kalkulator Casio FX-991EX',
        'date'          => '05/05/2025',
        'product_image' => asset('images/Elemen-1.png')
    ],
    [
        'buyer'         => 'Diana Fitri',
        'rating'        => 5,
        'comment'       => 'Respons penjual sangat cepat, kemarin pesan hari ini langsung sampai kos.',
        'product'       => 'Lampu Belajar LED',
        'date'          => '28/04/2025',
        'product_image' => asset('images/Elemen-1.png')
    ],
    [
        'buyer'         => 'Kevin Wijaya',
        'rating'        => 3,
        'comment'       => 'Barang lumayan, sesuai dengan harga lah. Kurirnya aja yang nyasar.',
        'product'       => 'Mouse Wireless Logitech',
        'date'          => '15/04/2025',
        'product_image' => asset('images/Elemen-1.png')
    ],
    [
        'buyer'         => 'Nisa Salsabila',
        'rating'        => 5,
        'comment'       => 'Suka banget! Kondisi buku masih mulus banget kayak baru. Recommended seller!',
        'product'       => 'Buku Kalkulus Edisi 9',
        'date'          => '02/04/2025',
        'product_image' => asset('images/Elemen-1.png')
    ]
];

@endphp

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
        {{-- AVATAR ICON SELLER --}}
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

            {{-- Info Bergabung --}}
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

    <h3 class="review-title">
        Ulasan dari Pembeli
    </h3>

    {{-- Kumpulan Ulasan --}}
    <div class="reviews-list-container">
        @foreach($reviews as $review)

        <div class="review-card">
            <div class="review-header">
                {{-- AVATAR ICON BUYER --}}
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

            <p class="review-comment">
                "{{ $review['comment'] }}"
            </p>

            <div class="review-product">
                <img src="{{ $review['product_image'] }}" alt="Gambar Produk">
                <div>
                    <div class="product-name">
                        {{ $review['product'] }}
                    </div>
                    <div class="product-date">
                        {{ $review['date'] }}
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </div>

</section>

@endsection