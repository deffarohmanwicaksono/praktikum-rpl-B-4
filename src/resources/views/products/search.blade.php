@extends('layouts.app')

@section('title', 'Pencarian - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite('resources/css/pages/search.css')
@endpush

{{-- PAGE JS --}}
@push('scripts')
    <script>
        window.wishlistedProductIds = {!! json_encode($wishlistedIds ?? []) !!};
        window.SeMartConfig = { appUrl: '{{ url("/") }}'};
    </script>
    @vite('resources/js/products/search.js')
@endpush

@section('content')

@if(!request()->has('q') && !request()->has('category') && !request()->has('sort'))

<div id="stateEmpty" class="search-state">
    <div class="empty-state-wrap">

        <div class="empty-illustration">
            <svg viewBox="0 0 220 180" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="110" cy="90" r="75" fill="#DCEEFF" opacity="0.45"/>
                <circle cx="98" cy="82" r="38" fill="white" stroke="#3B9DF8" stroke-width="5"/>
                <circle cx="98" cy="82" r="28" fill="#F3F9FF"/>
                <rect x="83" y="72" width="30" height="4" rx="2" fill="#DCEEFF"/>
                <rect x="83" y="80" width="22" height="4" rx="2" fill="#DCEEFF"/>
                <rect x="83" y="88" width="26" height="4" rx="2" fill="#DCEEFF"/>
                <line x1="127" y1="109" x2="148" y2="132" stroke="#3B9DF8" stroke-width="7" stroke-linecap="round"/>
                <circle cx="58" cy="44" r="5" fill="#62B5FF" opacity="0.6"/>
                <circle cx="155" cy="52" r="4" fill="#3B9DF8" opacity="0.45"/>
                <circle cx="144" cy="130" r="3" fill="#62B5FF" opacity="0.5"/>
                <circle cx="64" cy="138" r="4" fill="#DCEEFF" opacity="0.8" stroke="#3B9DF8" stroke-width="1.5"/>
            </svg>
        </div>

        <h2 class="empty-title">
            Cari Barang di SeMart
        </h2>

        <p class="empty-desc">
            Ketik nama barang, kategori, atau keyword di kotak pencarian di atas, lalu tekan Enter atau tombol cari.
        </p>

        <div class="quick-search-section">
            <p class="quick-search-label">Coba cari:</p>

            <div class="quick-tags">
                <button class="quick-tag" data-q="buku">buku</button>
                <button class="quick-tag" data-q="headset">headset</button>
                <button class="quick-tag" data-q="sepatu">sepatu</button>
            </div>
        </div>

    </div>
</div>

@else

{{-- STATE RESULTS --}}
<div id="stateResults" class="search-state">

    <div class="results-header">
        <div class="results-info">

            <h2 class="results-title">
                Hasil Pencarian untuk 
                @if(request()->filled('q'))
                    "<span class="keyword-accent">{{ request('q') }}</span>"
                @else
                    "Kategori: <span class="keyword-accent">{{ request('category') === 'semua' ? 'Semua Produk' : ucfirst(request('category')) }}</span>"
                @endif
            </h2>

            <p class="results-count">
                Menampilkan
                <span id="resultCount">{{ $products->count() }}</span>
                produk
            </p>

        </div>
    </div>

    <div class="filter-bar">
        @include('components.filter-bar')
    </div>

    {{-- PRODUCT GRID --}}
    <div class="product-grid" id="productGrid">
        @forelse ($products as $product)
            @include('components.product-card', ['product' => $product])
        @empty
            <div id="stateNoResults" class="no-results-card">
                <div class="no-results-inner">

                    <svg viewBox="0 0 120 110" fill="none" xmlns="http://www.w3.org/2000/svg" class="no-results-svg">
                        <circle cx="60" cy="50" r="40" fill="#DCEEFF" opacity="0.5"/>
                        <rect x="32" y="42" width="56" height="44" rx="8" fill="#F3F9FF" stroke="#DCEEFF" stroke-width="2"/>
                    </svg>

                    <h3 class="no-results-title">
                        Barang tidak ditemukan
                    </h3>

                    <p class="no-results-desc">
                        Coba ubah kata kunci atau filter pencarianmu.
                    </p>

                </div>
            </div>
        @endforelse
    </div>

</div>

@endif

@endsection