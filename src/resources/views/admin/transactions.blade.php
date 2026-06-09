@extends('layouts-admin.app')

@section('title', 'Daftar Transaksi - SeMart')

@push('styles')
    @vite('resources/css/pages/transactions.css')
@endpush

@push('scripts')
    @vite('resources/js/admin/transactions.js')
@endpush

@section('content')

@php
$transactions = [
    [
        'id' => 1,
        'buyer_name' => 'Andi Pratama',
        'buyer_handle' => '@andi.pratama',
        'product_image' => 'https://images.unsplash.com/photo-1551537482-f2075a1d41f2?w=80&q=80',
        'payment_receipt' => 'https://images.unsplash.com/photo-1554415707-6e8cfc93fe23?w=400&q=80', // Bukti transfer portrait/vertikal
        'product_name' => 'Jaket Denim Pria',
        'seller_name' => 'Budi Santoso',
        'seller_handle' => '@budi.santoso',
        'price' => 'Rp120.000',
        'method_text' => 'Transfer Bank',
        'status' => 'Selesai',
        'status_class' => 'status-selesai',
        'date' => '4 Juni 2026',
        'time' => '14:30 WIB',
        'date_raw' => '2026-06-04'
    ],
    [
        'id' => 2,
        'buyer_name' => 'Siti Aisyah',
        'buyer_handle' => '@siti.aisyah',
        'product_image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=80&q=80',
        'payment_receipt' => 'https://images.unsplash.com/photo-1628157582853-a796fa650a6a?w=400&q=80',
        'product_name' => 'Tas Ransel Eiger Original',
        'seller_name' => 'Dewi Lestari',
        'seller_handle' => '@dewi.lestari',
        'price' => 'Rp175.000',
        'method_text' => 'Transfer Bank',
        'status' => 'Gagal',
        'status_class' => 'status-gagal',
        'date' => '2 Juni 2026',
        'time' => '10:15 WIB',
        'date_raw' => '2026-06-02'
    ],
    [
        'id' => 3,
        'buyer_name' => 'Fajar Ramadhan',
        'buyer_handle' => '@fajar.ramadhan',
        'product_image' => 'https://images.unsplash.com/photo-1564466809058-bf4114d55352?w=80&q=80',
        'payment_receipt' => 'https://images.unsplash.com/photo-1554415707-6e8cfc93fe23?w=400&q=80',
        'product_name' => 'Kalkulator Casio fx-991EX',
        'seller_name' => 'Andi Pratama',
        'seller_handle' => '@andi.pratama',
        'price' => 'Rp85.000',
        'method_text' => 'E-Wallet',
        'status' => 'Selesai',
        'status_class' => 'status-selesai',
        'date' => '29 Mei 2026',
        'time' => '16:45 WIB',
        'date_raw' => '2026-05-29'
    ],
    [
        'id' => 4,
        'buyer_name' => 'Nabila Putri',
        'buyer_handle' => '@nabila.putri',
        'product_image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=80&q=80',
        'payment_receipt' => null, // Sengaja null untuk simulasi "Belum Diunggah"
        'product_name' => 'Buku Atomic Habits',
        'seller_name' => 'Siti Aisyah',
        'seller_handle' => '@siti.aisyah',
        'price' => 'Rp90.000',
        'method_text' => 'Transfer Bank',
        'status' => 'Menunggu',
        'status_class' => 'status-menunggu',
        'date' => '15 Mei 2026',
        'time' => '09:20 WIB',
        'date_raw' => '2026-05-15'
    ],
    [
        'id' => 5,
        'buyer_name' => 'Rizky Maulana',
        'buyer_handle' => '@rizky.maulana',
        'product_image' => 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=80&q=80',
        'payment_receipt' => null, // Gagal sebelum upload bukti transfer
        'product_name' => 'Sepatu Converse All Star',
        'seller_name' => 'Budi Santoso',
        'seller_handle' => '@budi.santoso',
        'price' => 'Rp250.000',
        'method_text' => 'Transfer Bank',
        'status' => 'Gagal',
        'status_class' => 'status-gagal',
        'date' => '10 Mei 2026',
        'time' => '21:10 WIB',
        'date_raw' => '2026-05-10'
    ],
    [
        'id' => 6,
        'buyer_name' => 'Clara Renata',
        'buyer_handle' => '@clara.renata',
        'product_image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=80&q=80',
        'payment_receipt' => 'https://images.unsplash.com/photo-1628157582853-a796fa650a6a?w=400&q=80',
        'product_name' => 'Smartwatch Xiaomi Band 8',
        'seller_name' => 'Dewi Lestari',
        'seller_handle' => '@dewi.lestari',
        'price' => 'Rp399.000',
        'method_text' => 'E-Wallet',
        'status' => 'Selesai',
        'status_class' => 'status-selesai',
        'date' => '10 April 2026',
        'time' => '11:00 WIB',
        'date_raw' => '2026-04-10'
    ]
];

