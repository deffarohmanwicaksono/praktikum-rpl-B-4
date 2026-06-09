@extends('layouts.app')

@section('title', 'Beranda - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite('resources/css/pages/home.css')
@endpush

{{-- PAGE JS --}}
@push('scripts')
    <script>
        window.wishlistedProductIds = {!! json_encode($wishlistedIds ?? []) !!};
    </script>
    @vite('resources/js/home/home.js')
@endpush

@section('content')

{{-- HERO --}}
<section class="hero-banner" style="background-image: url('{{ asset('images/Elemen-2.png') }}');">
    <div class="hero-content">
        <h1 class="hero-title">
            Jual Beli Barang Bekas<br>
            <span class="hero-accent">Jadi Lebih Mudah di SeMart!</span>
        </h1>
        <p class="hero-sub">Aman, terpercaya, dan khusus untuk mahasiswa UNS.</p>
        <a href="{{ route('seller.dashboard-seller') }}" class="hero-btn">
            Jual Sekarang <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</section>

<section class="filter-bar">

    @include('components.filter-bar')

</section>

{{-- PRODUCT GRID --}}
<section class="product-grid">

    @forelse ($products as $product)
       @include('components.product-card', ['product' => $product])
    @empty
        <div class="no-product">
            <p>Belum ada produk yang dijual saat ini.</p>
        </div>
    @endforelse

</section>

@endsection
