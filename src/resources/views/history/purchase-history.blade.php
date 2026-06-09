@extends('layouts.app')

@section('title', 'Riwayat Pembelian - SeMart')

@push('styles')
    @vite([
    'resources/css/components/history.css',
    'resources/css/pages/purchase-history.css'
    ])
@endpush

@push('scripts')
    @vite('resources/js/history/purchase-history.js')
@endpush

@section('content')

@php
// Data dummy riwayat pembelian
$purchaseHistory = [
    [
        'id' => 'TRX-2026-001',
        'product_name' => 'Buku Cetak Kalkulus Stewart',
        'seller' => 'Andi Pratama',
        'price' => 'Rp 85.000',
        'price_raw' => 85000,
        'date' => '04 Juni 2026',
        'time' => '19:45 WIB',
        'timestamp' => '2026-06-04T19:45:00',
        'status' => 'Menunggu Konfirmasi',
        'status_class' => 'status-menunggu',
        'image' => asset('images/products/kalkulus_steward.jpg'),
        'note' => 'Mohon dikirim via COD di depan Perpustakaan Pusat ya kak.',
        'payment_proof' => asset('images/products/basis_data.jpg') // Contoh ada bukti
    ],
    [
        'id' => 'TRX-2026-002',
        'product_name' => 'Jaket Almamater UNS',
        'seller' => 'Siti Aisyah',
        'price' => 'Rp 120.000',
        'price_raw' => 120000,
        'date' => '02 Juni 2026',
        'time' => '10:15 WIB',
        'timestamp' => '2026-06-02T10:15:00',
        'status' => 'Selesai',
        'status_class' => 'status-selesai',
        'image' => asset('images/products/almet.jpg'),
        'note' => 'Barang sudah diterima langsung di Gedung Kuliah Bersama.',
        'payment_proof' => asset('images/products/tas_ransel.jpg') // Contoh ada bukti
    ],
    [
        'id' => 'TRX-2026-003',
        'product_name' => 'Buku Struktur Data Java',
        'seller' => 'Budi Santoso',
        'price' => 'Rp 45.000',
        'price_raw' => 45000,
        'date' => '28 Mei 2026',
        'time' => '14:20 WIB',
        'timestamp' => '2026-05-28T14:20:00',
        'status' => 'Selesai',
        'status_class' => 'status-selesai',
        'image' => asset('images/products/struktur_data_java.jpg'),
        'note' => 'Fungsi fast charging berjalan normal di laptop.',
        'payment_proof' => '' // Contoh tidak ada bukti
    ],
    [
        'id' => 'TRX-2026-004',
        'product_name' => 'Tas Ransel Eiger',
        'seller' => 'Rizky Maulana',
        'price' => 'Rp 175.000',
        'price_raw' => 175000,
        'date' => '20 Mei 2026',
        'time' => '11:00 WIB',
        'timestamp' => '2026-05-20T11:00:00',
        'status' => 'Gagal',
        'status_class' => 'status-gagal',
        'image' => asset('images/products/tas_ransel.jpg'),
        'note' => 'Transaksi dibatalkan karena stok barang ternyata sudah pecah/rusak fisik.',
        'payment_proof' => '' // Contoh tidak ada bukti
    ]
];
@endphp

{{-- =============================================
     PAGE HEADER
     ============================================= --}}
<section class="page-header-section">
    <div class="page-header-left">
        <h1 class="page-title">Riwayat Pembelian</h1>
        <p class="page-subtitle">Pantau status pesanan, kelola ulasan produk, dan lihat riwayat transaksi belanja Anda di SeMart</p>
    </div>
</section>

{{-- =============================================
     TOOLBAR: SEARCH, FILTER, & SORTING
     ============================================= --}}