$defaultTrx = $transactions[0];
@endphp

{{-- =============================================
     PAGE HEADER
     ============================================= --}}
<section class="page-header-section">
    <div class="page-header-left">
        <h1 class="page-title">Daftar Transaksi</h1>
        <p class="page-subtitle">Kelola semua transaksi yang terjadi di SeMart</p>
    </div>
</section>

{{-- =============================================
     TOOLBAR: SEARCH & FILTER
     ============================================= --}}
<div class="toolbar-section">
    <div class="search-box">
        <i class="bi bi-search search-icon"></i>
        <input type="text" id="searchInput" class="search-input" placeholder="Cari nama barang, buyer, atau seller...">
    </div>
    
    <div class="filter-box">
        <div class="filter-dropdown">
            <i class="bi bi-funnel filter-icon"></i>
            <select id="filterStatus" class="filter-select">
                <option value="">Status: Semua Status</option>
                <option value="selesai">Selesai</option>
                <option value="menunggu">Menunggu</option>
                <option value="gagal">Gagal</option>
            </select>
        </div>
        <div class="filter-dropdown">
            <i class="bi bi-calendar filter-icon"></i>
            <select id="filterDate" class="filter-select">
                <option value="">Tanggal: Semua Tanggal</option>
                <option value="today">Hari Ini</option>
                <option value="7days">7 Hari Terakhir</option>
                <option value="30days">30 Hari Terakhir</option>
            </select>
        </div>
    </div>
</div>

{{-- =============================================
     TWO-PANEL SPLIT LAYOUT
     ============================================= --}}
