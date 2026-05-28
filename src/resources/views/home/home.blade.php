@extends('layouts.app')

@section('title', 'Beranda - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite('resources/css/pages/home.css')
@endpush

{{-- PAGE JS --}}
@push('scripts')
    @vite('resources/js/home/home.js')
@endpush

@section('content')

@php
$products = [
    [
        'name' => 'iPad Air 4 64GB',
        'price' => 'Rp 4.200.000',
        'condition' => 'Bekas Seperti Baru',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'name' => 'Buku Kalkulus',
        'price' => 'Rp 45.000',
        'condition' => 'Bekas Baik',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'name' => 'Jaket Hoodie Uniqlo',
        'price' => 'Rp 120.000',
        'condition' => 'Bekas Baik',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'name' => 'Headset Sony WH-CH510',
        'price' => 'Rp 250.000',
        'condition' => 'Bekas Baik',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'name' => 'Meja Belajar Lipat',
        'price' => 'Rp 150.000',
        'condition' => 'Bekas Baik',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'name' => 'MacBook Air M1 8GB',
        'price' => 'Rp 9.500.000',
        'condition' => 'Bekas Seperti Baru',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'name' => 'Nike Air Max 270',
        'price' => 'Rp 380.000',
        'condition' => 'Bekas Baik',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'name' => 'Raket Badminton Yonex',
        'price' => 'Rp 85.000',
        'condition' => 'Bekas Layak Pakai',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'name' => 'Kemeja Flanel Oversize',
        'price' => 'Rp 55.000',
        'condition' => 'Bekas Seperti Baru',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'name' => 'Sepatu Running Adidas',
        'price' => 'Rp 290.000',
        'condition' => 'Bekas Baik',
        'image' => asset('images/Elemen-1.png'),
    ],
];
@endphp

{{-- HERO --}}
<section class="hero-banner" style="background-image: url('{{ asset('images/Elemen-2.png') }}');">
    <div class="hero-content">
        <h1 class="hero-title">
            Jual Beli Barang Bekas<br>
            <span class="hero-accent">Jadi Lebih Mudah di SeMart!</span>
        </h1>
        <p class="hero-sub">Aman, terpercaya, dan khusus untuk mahasiswa UNS.</p>
        <a href="#" class="hero-btn">
            Jual Sekarang <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</section>

<section class="filter-bar">

    @include('components.filter-bar')

</section>

{{-- PRODUCT GRID --}}
<section class="product-grid">

    @foreach ($products as $product)
        @include('components.product-card', $product)
    @endforeach

</section>

@endsection
