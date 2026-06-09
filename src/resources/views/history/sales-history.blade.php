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
// Data transaksi sekarang diambil secara dinamis dari HistoryController
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
                @forelse($transactions as $trx)
                <tr class="sales-row"
                    data-id="TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}"
                    data-status-class="{{ $trx->status_class }}"
                    data-income="{{ $trx->total_price }}"
                    data-date="{{ $trx->formatted_date }}"
                    data-time="{{ $trx->formatted_time }}">

                    <td class="col-id">
                        <i class="bi bi-receipt"></i>
                        <span class="id-trx-text">TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </td>

                    <td class="col-barang">
                        <div class="product-profile-cell">
                            <div class="product-avatar-wrap">
                                <img src="{{ $trx->image_url }}"
                                    alt="{{ $trx->product->name }}"
                                    class="product-avatar">
                            </div>

                            <div class="product-meta-details">
                                <span class="product-name-text">
                                    {{ $trx->product->name }}
                                </span>

                                <span class="seller-info-text">
                                    Buyer:
                                    <strong>{{ $trx->buyer->name ?? 'Unknown Buyer' }}</strong>
                                </span>
                            </div>
                        </div>
                    </td>

                    <td class="col-tanggal">
                        <div class="date-time-wrapper">
                            <span class="date-text-main">
                                {{ $trx->formatted_date }}
                            </span>
                            <span class="time-text-sub">
                                {{ $trx->formatted_time }}
                            </span>
                        </div>
                    </td>

                    <td class="col-total">
                        <span class="price-text-new">
                            {{ $trx->mapped_price }}
                        </span>
                    </td>

                    <td class="col-status">
                        <span class="status-badge {{ $trx->status_class }}">
                            {{ $trx->mapped_status }}
                        </span>
                    </td>

                    <td class="col-aksi">
                        <div class="action-buttons-group">
                            <button
                                class="btn-action btn-detail-view"
                                data-id="TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}"
                                data-name="{{ $trx->product->name }}"
                                data-buyer="{{ $trx->buyer->name ?? 'Unknown Buyer' }}"
                                data-income="{{ $trx->mapped_price }}"
                                data-date="{{ $trx->formatted_date }}, {{ $trx->formatted_time }}"
                                data-status="{{ $trx->mapped_status }}"
                                data-status-class="{{ $trx->status_class }}"
                                data-payment="{{ $trx->payment_proof_url }}">
                                <i class="bi bi-eye"></i>
                                Detail
                            </button>

                            @if($trx->status_class !== 'status-selesai')
                                <button
                                    class="btn-action btn-close-sale"
                                    data-id="TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}"
                                    data-name="{{ $trx->product->name }}">
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