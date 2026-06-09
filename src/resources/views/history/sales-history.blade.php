@extends('layouts.app')

@section('title', 'Riwayat Penjualan - SeMart')

@push('styles')
    @vite([
    'resources/css/components/history.css',
    'resources/css/pages/sales-history.css'
    ])
@endpush

@push('scripts')
    @vite('resources/js/history/sales-history.js')
@endpush

@section('content')

@php
// Data dummy riwayat penjualan
$salesHistory = [
    [
        'id' => 'TRX-2026-001',
        'product_name' => 'Buku Kalkulus Stewart',
        'buyer' => 'Budi Santoso',
        'income' => 'Rp 250.000',
        'date' => '05 Juni 2026',
        'time' => '10:15 WIB',
        'status' => 'Menunggu Pembayaran',
        'status_class' => 'status-menunggu',
        'image' => asset('images/products/kalkulus_steward.jpg'),
        'payment_proof' => asset('images/products/basis_data.jpg'),
    ],
    [
        'id' => 'TRX-2026-002',
        'product_name' => 'Jaket Almamater UNS',
        'buyer' => 'Citra Lestari',
        'income' => 'Rp 120.000',
        'date' => '03 Juni 2026',
        'time' => '14:20 WIB',
        'status' => 'Selesai',
        'status_class' => 'status-selesai',
        'image' => asset('images/products/almet.jpg'),
        'payment_proof' => asset('images/products/tas_ransel.jpg'),
    ],
    [
        'id' => 'TRX-2026-003',
        'product_name' => 'Buku Basis Data 2',
        'buyer' => 'Deni Ramadhan',
        'income' => 'Rp 110.000',
        'date' => '01 Juni 2026',
        'time' => '09:00 WIB',
        'status' => 'Selesai',
        'status_class' => 'status-selesai',
        'image' => asset('images/products/basis_data2.jpg'),
        'payment_proof' => asset('images/products/struktur_data_java.jpg'),
    ]
];
@endphp

<section class="page-header-section">
    <h1 class="page-title">Riwayat Penjualan</h1>
    <p class="page-subtitle">Pantau seluruh transaksi barang yang telah Anda jual.</p>
</section>

<section class="toolbar-section">
    <div class="toolbar-left-group">
        <div class="search-box">
            <i class="bi bi-search search-icon"></i>
            <input type="text" id="searchSalesInput" class="search-input" placeholder="Cari ID transaksi atau nama barang...">
        </div>
            <div class="filter-dropdown">
                <i class="bi bi-funnel filter-icon"></i>
                <select class="filter-select" id="filterStatusSelect">
                    <option value="">Status: Semua</option>
                <option value="status-menunggu">Menunggu Pembayaran</option>
                <option value="status-selesai">Selesai</option>
            </select>
        </div>
    </div>
</section>

