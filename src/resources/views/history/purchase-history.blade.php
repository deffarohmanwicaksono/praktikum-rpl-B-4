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
// Data transaksi sekarang diambil secara dinamis dari HistoryController
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
                    <option value="status-menunggu">Menunggu Pembayaran</option>
                    <option value="status-dibayar">Menunggu Konfirmasi</option>
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
            @forelse($transactions as $trx)
            <tr class="purchase-row" 
                data-id="TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}" 
                data-status-class="{{ $trx->status_class }}"
                data-price="{{ $trx->total_price }}"
                data-timestamp="{{ $trx->created_at->toIso8601String() }}">
                
                <td class="col-id">
                    <i class="bi bi-receipt"></i>
                    <span class="id-trx-text">TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}</span>
                </td>
                
                <td class="col-barang">
                    <div class="product-profile-cell">
                        <div class="product-avatar-wrap">
                            <img src="{{ $trx->image_url }}" alt="{{ $trx->product->name }}" class="product-avatar">
                        </div>
                        <div class="product-meta-details">
                            <span class="product-name-text">{{ $trx->product->name }}</span>
                            <span class="seller-info-text">Seller: <strong>{{ $trx->product->user->name ?? 'Unknown Seller' }}</strong></span>
                        </div>
                    </div>
                </td>
                
                <td class="col-tanggal">
                    <div class="date-time-wrapper">
                        <span class="date-text-main">{{ $trx->formatted_date }}</span>
                        <span class="time-text-sub">{{ $trx->formatted_time }}</span>
                    </div>
                </td>
                
                <td class="col-total">
                    <span class="price-text-new">{{ $trx->mapped_price }}</span>
                </td>
                
                <td class="col-status">
                    <span class="status-badge {{ $trx->status_class }}">{{ $trx->mapped_status }}</span>
                </td>
                
                <td class="col-aksi">
                    <div class="action-buttons-group">
                        <button class="btn-action btn-detail-view" 
                                data-id="TRX-{{ str_pad($trx->id, 4, '0', STR_PAD_LEFT) }}"
                                data-name="{{ $trx->product->name }}"
                                data-seller="{{ $trx->product->user->name ?? 'Unknown Seller' }}"
                                data-price="{{ $trx->mapped_price }}"
                                data-date="{{ $trx->formatted_date }} @ {{ $trx->formatted_time }}"
                                data-status="{{ $trx->mapped_status }}"
                                data-status-class="{{ $trx->status_class }}"
                                data-note="{{ $trx->purchaseLink->note ?? '' }}"
                                data-payment="{{ $trx->payment_proof_url }}"
                                title="Lihat Ringkasan">
                            <i class="bi bi-eye"></i> Detail
                        </button>

                        @if($trx->status_class === 'status-selesai')
                            @if($trx->review)
                            <button class="btn-action btn-review-view" 
                                    data-name="{{ $trx->product->name }}"
                                    data-seller="{{ $trx->product->user->name ?? 'Unknown Seller' }}"
                                    data-image="{{ $trx->image_url }}"
                                    data-rating="{{ $trx->review->rating }}"
                                    data-comment="{{ $trx->review->comment }}"
                                    title="Lihat Ulasan">
                                <i class="bi bi-star"></i> Ulasan
                            </button>
                            @else
                            <button class="btn-action btn-review-write" 
                                    data-id="{{ $trx->id }}"
                                    data-name="{{ $trx->product->name }}"
                                    data-seller="{{ $trx->product->user->name ?? 'Unknown Seller' }}"
                                    data-image="{{ $trx->image_url }}"
                                    title="Berikan Ulasan">
                                <i class="bi bi-star-fill"></i> Ulasan
                            </button>
                            @endif
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
        <form id="formSubmitReview" action="" method="POST" style="display: flex; flex-direction: column; flex: 1; min-height: 0; overflow: hidden;">
            @csrf
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
                    <textarea name="comment" id="reviewCommentTextarea" class="review-custom-textarea" rows="4" placeholder="Bagikan pengalaman Anda saat berbelanja"></textarea>
                </div>

            </div>
            <div class="modal-footer-custom review-footer">
                <button type="button" class="btn-modal-cancel" data-modal="modalReviewPurchase">Batal</button>
                <button type="submit" class="btn-modal-submit-primary" id="btnSubmitReviewAction">Kirim Ulasan</button>
            </div>
        </form>
    </div>
