@extends('layouts.app')

@section('title', 'Dashboard Seller - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite('resources/css/pages/dashboard-seller.css')
@endpush

{{-- PAGE JS --}}
@push('scripts')
    @vite('resources/js/seller/dashboard-seller.js')
@endpush

@section('content')

@php
// Data dummy produk seller
$sellerProducts = [
    [
        'id' => 1,
        'name' => 'Laptop Asus VivoBook X515',
        'price' => 'Rp 6.000.000',
        'status' => 'Menunggu',
        'status_class' => 'status-menunggu',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 2,
        'name' => 'Kamera Canon EOS M50',
        'price' => 'Rp 4.500.000',
        'status' => 'Menunggu',
        'status_class' => 'status-menunggu',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 3,
        'name' => 'Headphone Sony WH-1000XM4',
        'price' => 'Rp 3.200.000',
        'status' => 'Dijual',
        'status_class' => 'status-dijual',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 4,
        'name' => 'Smartwatch Xiaomi Mi Band 7',
        'price' => 'Rp 500.000',
        'status' => 'Dijual',
        'status_class' => 'status-dijual',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 5,
        'name' => 'Keyboard Mechanical RGB',
        'price' => 'Rp 850.000',
        'status' => 'Dijual',
        'status_class' => 'status-dijual',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 6,
        'name' => 'Mouse Logitech G102',
        'price' => 'Rp 250.000',
        'status' => 'Dijual',
        'status_class' => 'status-dijual',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 7,
        'name' => 'Monitor LG 24MP400',
        'price' => 'Rp 1.650.000',
        'status' => 'Sold Out',
        'status_class' => 'status-sold-out',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 8,
        'name' => 'Lampu Meja LED',
        'price' => 'Rp 120.000',
        'status' => 'Sold Out',
        'status_class' => 'status-sold-out',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 9,
        'name' => 'Buku Atomic Habits',
        'price' => 'Rp 150.000',
        'status' => 'Ditolak',
        'status_class' => 'status-ditolak',
        'image' => asset('images/Elemen-1.png'),
    ],
];
@endphp

{{-- =============================================
     PAGE HEADER
     ============================================= --}}
<section class="page-header-section">
    <div class="page-header-left">
        <h1 class="page-title">Dashboard Seller</h1>
        <p class="page-subtitle">Kelola produk yang akan Anda jual di SeMart</p>
    </div>
</section>

{{-- =============================================
     TOOLBAR ACTIONS (SEARCH, FILTER & ADD BUTTON)
     ============================================= --}}
<div class="toolbar-section">
    <div class="toolbar-left-group">
        <div class="search-box">
            <i class="bi bi-search search-icon"></i>
            <input type="text" class="search-input" id="searchProductInput" placeholder="Cari barang Anda...">
        </div>
        
        <div class="filter-box">
            <div class="filter-dropdown">
                <i class="bi bi-funnel filter-icon"></i>
                <select class="filter-select" id="filterStatusSelect">
                    <option value="">Status: Semua</option>
                    <option value="status-menunggu">Menunggu</option>
                    <option value="status-dijual">Dijual</option>
                    <option value="status-sold-out">Sold Out</option>
                    <option value="status-ditolak">Ditolak</option>
                </select>
            </div>
        </div>
    </div>

    <div class="toolbar-right-group">
        <a href="{{ route('seller.product.upload') }}" class="btn-tambah-barang-new">
            <i class="bi bi-plus-lg"></i> Tambah Barang
        </a>
    </div>
</div>

{{-- =============================================
     MAIN PANEL: DAFTAR BARANG TABLE
     ============================================= --}}
<div class="table-wrapper full-width">
    <table class="barang-table-new">
        <thead>
            <tr>
                <th class="col-nama">Nama Barang</th>
                <th class="col-harga">Harga</th>
                <th class="col-status">Status</th>
                <th class="col-aksi">Aksi</th>
            </tr>
        </thead>
        <tbody id="sellerProductsBody">
            @forelse ($sellerProducts as $product)
                <tr class="product-row" data-id="{{ $product['id'] }}" data-status-class="{{ $product['status_class'] }}">
                    <td class="col-nama">
                        <div class="product-profile-cell">
                            <div class="product-avatar-wrap">
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" class="product-avatar">
                            </div>
                            <span class="product-name-text">{{ $product['name'] }}</span>
                        </div>
                    </td>
                    
                    <td class="col-harga">
                        <span class="price-text-new">{{ $product['price'] }}</span>
                    </td>
                    
                    <td class="col-status">
                        <span class="status-badge {{ $product['status_class'] }}">
                            {{ $product['status'] }}
                        </span>
                    </td>
                    
                    <td class="col-aksi">
                        <div class="action-buttons">
                            <a href="{{ route('seller.product.edit', $product['id']) }}" class="btn-action btn-detail-edit" title="Edit Produk">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            
                            @if($product['status_class'] === 'status-dijual')
                                <button class="btn-action btn-status-toggle btn-tutup-lapak" data-id="{{ $product['id'] }}" data-name="{{ $product['name'] }}" data-action="tutup" title="Tutup Lapak">
                                    <i class="bi bi-lock"></i> Tutup
                                </button>
                            @endif

                            <button class="btn-action btn-status-toggle btn-hapus-produk" data-id="{{ $product['id'] }}" data-name="{{ $product['name'] }}" data-action="hapus" title="Hapus Produk">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                {{-- TAMPILAN JIKA DAFTAR BARANG KOSONG --}}
                <tr id="emptyStateRow">
                    <td colspan="4" class="empty-state-cell">
                        <div class="no-results-inner-new">
                            <div class="empty-icon-wrap">
                                <i class="bi bi-archive"></i>
                            </div>
                            <h3 class="no-results-title-new">Belum ada produk nih</h3>
                            <p class="no-results-desc-new">Yuk, mulai tambah barang layak konsumsi atau pakai pertamamu di SeMart!</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- =============================================
         STATUS LEGEND (Terintegrasi di dalam Wrapper)
         ============================================= --}}
    <div class="table-footer-legend">
        <div class="legend-header">Keterangan Status:</div>
        <div class="legend-grid">
            <div class="legend-item">
                <span class="legend-dot menunggu-dot"></span>
                <span class="legend-label menunggu-label">Menunggu</span>
                <span class="legend-desc">: Menunggu review & persetujuan verifikasi oleh Admin</span>
            </div>
            <div class="legend-item">
                <span class="legend-dot dijual-dot"></span>
                <span class="legend-label dijual-label">Dijual</span>
                <span class="legend-desc">: Telah disetujui, aktif di marketplace, siap diorder Buyer</span>
            </div>
            <div class="legend-item">
                <span class="legend-dot sold-out-dot"></span>
                <span class="legend-label sold-out-label">Sold Out</span>
                <span class="legend-desc">: Produk telah laku terjual dan transaksi selesai</span>
            </div>
            <div class="legend-item">
                <span class="legend-dot ditolak-dot"></span>
                <span class="legend-label ditolak-label">Ditolak</span>
                <span class="legend-desc">: Pengajuan tidak memenuhi syarat kelayakan aplikasi</span>
            </div>
        </div>
    </div>
</div>

{{-- =============================================
     MODAL: KONFIRMASI AKSI (HAPUS / TUTUP LAPAK)
     ============================================= --}}
<div class="modal-overlay" id="modalActionSeller">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom" id="modalSellerTitle">Konfirmasi Tindakan</h3>
            <button class="modal-close-btn" data-modal="modalActionSeller">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-simple">
            <div id="modalSellerIcon" class="modal-icon-wrap">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <p class="modal-confirm-text">
                Apakah Anda yakin ingin <span id="modalSellerActionText"></span> barang <br><strong id="modalSellerProductName"></strong>?
            </p>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" data-modal="modalActionSeller">Batal</button>
            <button class="btn-modal-submit" id="confirmSellerBtn">Ya, Proses</button>
        </div>
    </div>
</div>

@endsection