<div class="toolbar-section">
    <div class="toolbar-left-group">
        <div class="search-box">
            <i class="bi bi-search search-icon"></i>
            <input type="text" class="search-input" id="searchPurchaseInput" placeholder="Cari nama barang atau ID transaksi...">
        </div>
        
        <div class="filter-box">
            <div class="filter-dropdown">
                <i class="bi bi-funnel filter-icon"></i>
                <select class="filter-select" id="filterStatusSelect">
                    <option value="">Status: Semua</option>
                    <option value="status-menunggu">Menunggu Konfirmasi</option>
                    <option value="status-selesai">Selesai</option>
                    <option value="status-gagal">Gagal</option>
                </select>
            </div>
        </div>
    </div>
</div>

{{-- =============================================
     MAIN PANEL: TABLE RIWAYAT PEMBELIAN
     ============================================= --}}
<div class="table-wrapper full-width">
    <table class="purchase-table">
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
        <tbody id="purchaseHistoryBody">
            @forelse($purchaseHistory as $trx)
            <tr class="purchase-row" 
                data-id="{{ $trx['id'] }}" 
                data-status-class="{{ $trx['status_class'] }}"
                data-price="{{ $trx['price_raw'] }}"
                data-timestamp="{{ $trx['timestamp'] }}">
                
                <td class="col-id">
                    <i class="bi bi-receipt"></i>
                    <span class="id-trx-text">{{ $trx['id'] }}</span>
                </td>
                
                <td class="col-barang">
                    <div class="product-profile-cell">
                        <div class="product-avatar-wrap">
                            <img src="{{ $trx['image'] }}" alt="{{ $trx['product_name'] }}" class="product-avatar">
                        </div>
                        <div class="product-meta-details">
                            <span class="product-name-text">{{ $trx['product_name'] }}</span>
                            <span class="seller-info-text">Seller: <strong>{{ $trx['seller'] }}</strong></span>
                        </div>
                    </div>
                </td>
                
                <td class="col-tanggal">
                    <div class="date-time-wrapper">
                        <span class="date-text-main">{{ $trx['date'] }}</span>
                        <span class="time-text-sub">{{ $trx['time'] }}</span>
                    </div>
                </td>
                
                <td class="col-total">
                    <span class="price-text-new">{{ $trx['price'] }}</span>
                </td>
                
                <td class="col-status">
                    <span class="status-badge {{ $trx['status_class'] }}">{{ $trx['status'] }}</span>
                </td>
                
                <td class="col-aksi">
                    <div class="action-buttons-group">
                        <button class="btn-action btn-detail-view" 
                                data-id="{{ $trx['id'] }}"
                                data-name="{{ $trx['product_name'] }}"
                                data-seller="{{ $trx['seller'] }}"
                                data-price="{{ $trx['price'] }}"
                                data-date="{{ $trx['date'] }} @ {{ $trx['time'] }}"
                                data-status="{{ $trx['status'] }}"
                                data-status-class="{{ $trx['status_class'] }}"
                                data-note="{{ $trx['note'] }}"
                                data-payment="{{ $trx['payment_proof'] ?? '' }}"
                                title="Lihat Ringkasan">
                            <i class="bi bi-eye"></i> Detail
                        </button>

                        @if($trx['status_class'] === 'status-selesai')
                        <button class="btn-action btn-review-write" 
                                data-name="{{ $trx['product_name'] }}"
                                data-seller="{{ $trx['seller'] }}"
                                data-image="{{ $trx['image'] }}"
                                title="Berikan Ulasan">
                            <i class="bi bi-star-fill"></i> Ulasan
                        </button>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr id="emptyStateRow">
                <td colspan="6" class="empty-state-cell">
                    <div class="no-results-inner-new">
                        <div class="empty-icon-wrap">
                            <i class="bi bi-bag-x"></i>
                        </div>
                        <h3 class="no-results-title-new">Belum ada riwayat transaksi</h3>
                        <p class="no-results-desc-new">Kamu belum pernah membeli barang apa pun. Yuk cari keperluan kuliahmu di SeMart!</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- =============================================
     MODAL 1: RINGKASAN DETAIL TRANSAKSI
     ============================================= --}}