</div>

{{-- =============================================
     MODAL 3: LIHAT ULASAN
     ============================================= --}}
<div class="modal-overlay" id="modalViewReview">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Ulasan Anda</h3>
            <button class="modal-close-btn" data-modal="modalViewReview">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-simple text-left-align">
            
            <div class="product-review-header">
                <div class="review-avatar-wrap">
                    <img id="viewReviewProductImage" src="" alt="Thumbnail" class="review-avatar">
                </div>
                <div class="review-meta-wrap">
                    <h4 id="viewReviewProductName" class="review-product-title"></h4>
                    <p id="viewReviewSellerName" class="review-product-seller"></p>
                </div>
            </div>

            <div class="rating-input-container">
                <label class="rating-field-label">Kualitas Produk & Pelayanan</label>
                <div class="star-rating-row" id="viewStarRatingRow">
                    <i class="bi bi-star-fill review-star-item" style="color: #FFD700;"></i>
                    <i class="bi bi-star-fill review-star-item" style="color: #FFD700;"></i>
                    <i class="bi bi-star-fill review-star-item" style="color: #FFD700;"></i>
                    <i class="bi bi-star-fill review-star-item" style="color: #FFD700;"></i>
                    <i class="bi bi-star-fill review-star-item" style="color: #FFD700;"></i>
                </div>
            </div>

            <div class="review-textarea-container">
                <label class="rating-field-label">Ulasan Anda</label>
                <p id="viewReviewComment" class="review-custom-textarea" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 12px; font-size: 13.5px;"></p>
            </div>

        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" data-modal="modalViewReview">Tutup</button>
        </div>
    </div>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handling form submission logic for reviews (add action URL dynamically)
    const writeReviewBtns = document.querySelectorAll('.btn-review-write');
    const formSubmitReview = document.getElementById('formSubmitReview');
    
    writeReviewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const trxId = this.getAttribute('data-id');
            formSubmitReview.action = `/transactions/${trxId}/review`;
            // Also reset stars and inputs
            document.getElementById('ratingValueInput').value = "0";
            document.getElementById('reviewCommentTextarea').value = "";
            document.querySelectorAll('#starRatingRow .review-star-item').forEach(star => {
                star.classList.remove('bi-star-fill', 'active');
                star.classList.add('bi-star');
                star.style.color = ''; // Clear inline styles
            });
            document.getElementById('ratingHintText').textContent = "Pilih bintang untuk memberi nilai";
        });
    });

    // Handling view review modal
    const viewReviewBtns = document.querySelectorAll('.btn-review-view');
    const modalViewReview = document.getElementById('modalViewReview');

    viewReviewBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const name = this.getAttribute('data-name');
            const seller = this.getAttribute('data-seller');
            const image = this.getAttribute('data-image');
            const rating = parseInt(this.getAttribute('data-rating'));
            const comment = this.getAttribute('data-comment');

            document.getElementById('viewReviewProductName').textContent = name;
            document.getElementById('viewReviewSellerName').textContent = seller;
            document.getElementById('viewReviewProductImage').src = image;
            document.getElementById('viewReviewComment').textContent = comment || 'Tidak ada komentar';

            const stars = document.querySelectorAll('#viewStarRatingRow .review-star-item');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('bi-star');
                    star.classList.add('bi-star-fill');
                    star.style.color = '#FFD700';
                } else {
                    star.classList.remove('bi-star-fill');
                    star.classList.add('bi-star');
                    star.style.color = '#cbd5e1';
                }
            });

            // Open modal manually or rely on existing generic logic if it uses data-modal
            // if the existing script doesn't catch it, we open it:
            modalViewReview.classList.add('open');
        });
    });
    
    // Bind close button for view review
    document.querySelectorAll('[data-modal="modalViewReview"]').forEach(btn => {
        btn.addEventListener('click', () => {
            modalViewReview.classList.remove('open');
        });
    });
});
</script>
@endpush