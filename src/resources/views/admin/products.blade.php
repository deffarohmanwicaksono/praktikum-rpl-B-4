@extends('layouts-admin.app')

@section('title', 'Daftar Produk - SeMart')

@push('styles')
    @vite('resources/css/pages/products.css')
@endpush

@push('scripts')
    @vite('resources/js/admin/products.js')
@endpush

@section('content')

@php
// Mockup data lengkap disesuaikan dengan kriteria pencarian, filter kategori, dan status
$products = [
    [
        'id' => 1,
        'image' => 'https://images.unsplash.com/photo-1551537482-f2075a1d41f2?w=80&q=80',
        'detail_image' => 'https://images.unsplash.com/photo-1551537482-f2075a1d41f2?w=600&q=80',
        'name' => 'Jaket Denim Pria',
        'badge' => 'Pakaian',
        'category_class' => '',
        'seller_name' => 'Andi Pratama',
        'seller_handle' => '@andi.pratama',
        'price' => 'Rp120.000',
        'category' => 'Pakaian',
        'status' => 'Dijual',
        'status_class' => 'status-dijual',
        'condition' => 'Bekas Seperti Baru',
        'description' => 'Jaket denim warna biru dongker. Kondisi masih sangat baik, bahan tebal dan nyaman dipakai tanpa ada cacat robek.',
        'date' => '12 Mei 2024'
    ],
    [
        'id' => 2,
        'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=80&q=80',
        'detail_image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&q=80',
        'name' => 'Tas Ransel Eiger Original',
        'badge' => 'Sepatu & Tas',
        'category_class' => '',
        'seller_name' => 'Siti Aisyah',
        'seller_handle' => '@siti.aisyah',
        'price' => 'Rp175.000',
        'category' => 'Sepatu & Tas',
        'status' => 'Sold Out',
        'status_class' => 'status-sold-out',
        'condition' => 'Bekas Baik',
        'description' => 'Tas ransel merk Eiger original kapasitas 25L. Cocok untuk kuliah atau hiking ringan. Slot laptop aman dan busa tebal.',
        'date' => '12 Mei 2024'
    ],
    [
        'id' => 3,
        'image' => 'https://images.unsplash.com/photo-1564466809058-bf4114d55352?w=80&q=80',
        'detail_image' => 'https://images.unsplash.com/photo-1564466809058-bf4114d55352?w=600&q=80',
        'name' => 'Kalkulator Casio fx-991EX',
        'badge' => 'Elektronik',
        'category_class' => 'cat-elektronik',
        'seller_name' => 'Budi Santoso',
        'seller_handle' => '@budi.santoso',
        'price' => 'Rp85.000',
        'category' => 'Elektronik',
        'status' => 'Ditolak',
        'status_class' => 'status-ditolak',
        'condition' => 'Bekas Seperti Baru',
        'description' => 'Kalkulator scientific Casio fx-991EX Classwiz LCD beresolusi tinggi. Sangat berguna untuk kebutuhan pengerjaan kalkulus tingkat lanjut.',
        'date' => '11 Mei 2024'
    ],
    [
        'id' => 4,
        'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=80&q=80',
        'detail_image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=600&q=80',
        'name' => 'Buku Atomic Habits',
        'badge' => 'Buku',
        'category_class' => 'cat-buku',
        'seller_name' => 'Dewi Lestari',
        'seller_handle' => '@dewi.lestari',
        'price' => 'Rp90.000',
        'category' => 'Buku',
        'status' => 'Menunggu',
        'status_class' => 'status-menunggu',
        'condition' => 'Bekas Baik',
        'description' => 'Buku Atomic Habits terjemahan Indonesia penerbit Gramedia. Halaman lengkap tidak ada yang robek, bersih bebas coretan stabilo.',
        'date' => '10 Mei 2024'
    ],
    [
        'id' => 5,
        'image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=80&q=80',
        'detail_image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=600&q=80',
        'name' => 'Sepatu Converse All Star',
        'badge' => 'Sepatu & Tas',
        'category_class' => '',
        'seller_name' => 'Rizky Maulana',
        'seller_handle' => '@rizky.maulana',
        'price' => 'Rp250.000',
        'category' => 'Sepatu & Tas',
        'status' => 'Dijual',
        'status_class' => 'status-dijual',
        'condition' => 'Bekas Baik',
        'description' => 'Sepatu Converse All Star warna hitam original, ukuran 42. Minus pemakaian wajar, sol sepatu bagian bawah masih sangat tebal.',
        'date' => '09 Mei 2024'
    ]
];

