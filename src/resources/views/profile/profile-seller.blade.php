@extends('layouts.app')

@section('title', 'Profil Seller - SeMart')

@push('styles')
    @vite('resources/css/pages/profil-seller.css')
@endpush

@push('scripts')
    @vite('resources/js/profile/profil-seller.js')
@endpush

@section('content')

@php

$seller = [
    'name' => 'Andi Pratama',
    'avatar' => asset('images/default-avatar.jpg'),
    'rating' => 4.2,
    'reviews_count' => 12
];

$reviews = [

    [
        'buyer' => 'Syifa Ramadhani',
        'avatar' => asset('images/default-avatar.jpg'),
        'rating' => 5,
        'comment' => 'Barang sesuai deskripsi, penjual ramah fast respon!',
        'product' => 'MacBook Air M1 2020',
        'date' => '20/05/2025',
        'product_image' => asset('images/Elemen-1.png')
    ],

    [
        'buyer' => 'Raka Aditya',
        'avatar' => asset('images/default-avatar.jpg'),
        'rating' => 4,
        'comment' => 'Barang oke, tapi pengiriman agak lambat.',
        'product' => 'Buku Ekonomi Mikro',
        'date' => '12/05/2025',
        'product_image' => asset('images/Elemen-1.png')
    ]

];

@endphp

<section class="page-header-section">

    <h1 class="page-title">
        PROFIL SELLER
    </h1>

</section>

<div class="seller-profile-card">

    <div class="seller-avatar">
        <img src="{{ $seller['avatar'] }}" alt="">
    </div>

    <div class="seller-info">

        <h2>{{ $seller['name'] }}</h2>

        <div class="verified-badge">
            <i class="bi bi-patch-check-fill"></i>
            Seller Terverifikasi
        </div>

        <div class="seller-rating">

            @for($i=1;$i<=5;$i++)
                <i class="bi bi-star-fill"></i>
            @endfor

            <span>
                {{ $seller['rating'] }}
                ({{ $seller['reviews_count'] }} ulasan)
            </span>

        </div>

    </div>

</div>

<section class="review-section">

    <h3 class="review-title">
        ULASAN DARI PEMBELI
    </h3>

    @foreach($reviews as $review)

    <div class="review-card">

        <div class="review-header">

            <img
                src="{{ $review['avatar'] }}"
                class="buyer-avatar"
                alt="">

            <div>

                <h4>{{ $review['buyer'] }}</h4>

                <div class="review-stars">

                    @for($i=1;$i<=$review['rating'];$i++)
                        <i class="bi bi-star-fill"></i>
                    @endfor

                </div>

            </div>

        </div>

        <p class="review-comment">
            "{{ $review['comment'] }}"
        </p>

        <div class="review-product">

            <img
                src="{{ $review['product_image'] }}"
                alt="">

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

    <div class="review-footer">

        <button class="btn-all-review">
            Lihat semua ulasan
            <i class="bi bi-arrow-right"></i>
        </button>

    </div>

</section>

@endsection