@extends('layouts.app')

@section('title', 'Wishlist - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite(['resources/css/pages/wishlist.css'])
@endpush

{{-- PAGE JS --}}
@push('scripts')
    <script>
        window.wishlistRoutes = {
            clearAll: "{{ route('wishlist.clear') }}",
            baseUrl: "{{ url('/wishlist') }}"
        };
    </script>
    @vite(['resources/js/wishlist/wishlist.js'])
@endpush

@section('content')

{{-- PAGE HEADER --}}
<div class="wishlist-header">
    <div class="wishlist-header-left">
        <h1 class="wishlist-title">
            <i class="bi bi-heart-fill"></i>
            Wishlist Saya
        </h1>
        <p class="wishlist-sub">Produk-produk yang telah diberi tanda suka oleh buyer.</p>
    </div>

    @if($wishlists->isNotEmpty())
        <button class="clear-all-btn" id="clearAllBtn">
            <i class="bi bi-trash"></i>
            Hapus Semua (<span id="wishlistCount">{{ $wishlists->count() }}</span>)
        </button>
    @endif
</div>

{{-- PRODUCT GRID --}}
<section class="product-grid" id="wishlistGrid" style="{{ $wishlists->isEmpty() ? 'display: none;' : '' }}">
    @foreach ($wishlists as $wishlist)
        <div class="wishlist-item" data-product-id="{{ $wishlist->product_id }}" style="display: contents;">
            @include('components.product-card', ['product' => $wishlist->product])
        </div>
    @endforeach
</section>

{{-- EMPTY STATE --}}
<div class="wishlist-empty-full" id="wishlistEmptyFull" style="{{ $wishlists->isEmpty() ? 'display: flex;' : 'display: none;' }}">
    <div class="empty-icon">
        <i class="bi bi-heart"></i>
    </div>
    <h2 class="empty-title">Wishlist kamu masih kosong</h2>
    <p class="empty-desc">Tambahkan produk favoritmu dari halaman beranda untuk melihatnya di sini.</p>
    <a href="{{ route('home') }}" class="empty-cta-btn">
        Jelajahi Produk <i class="bi bi-arrow-right"></i>
    </a>
</div>

@endsection