<div class="modal-overlay" id="modalDetailPurchase">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Ringkasan Pesanan</h3>
            <button class="modal-close-btn" data-modal="modalDetailPurchase">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-simple text-left-align">
            <div class="modal-trx-badge-wrapper">
                <span id="modalTrxId" class="modal-label-id"></span>
                <span id="modalTrxStatus" class="status-badge"></span>
            </div>
            
            <div class="detail-info-list">
                <div class="info-item">
                    <label>Bukti Pembayaran</label>
                    <div class="payment-proof-wrapper" id="purchaseProofWrapper" style="display: none;">
                        <img src="" id="modalPurchasePaymentProof" alt="Bukti Pembayaran" class="payment-proof-image">
                    </div>
                    <p id="modalPurchaseNoProofText" style="display: none; font-size: 12.5px; color: var(--gray-text); font-style: italic; margin-top: 4px; margin-bottom: 0;">Bukti pembayaran tidak dilampirkan.</p>
                </div>
                <div class="info-item">
                    <label>Nama Barang</label>
                    <p id="modalProductName" class="info-value text-bold"></p>
                </div>
                <div class="info-item">
                    <label>Seller</label>
                    <p id="modalSellerName" class="info-value"></p>
                </div>
                <div class="info-item">
                    <label>Waktu Transaksi</label>
                    <p id="modalDateTime" class="info-value"></p>
                </div>
                <div class="info-item">
                    <label>Total Pembayaran</label>
                    <p id="modalTotalPay" class="info-value price-highlight"></p>
                </div>

                <div class="info-item no-border">
                    <label>Catatan Transaksi</label>
                    <div class="note-box-container">
                        <p id="modalTrxNote" class="note-text-value"></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" data-modal="modalDetailPurchase">Tutup</button>
        </div>
    </div>
</div>

{{-- =============================================
     MODAL 2: FORM TULIS ULASAN BARANG
     ============================================= --}}
<div class="modal-overlay" id="modalReviewPurchase">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Berikan Ulasan Produk</h3>
            <button class="modal-close-btn" data-modal="modalReviewPurchase">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <form id="formSubmitReview" action="#" method="POST" onsubmit="event.preventDefault(); alert('Ulasan berhasil disimpan!'); document.getElementById('modalReviewPurchase').classList.remove('open');">
            <div class="modal-body-simple text-left-align">
                
                <div class="product-review-header">
                    <div class="review-avatar-wrap">
                        <img id="reviewProductImage" src="" alt="Thumbnail" class="review-avatar">
                    </div>
                    <div class="review-meta-wrap">
                        <h4 id="reviewProductName" class="review-product-title"></h4>
                        <p id="reviewSellerName" class="review-product-seller"></p>
                    </div>
                </div>

                <div class="rating-input-container">
                    <label class="rating-field-label">Kualitas Produk & Pelayanan</label>
                    <div class="star-rating-row" id="starRatingRow">
                        <i class="bi bi-star review-star-item" data-rating="1"></i>
                        <i class="bi bi-star review-star-item" data-rating="2"></i>
                        <i class="bi bi-star review-star-item" data-rating="3"></i>
                        <i class="bi bi-star review-star-item" data-rating="4"></i>
                        <i class="bi bi-star review-star-item" data-rating="5"></i>
                    </div>
                    <input type="hidden" name="rating_value" id="ratingValueInput" value="0" required>
                    <p class="rating-hint-text" id="ratingHintText">Pilih bintang untuk memberi nilai</p>
                </div>

                <div class="review-textarea-container">
                    <label for="reviewCommentTextarea" class="rating-field-label">Tulis Ulasan Anda</label>
                    <textarea id="reviewCommentTextarea" class="review-custom-textarea" rows="4" placeholder="Bagikan pengalaman Anda saat berbelanja" required></textarea>
                </div>

            </div>
            <div class="modal-footer-custom">
                <button type="button" class="btn-modal-cancel" data-modal="modalReviewPurchase">Batal</button>
                <button type="submit" class="btn-modal-submit-primary" id="btnSubmitReviewAction">Kirim Ulasan</button>
            </div>
        </form>
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