<div class="transaction-layout">

    {{-- =========================================
         LEFT PANEL: Tabel Informasi Transaksi
         ========================================= --}}
    <div class="panel-left">
        <div class="table-wrapper">
            <table class="transactions-table">
                <thead>
                    <tr>
                        <th class="col-produk">Nama Barang</th>
                        <th class="col-buyer">Buyer</th>
                        <th class="col-harga">Harga Final</th>
                        <th class="col-tanggal">Tanggal</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody id="transactionsTableBody">
                    @foreach($transactions as $index => $trx)
                    <tr class="transaction-row {{ $index === 0 ? 'active-row' : '' }}" 
                        data-id="{{ $trx['id'] }}" 
                        data-transaction="{{ json_encode($trx) }}">
                        
                        <td class="col-produk">
                            <div class="product-cell">
                                <div class="product-thumb">
                                    <img src="{{ $trx['product_image'] }}" alt="Produk">
                                </div>
                                <div class="product-info">
                                    <span class="product-trx-id">TRX-2026-{{ str_pad($trx['id'], 3, '0', STR_PAD_LEFT) }}</span>
                                    <span class="product-name">{{ $trx['product_name'] }}</span>
                                    <span class="status-badge {{ $trx['status_class'] }}">{{ $trx['status'] }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="col-buyer">
                            <div class="person-cell">
                                <div class="person-info">
                                    <span class="person-name">{{ $trx['buyer_name'] }}</span>
                                    <span class="person-handle">{{ $trx['buyer_handle'] }}</span>
                                </div>
                            </div>
                        </td>
                        
                        <td class="col-harga">
                            <span class="price-text">{{ $trx['price'] }}</span>
                        </td>
                        
                        <td class="col-tanggal">
                            <div class="date-cell">
                                <span class="date-text">{{ $trx['date'] }}</span>
                                <span class="time-text">{{ $trx['time'] }}</span>
                            </div>
                        </td>
                        
                        <td class="col-aksi">
                            <button class="btn-detail {{ $index === 0 ? 'active' : '' }}" data-id="{{ $trx['id'] }}">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span class="table-info" id="tableInfoText">Menampilkan 1–{{ count($transactions) }} dari {{ count($transactions) }} transaksi</span>
            <div class="pagination-wrap">
                <button class="page-btn" disabled aria-label="Previous">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn" aria-label="Next">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- =========================================
         RIGHT PANEL: Komponen Detail Transaksi
         ========================================= --}}
    <div class="panel-right" id="panelRight">
        <div class="detail-card" id="detailCard">
            <h3 class="detail-section-title">Detail Transaksi</h3>

            {{-- Bagian Galeri/Struk Diperbarui --}}
            <div class="detail-gallery">
                <span style="display: block; font-size: 11.5px; color: var(--gray-text); margin-bottom: 8px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.3px;">
                    <i class="bi bi-receipt"></i> Bukti Pembayaran:
                </span>
                
                <div class="detail-main-img-wrap" style="background: #f8f9fa; border: 1.5px dashed var(--border-gray); border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center; min-height: 240px; position: relative; padding: 8px;">
                    
                    {{-- Gambar Bukti Pembayaran --}}
                    <img src="{{ $defaultTrx['payment_receipt'] ?? '' }}" 
                         alt="Bukti Pembayaran" 
                         class="detail-main-img" 
                         id="detailMainImg" 
                         style="width: 100%; height: auto; max-height: 280px; object-fit: contain; {{ empty($defaultTrx['payment_receipt']) ? 'display: none;' : '' }}">

                    {{-- Placeholder Fallback bila Bukti Kosong --}}
                    <div id="receiptPlaceholder" style="text-align: center; color: var(--gray-text); padding: 20px; {{ !empty($defaultTrx['payment_receipt']) ? 'display: none;' : '' }}">
                        <i class="bi bi-file-earmark-x" style="font-size: 36px; color: var(--danger-text, #dc3545);"></i>
                        <p style="font-size: 12px; margin-top: 10px; font-weight: 600; margin-bottom: 0; line-height: 1.4;">Belum ada bukti pembayaran yang diunggah</p>
                    </div>
                </div>
            </div>

            <div class="detail-info" style="margin-top: 16px;">
                <h2 class="detail-product-name" id="detailProductName">{{ $defaultTrx['product_name'] }}</h2>
                <p class="detail-product-price" id="detailProductPrice">{{ $defaultTrx['price'] }}</p>

                <div class="detail-meta-list" style="margin-bottom: 0; padding-bottom: 0; border-bottom: none;">
                    <div class="detail-meta-row">
                        <i class="bi bi-hash detail-meta-icon"></i>
                        <span class="detail-meta-label">ID Transaksi</span>
                        <span class="detail-meta-value detail-trx-id-inline" id="detailTrxId">TRX-2026-{{ str_pad($defaultTrx['id'], 3, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <div class="detail-meta-row">
                        <i class="bi bi-person-fill detail-meta-icon"></i>
                        <span class="detail-meta-label">Buyer</span>
                        <div class="detail-meta-value">
                            <span class="dv-name" id="detailBuyerName">{{ $defaultTrx['buyer_name'] }}</span>
                            <span class="dv-handle" id="detailBuyerHandle">{{ $defaultTrx['buyer_handle'] }}</span>
                        </div>
                    </div>

                    <div class="detail-meta-row">
                        <i class="bi bi-shop detail-meta-icon"></i>
                        <span class="detail-meta-label">Seller</span>
                        <div class="detail-meta-value">
                            <span class="dv-name" id="detailSellerName">{{ $defaultTrx['seller_name'] }}</span>
                            <span class="dv-handle" id="detailSellerHandle">{{ $defaultTrx['seller_handle'] }}</span>
                        </div>
                    </div>

                    <div class="detail-meta-row">
                        <i class="bi bi-credit-card detail-meta-icon"></i>
                        <span class="detail-meta-label">Metode</span>
                        <span class="detail-meta-value" id="detailMethod">{{ $defaultTrx['method_text'] }}</span>
                    </div>

                    <div class="detail-meta-row">
                        <i class="bi bi-clock detail-meta-icon"></i>
                        <span class="detail-meta-label">Waktu</span>
                        <span class="detail-meta-value" id="detailDateTime">{{ $defaultTrx['date'] }}, {{ $defaultTrx['time'] }}</span>
                    </div>

                    <div class="detail-meta-row">
                        <i class="bi bi-info-circle detail-meta-icon"></i>
                        <span class="detail-meta-label">Status</span>
                        <div class="detail-meta-value">
                            <span class="status-badge {{ $defaultTrx['status_class'] }}" id="detailStatus">{{ $defaultTrx['status'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection