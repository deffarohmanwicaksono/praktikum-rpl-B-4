@extends('layouts-admin.app')

@section('title', 'Verifikasi Barang - SeMart')

@push('styles')
    @vite('resources/css/pages/verification.css')
@endpush

@push('scripts')
    @vite('resources/js/admin/verification.js')
@endpush

@section('content')

@php
$products = [
    [
        'id' => 1,
        'name' => 'Jaket Denim Pria',
        'category' => 'Pakaian',
        'category_class' => '',
        'image' => 'https://images.unsplash.com/photo-1551537482-f2075a1d41f2?w=80&q=80',
        'detail_image' => 'https://images.unsplash.com/photo-1551537482-f2075a1d41f2?w=600&q=80',
        'seller_name' => 'Andi Pratama',
        'seller_handle' => '@andi.pratama',
        'price' => 'Rp120.000',
        'date' => '12 Mei 2024',
        'time' => '14:30 WIB',
        'condition' => 'Bekas Seperti Baru',
        'description' => 'Jaket denim warna biru dongker. Kondisi masih sangat baik, bahan tebal dan nyaman dipakai.'
    ],
    [
        'id' => 2,
        'name' => 'Tas Ransel Eiger Original',
        'category' => 'Sepatu & Tas',
        'category_class' => '',
        'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=80&q=80',
        'detail_image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&q=80',
        'seller_name' => 'Siti Aisyah',
        'seller_handle' => '@siti.aisyah',
        'price' => 'Rp175.000',
        'date' => '12 Mei 2024',
        'time' => '10:15 WIB',
        'condition' => 'Bekas Seperti Baru',
        'description' => 'Tas ransel merk Eiger original. Cocok untuk kuliah atau hiking ringan. Slot laptop aman.'
    ],
    [
        'id' => 3,
        'name' => 'Kalkulator Casio fx-991EX',
        'category' => 'Elektronik',
        'category_class' => 'cat-elektronik',
        'image' => 'https://images.unsplash.com/photo-1564466809058-bf4114d55352?w=80&q=80',
        'detail_image' => 'https://images.unsplash.com/photo-1564466809058-bf4114d55352?w=600&q=80',
        'seller_name' => 'Budi Santoso',
        'seller_handle' => '@budi.santoso',
        'price' => 'Rp85.000',
        'date' => '11 Mei 2024',
        'time' => '16:45 WIB',
        'condition' => 'Bekas Seperti Baru',
        'description' => 'Kalkulator scientific Casio fx-991EX Classwiz. Sangat berguna untuk kalkulus tingkat lanjut.'
    ],
    [
        'id' => 4,
        'name' => 'Buku Atomic Habits',
        'category' => 'Buku',
        'category_class' => 'cat-buku',
        'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=80&q=80',
        'detail_image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=600&q=80',
        'seller_name' => 'Dewi Lestari',
        'seller_handle' => '@dewi.lestari',
        'price' => 'Rp90.000',
        'date' => '10 Mei 2024',
        'time' => '09:20 WIB',
        'condition' => 'Bekas Baik',
        'description' => 'Buku Atomic Habits terjemahan Indonesia. Halaman lengkap tidak ada yang robek, bebas coretan.'
    ]
];

$defaultProduct = $products[0];
@endphp

{{-- =============================================
     PAGE HEADER
     ============================================= --}}
<section class="page-header-section">
    <div class="page-header-left">
        <h1 class="page-title">Verifikasi Barang</h1>
        <p class="page-subtitle">Pengajuan produk dari seller yang menunggu verifikasi</p>
    </div>
</section>

{{-- =============================================
     TWO-PANEL: Table + Detail
     ============================================= --}}