<section class="table-wrapper full-width">
    <table class="sales-table">
        <thead>
            <tr>
                <th class="col-id">ID Transaksi</th>
                <th class="col-barang">Nama Barang</th>
                <th class="col-tanggal">Tanggal</th>
                <th class="col-total">Total Harga</th>
                <th class="col-status">Status</th>
                <th class="col-aksi">Aksi</th>
            </tr>
        </thead>
            <tbody id="salesHistoryBody">
                @forelse($salesHistory as $trx)
                <tr class="sales-row"
                    data-id="{{ $trx['id'] }}"
                    data-status-class="{{ $trx['status_class'] }}"
                    data-income="{{ $trx['income'] }}"
                    data-date="{{ $trx['date'] }}"
                    data-time="{{ $trx['time'] }}">

                    <td class="col-id">
                        <i class="bi bi-receipt"></i>
                        <span class="id-trx-text">{{ $trx['id'] }}</span>
                    </td>

                    <td class="col-barang">
                        <div class="product-profile-cell">
                            <div class="product-avatar-wrap">
                                <img src="{{ $trx['image'] }}"
                                    alt="{{ $trx['product_name'] }}"
                                    class="product-avatar">
                            </div>

                            <div class="product-meta-details">
                                <span class="product-name-text">
                                    {{ $trx['product_name'] }}
                                </span>

                                <span class="seller-info-text">
                                    Buyer:
                                    <strong>{{ $trx['buyer'] }}</strong>
                                </span>
                            </div>
                        </div>
                    </td>

                    <td class="col-tanggal">
                        <div class="date-time-wrapper">
                            <span class="date-text-main">
                                {{ $trx['date'] }}
                            </span>
                            <span class="time-text-sub">
                                {{ $trx['time'] }}
                            </span>
                        </div>
                    </td>

                    <td class="col-total">
                        <span class="price-text-new">
                            {{ $trx['income'] }}
                        </span>
                    </td>

                    <td class="col-status">
                        <span class="status-badge {{ $trx['status_class'] }}">
                            {{ $trx['status'] }}
                        </span>
                    </td>

                    <td class="col-aksi">
                        <div class="action-buttons-group">
                            <button
                                class="btn-action btn-detail-view"
                                data-id="{{ $trx['id'] }}"
                                data-name="{{ $trx['product_name'] }}"
                                data-buyer="{{ $trx['buyer'] }}"
                                data-income="{{ $trx['income'] }}"
                                data-date="{{ $trx['date'] }}, {{ $trx['time'] }}"
                                data-status="{{ $trx['status'] }}"
                                data-status-class="{{ $trx['status_class'] }}"
                                data-payment="{{ $trx['payment_proof'] }}">
                                <i class="bi bi-eye"></i>
                                Detail
                            </button>

                            @if($trx['status_class'] !== 'status-selesai')
                                <button
                                    class="btn-action btn-close-sale"
                                    data-id="{{ $trx['id'] }}"
                                    data-name="{{ $trx['product_name'] }}">
                                    <i class="bi bi-check2-circle"></i>
                                    Tutup
                                </button>
                            @endif
                        </div>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="empty-state-cell">
                        <div class="no-results-inner-new">
                            <div class="empty-icon-wrap">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <h3 class="no-results-title-new">Belum ada penjualan</h3>
                            <p class="no-results-desc-new">Transaksi penjualan Anda akan muncul di sini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
    </table>
</section>

{{-- MODAL DETAIL PENJUALAN --}}
<div class="modal-overlay" id="modalDetailSales">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Rincian Penjualan</h3>
            <button class="modal-close-btn" data-modal="modalDetailSales">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-simple">
            <div class="modal-trx-badge-wrapper">
                <span id="modalTrxId" class="modal-label-id"></span>
                <span id="modalTrxStatus" class="status-badge"></span>
            </div>
            
            <div class="detail-info-list">
                <div class="info-item">
                    <label>Bukti Pembayaran</label>
                    <div class="payment-proof-wrapper">
                        <img
                            id="modalPaymentProof"
                            src=""
                            alt="Bukti Pembayaran"
                            class="payment-proof-image">
                    </div>
                </div>
                
                <div class="info-item">
                    <label>Nama Barang</label>
                    <p id="modalProductName" class="info-value text-bold"></p>
                </div>
                <div class="info-item">
                    <label>Buyer</label>
                    <p id="modalBuyerName" class="info-value"></p>
                </div>
                <div class="info-item">
                    <label>Waktu Transaksi</label>
                    <p id="modalDateTime" class="info-value"></p>
                </div>
                <div class="info-item no-border">
                    <label>Total Pendapatan</label>
                    <p id="modalTotalIncome" class="info-value price-highlight"></p>
                </div>
            </div>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" data-modal="modalDetailSales">Tutup Halaman</button>
        </div>
    </div>
</div>

{{-- MODAL KONFIRMASI TUTUP PENJUALAN --}}
<div class="modal-overlay" id="modalConfirmClose">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Tutup Penjualan</h3>
            <button class="modal-close-btn" data-modal="modalConfirmClose">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-simple">
            <div class="modal-icon-wrap" style="color: #10B981; background: #D1FAE5;">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <p class="modal-confirm-text">
                Tandai penjualan <strong id="confirmProductName"></strong> sebagai selesai?
            </p>
            <input type="hidden" id="confirmTrxId">
        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" data-modal="modalConfirmClose">Batal</button>
            <button class="btn-modal-submit bg-success" id="btnSubmitCloseSale">Ya, Selesaikan</button>
        </div>
    </div>
</div>

{{-- LIGHTBOX IMAGE VIEWER --}}
<div class="lightbox-overlay" id="imageLightbox">
    <div class="lightbox-content">
        <button class="lightbox-close" data-modal="imageLightbox">&times;</button>
        <img src="" id="lightboxImage" alt="Preview" class="lightbox-image">
    </div>
</div>

@endsection