$defaultProduct = $products[0];
@endphp

{{-- =============================================
     PAGE HEADER
     ============================================= --}}
<section class="page-header-section">
    <div class="page-header-left">
        <h1 class="page-title">Daftar Produk</h1>
        <p class="page-subtitle">Kelola semua produk yang terdaftar di SeMart</p>
    </div>
</section>

{{-- =============================================
     TOOLBAR: SEARCH & FILTER
     ============================================= --}}
<div class="toolbar-section">
    <div class="search-box">
        <i class="bi bi-search search-icon"></i>
        <input type="text" id="searchInput" class="search-input" placeholder="Cari nama barang atau seller...">
    </div>
    
    <div class="filter-box">
        <div class="filter-dropdown">
            <i class="bi bi-funnel filter-icon"></i>
            <select id="filterStatus" class="filter-select">
                <option value="">Status: Semua Status</option>
                <option value="dijual">Dijual</option>
                <option value="menunggu">Menunggu</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>
        <div class="filter-dropdown">
            <i class="bi bi-funnel filter-icon"></i>
            <select id="filterCategory" class="filter-select">
                <option value="">Kategori: Semua Kategori</option>
                <option value="pakaian">Pakaian</option>
                <option value="sepatu & tas">Sepatu & Tas</option>
                <option value="elektronik">Elektronik</option>
                <option value="buku">Buku</option>
            </select>
        </div>
    </div>
</div>

{{-- =============================================
     TWO-PANEL SPLIT LAYOUT
     ============================================= --}}