<div class="verif-layout">

    {{-- =========================================
         LEFT PANEL: Tabel Barang
         ========================================= --}}
    <div class="panel-left">

        {{-- Table Wrapper --}}
        <div class="table-wrapper">
            <table class="verif-table">
                <thead>
                    <tr>
                        <th class="col-nama">Nama Barang</th>
                        <th class="col-seller">Seller</th>
                        <th class="col-harga">Harga</th>
                        <th class="col-tanggal">Tanggal Pengajuan</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody id="verifTableBody">

                    @foreach($products as $index => $product)
                    <tr class="verif-row {{ $index === 0 ? 'active-row' : '' }}" data-id="{{ $product['id'] }}">
                        <td class="col-nama">
                            <div class="product-cell">
                                <div class="product-thumb">
                                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                                </div>
                                <div class="product-cell-info">
                                    <span class="product-cell-name">{{ $product['name'] }}</span>
                                    <span class="product-cat-badge {{ $product['category_class'] }}">{{ $product['category'] }}</span>
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
                        <td class="col-tanggal">
                            <span class="date-text">{{ $product['date'] }}</span>
                            <span class="time-text">{{ $product['time'] }}</span>
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

        {{-- Pagination Info + Controls --}}
        <div class="table-footer">
            <span class="table-info">Menampilkan 1–{{ count($products) }} dari {{ count($products) }} pengajuan</span>
            <div class="pagination-wrap">
                <button class="page-btn" disabled aria-label="Previous">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="page-btn active">1</button>
                <button class="page-btn" aria-label="Next">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

        {{-- =========================================
             ALASAN PENOLAKAN
             ========================================= --}}
        <div class="alasan-section" id="alasanSection">
            <div class="alasan-header">
                <h3 class="alasan-title">Alasan Penolakan</h3>
                <p class="alasan-subtitle">Berikan alasan yang jelas (wajib diisi sebelum menolak)</p>
            </div>
            <textarea
                class="alasan-textarea"
                id="alasanInput"
                placeholder="Contoh: Foto kurang jelas, deskripsi tidak sesuai, dll."
                rows="4"
            ></textarea>
        </div>

    </div>

    {{-- =========================================
         RIGHT PANEL: Detail Produk
         ========================================= --}}
    <div class="panel-right" id="panelRight">

        <div class="detail-card" id="detailCard">

            <h3 class="detail-section-title">Detail Produk</h3>

            {{-- Image Gallery --}}
            <div class="detail-gallery">
                <div class="detail-main-img-wrap">
                    <img
                        src="{{ $defaultProduct['detail_image'] }}"
                        alt="{{ $defaultProduct['name'] }}"
                        class="detail-main-img"
                        id="detailMainImg"
                    >
                    <span class="detail-img-counter" id="imgCounter">1 / 4</span>
                </div>

                {{-- Thumbnail Strip --}}
                <div class="detail-thumbnails" id="detailThumbnails">
                    <button class="thumb-btn active" data-src="{{ $defaultProduct['detail_image'] }}">
                        <img src="{{ $defaultProduct['image'] }}" alt="">
                    </button>
                    <button class="thumb-btn" data-src="https://images.unsplash.com/photo-1544022613-e87ca75a784a?w=600&q=80">
                        <img src="https://images.unsplash.com/photo-1544022613-e87ca75a784a?w=120&q=80" alt="">
                    </button>
                    <button class="thumb-btn" data-src="https://images.unsplash.com/photo-1495105787522-5334e3ffa0ef?w=600&q=80">
                        <img src="https://images.unsplash.com/photo-1495105787522-5334e3ffa0ef?w=120&q=80" alt="">
                    </button>
                    <button class="thumb-btn" data-src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=600&q=80">
                        <img src="https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=120&q=80" alt="">
                    </button>
                </div>
            </div>

            {{-- Product Info --}}
            <div class="detail-info">

                <h2 class="detail-product-name" id="detailName">{{ $defaultProduct['name'] }}</h2>
                <p class="detail-product-price" id="detailPrice">{{ $defaultProduct['price'] }}</p>

                {{-- Meta Rows --}}
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
                        <i class="bi bi-clock detail-meta-icon"></i>
                        <span class="detail-meta-label">Diajukan</span>
                        <span class="detail-meta-value" id="detailDiajukan">{{ $defaultProduct['date'] }}, {{ $defaultProduct['time'] }}</span>
                    </div>
                </div>

                {{-- Description --}}
                <div class="detail-desc-block">
                    <p class="detail-desc-label">Deskripsi</p>
                    <p class="detail-desc-text" id="detailDeskripsi">
                        {{ $defaultProduct['description'] }}
                    </p>
                </div>

                {{-- Action Buttons: Setujui / Tolak --}}
                <div class="detail-actions">
                    <button class="btn-setujui" id="btnSetujui">
                        <i class="bi bi-check-circle"></i> Setujui
                    </button>
                    <button class="btn-tolak" id="btnTolak">
                        <i class="bi bi-x-circle"></i> Tolak
                    </button>
                </div>

            </div>

        </div>

    </div>

</div>

{{-- =============================================
     MODAL: KONFIRMASI SETUJUI
     ============================================= --}}
<div class="modal-overlay" id="modalSetujui">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Konfirmasi Persetujuan</h3>
            <button class="modal-close-btn" data-modal="modalSetujui">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-simple">
            <div class="modal-icon-success">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <p class="modal-confirm-text">
                Setujui barang <strong id="modalSetujuiName">{{ $defaultProduct['name'] }}</strong>
                untuk dipublikasikan di platform SeMart?
            </p>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" data-modal="modalSetujui">Batal</button>
            <button class="btn-modal-setujui">
                <i class="bi bi-check-circle"></i> Ya, Setujui
            </button>
        </div>
    </div>
</div>

{{-- =============================================
     MODAL: KONFIRMASI TOLAK
     ============================================= --}}
<div class="modal-overlay" id="modalTolak">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Konfirmasi Penolakan</h3>
            <button class="modal-close-btn" data-modal="modalTolak">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-simple">
            <div class="modal-icon-danger">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <p class="modal-confirm-text">
                Tolak pengajuan barang <strong id="modalTolakName">{{ $defaultProduct['name'] }}</strong>?
                Alasan akan dikirimkan ke seller.
            </p>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" data-modal="modalTolak">Batal</button>
            <button class="btn-modal-tolak">
                <i class="bi bi-x-circle"></i> Ya, Tolak
            </button>
        </div>
    </div>
</div>

@endsection