<div class="product-layout">

    {{-- =========================================
         LEFT PANEL: Tabel Informasi Produk
         ========================================= --}}
    <div class="panel-left">
        <div class="table-wrapper">
            <table class="product-table">
                <thead>
                    <tr>
                        <th class="col-nama">Nama Barang</th>
                        <th class="col-seller">Seller</th>
                        <th class="col-harga">Harga</th>
                        <th class="col-status">Status</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody id="productsTableBody">
                    @foreach($products as $index => $product)
                    {{-- Menyimpan keseluruhan properti array ke format JSON di dalam atribut data-product --}}
                    <tr class="product-row {{ $index === 0 ? 'active-row' : '' }}" 
                        data-id="{{ $product['id'] }}" 
                        data-product="{{ json_encode($product) }}">
                        
                        <td class="col-nama">
                            <div class="product-cell">
                                <div class="product-thumb">
                                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                                </div>
                                <div class="product-cell-info">
                                    <span class="product-cell-name">{{ $product['name'] }}</span>
                                    <span class="product-cat-badge {{ $product['category_class'] }}">{{ $product['badge'] }}</span>
                                </div>
                            </div>
                        </td>
                        
                        <td class="col-seller">
                            <span class="seller-name">{{ $product['seller_name'] }}</span>
                            <span class="seller-handle">{{ $product['seller_handle'] }}</span>
                        </td>
                        
                        <td class="col-harga">
                            <span class="price-text">{{ $product['price'] }}</span>
                        </td>
                        
                        <td class="col-status">
                            <span class="status-badge {{ $product['status_class'] }}">{{ $product['status'] }}</span>
                        </td>
                        
                        <td class="col-aksi">
                            <button class="btn-detail {{ $index === 0 ? 'active' : '' }}" data-id="{{ $product['id'] }}">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Navigasi Paginasi Halaman Tabel --}}
        <div class="table-footer">
            <span class="table-info" id="tableInfoText">Menampilkan 1–{{ count($products) }} dari {{ count($products) }} produk</span>
            <div class="pagination-wrap">
                <button class="page-btn" disabled aria-label="Previous">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn" aria-label="Next">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- =========================================
         RIGHT PANEL: Komponen Detail Produk
         ========================================= --}}
    <div class="panel-right" id="panelRight">
        <div class="detail-card" id="detailCard">
            <h3 class="detail-section-title">Detail Produk</h3>

            {{-- Galeri Gambar --}}
            <div class="detail-gallery">
                <div class="detail-main-img-wrap">
                    <img src="{{ $defaultProduct['detail_image'] }}" alt="{{ $defaultProduct['name'] }}" class="detail-main-img" id="detailMainImg">
                    <span class="detail-img-counter" id="imgCounter">1 / 4</span>
                </div>

                {{-- Baris Thumbnail Gambar --}}
                <div class="detail-thumbnails" id="detailThumbnails">
                    <button class="thumb-btn active" data-src="{{ $defaultProduct['detail_image'] }}">
                        <img src="{{ $defaultProduct['image'] }}" alt="Thumbnail Utama">
                    </button>
                    <button class="thumb-btn" data-src="https://images.unsplash.com/photo-1544022613-e87ca75a784a?w=600&q=80">
                        <img src="https://images.unsplash.com/photo-1544022613-e87ca75a784a?w=120&q=80" alt="Thumbnail 2">
                    </button>
                    <button class="thumb-btn" data-src="https://images.unsplash.com/photo-1495105787522-5334e3ffa0ef?w=600&q=80">
                        <img src="https://images.unsplash.com/photo-1495105787522-5334e3ffa0ef?w=120&q=80" alt="Thumbnail 3">
                    </button>
                    <button class="thumb-btn" data-src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=600&q=80">
                        <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=120&q=80" alt="Thumbnail 4">
                    </button>
                </div>
            </div>

            {{-- Informasi Tekstual --}}
            <div class="detail-info">
                <h2 class="detail-product-name" id="detailName">{{ $defaultProduct['name'] }}</h2>
                <p class="detail-product-price" id="detailPrice">{{ $defaultProduct['price'] }}</p>

                {{-- Daftar Baris Metadata Item --}}
                <div class="detail-meta-list">
                    <div class="detail-meta-row">
                        <i class="bi bi-person detail-meta-icon"></i>
                        <span class="detail-meta-label">Seller</span>
                        <div class="detail-meta-value">
                            <span class="dv-name" id="detailSellerName">{{ $defaultProduct['seller_name'] }}</span>
                            <span class="dv-handle" id="detailSellerHandle">{{ $defaultProduct['seller_handle'] }}</span>
                        </div>
                    </div>
                    <div class="detail-meta-row">
                        <i class="bi bi-tag detail-meta-icon"></i>
                        <span class="detail-meta-label">Kategori</span>
                        <span class="detail-meta-value" id="detailKategori">{{ $defaultProduct['category'] }}</span>
                    </div>
                    <div class="detail-meta-row">
                        <i class="bi bi-stars detail-meta-icon"></i>
                        <span class="detail-meta-label">Kondisi</span>
                        <span class="detail-meta-value" id="detailKondisi">{{ $defaultProduct['condition'] }}</span>
                    </div>
                    <div class="detail-meta-row">
                        <i class="bi bi-calendar detail-meta-icon"></i>
                        <span class="detail-meta-label">Tanggal</span>
                        <span class="detail-meta-value" id="detailTanggal">{{ $defaultProduct['date'] }}</span>
                    </div>
                </div>

                {{-- Blok Deskripsi --}}
                <div class="detail-desc-block">
                    <p class="detail-desc-label">Deskripsi</p>
                    <p class="detail-desc-text" id="detailDeskripsi">
                        {{ $defaultProduct['description'] }}
                    </p>
                </div>

                {{-- Tombol Aksi Hapus Utama Berada Di Panel Detail --}}
                <button class="btn-hapus-detail" id="btnHapus">
                    <i class="bi bi-trash"></i> Hapus Produk
                </button>
            </div>
        </div>
    </div>
</div>

{{-- =============================================
     MODAL OVERLAY: KONFIRMASI HAPUS PRODUK
     ============================================= --}}
<div class="modal-overlay" id="modalHapus">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Konfirmasi Hapus</h3>
            <button class="modal-close-btn" data-modal="modalHapus">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-simple">
            <div class="modal-icon-danger">
                <i class="bi bi-trash3-fill"></i>
            </div>
            <p class="modal-confirm-text">
                Apakah Anda yakin ingin menghapus produk <br><strong id="modalHapusName">{{ $defaultProduct['name'] }}</strong>? <br>Data yang dihapus tidak dapat dikembalikan.
            </p>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" data-modal="modalHapus">Batal</button>
            <button class="btn-modal-hapus" id="confirmHapusBtn">
                <i class="bi bi-trash"></i> Ya, Hapus
            </button>
        </div>
    </div>
</div>

@endsection