// ==========================================================================
// SeMart Purchase History
// ==========================================================================

const ratingHints = {
    1: "Buruk sekali, tidak direkomendasikan.",
    2: "Kurang puas, banyak kekurangan.",
    3: "Cukup baik, standar pelayanan oke.",
    4: "Puas, barang sesuai harapan.",
    5: "Sangat puas! Respon mantap & barang sesuai."
};

// =============================================
// CORE FILTER & SEARCH ALGORITHM
// =============================================
const processLiveQueryEngine = () => {
    const tableBody    = document.getElementById('purchaseHistoryBody');
    const searchInput  = document.getElementById('searchPurchaseInput');
    const filterSelect = document.getElementById('filterStatusSelect');

    // Hentikan eksekusi jika komponen utama tabel belum dimuat
    if (!tableBody || !searchInput || !filterSelect) return;

    const searchQuery = searchInput.value.toLowerCase().trim();
    const statusFilter = filterSelect.value;
    
    let visibleRowsCount = 0;
    const allRows = Array.from(tableBody.querySelectorAll('.purchase-row'));

    // Filter & Search Logic
    allRows.forEach(row => {
        const trxId = row.querySelector('.id-trx-text').textContent.toLowerCase();
        const productName = row.querySelector('.product-name-text').textContent.toLowerCase();
        const statusClass = row.dataset.statusClass;

        const isSearchMatched = trxId.includes(searchQuery) || productName.includes(searchQuery);
        const isStatusMatched = statusFilter === '' || statusClass === statusFilter;

        if (isSearchMatched && isStatusMatched) {
            row.style.display = '';
            visibleRowsCount++;
        } else {
            row.style.display = 'none';
        }
    });

    // State Kosong (Empty State) saat pencarian tidak ditemukan
    const existRuntimeRow = document.getElementById('runtimeEmptyRow');
    if (visibleRowsCount === 0 && allRows.length > 0) {
        if (!existRuntimeRow) {
            const emptyRow = document.createElement('tr');
            emptyRow.id = 'runtimeEmptyRow';
            emptyRow.innerHTML = `
                <td colspan="6" class="empty-state-cell">
                    <div class="no-results-inner-new">
                        <div class="empty-icon-wrap"><i class="bi bi-search"></i></div>
                        <h3 class="no-results-title-new">Data tidak ditemukan</h3>
                        <p class="no-results-desc-new">Ganti kata kunci pencarian atau ubah kombinasi filter Anda.</p>
                    </div>
                </td>
            `;
            tableBody.appendChild(emptyRow);
        }
    } else if (existRuntimeRow) {
        existRuntimeRow.remove();
    }
};

// =============================================
// GLOBAL EVENT DELEGATION (Search & Filter)
// =============================================

document.addEventListener('input', (e) => {
    if (e.target.id === 'searchPurchaseInput') {
        processLiveQueryEngine();
    }
});

document.addEventListener('change', (e) => {
    if (e.target.id === 'filterStatusSelect') {
        processLiveQueryEngine();
    }
});

// =============================================
// GLOBAL EVENT DELEGATION (Modals & Buttons)
// =============================================
document.addEventListener('click', (e) => {
    
    // PERBAIKAN 1: Logika untuk membuka Lightbox saat gambar bukti diklik
    const proofImage = e.target.closest('.payment-proof-image');
    if (proofImage) {
        const lightbox = document.getElementById('imageLightbox');
        const lightboxImg = document.getElementById('lightboxImage');
        
        if (lightbox && lightboxImg) {
            lightboxImg.src = proofImage.src;
            openModal(lightbox); 
        }
        return;
    }

    // 1. Tombol Detail Transaksi
    const detailBtn = e.target.closest('.btn-detail-view');
    if (detailBtn) {
        const modalDetail = document.getElementById('modalDetailPurchase');
        document.getElementById('modalTrxId').textContent = detailBtn.dataset.id;
        document.getElementById('modalProductName').textContent = detailBtn.dataset.name;
        document.getElementById('modalSellerName').textContent = detailBtn.dataset.seller;
        document.getElementById('modalTotalPay').textContent = detailBtn.dataset.price;
        document.getElementById('modalDateTime').textContent = detailBtn.dataset.date;
        document.getElementById('modalTrxNote').textContent = detailBtn.dataset.note || 'Tidak ada catatan transaksi.';
        
        const modalTrxStatus = document.getElementById('modalTrxStatus');
        modalTrxStatus.textContent = detailBtn.dataset.status;
        modalTrxStatus.className = `status-badge ${detailBtn.dataset.statusClass}`;
        
        // PERBAIKAN 2: Memproses Bukti Pembayaran ke dalam modal detail
        const proofImg = document.getElementById('modalPurchasePaymentProof');
        const proofWrapper = document.getElementById('purchaseProofWrapper');
        const noProofText = document.getElementById('modalPurchaseNoProofText');
        
        if (proofImg && detailBtn.dataset.payment) {
            proofImg.src = detailBtn.dataset.payment;
            if (proofWrapper) proofWrapper.style.display = 'flex';
            if (noProofText) noProofText.style.display = 'none';
        } else if (proofWrapper) {
            proofImg.src = '';
            proofWrapper.style.display = 'none';
            if (noProofText) noProofText.style.display = 'block';
        }
        
        openModal(modalDetail);
        return;
    }

    // 2. Tombol Tulis Ulasan
    const reviewBtn = e.target.closest('.btn-review-write');
    if (reviewBtn) {
        const modalReview = document.getElementById('modalReviewPurchase');
        document.getElementById('reviewProductName').textContent = reviewBtn.dataset.name;
        document.getElementById('reviewSellerName').textContent = `Seller: ${reviewBtn.dataset.seller}`;
        document.getElementById('reviewProductImage').src = reviewBtn.dataset.image;
        
        document.getElementById('ratingValueInput').value = "0";
        document.getElementById('reviewCommentTextarea').value = "";
        
        const hintText = document.getElementById('ratingHintText');
        hintText.textContent = "Pilih bintang untuk memberi nilai";
        hintText.style.color = "";
        
        resetStarsUI();
        openModal(modalReview);
        return;
    }

    // 3. Logika Klik Bintang Rating
    const starBtn = e.target.closest('.review-star-item');
    if (starBtn) {
        const selectedRating = parseInt(starBtn.dataset.rating);
        document.getElementById('ratingValueInput').value = selectedRating;
        
        const hintText = document.getElementById('ratingHintText');
        hintText.textContent = ratingHints[selectedRating];
        hintText.style.color = "var(--primary-blue)";
        
        const starRatingRow = document.getElementById('starRatingRow');
        starRatingRow.querySelectorAll('.review-star-item').forEach(s => {
            const currentStarVal = parseInt(s.dataset.rating);
            if (currentStarVal <= selectedRating) {
                s.classList.remove('bi-star');
                s.classList.add('bi-star-fill', 'active');
            } else {
                s.classList.remove('bi-star-fill', 'active');
                s.classList.add('bi-star');
            }
        });
        return;
    }

    // 4. Tombol Tutup Modal & Overlay
    // PERBAIKAN 3: Menambahkan class lightbox-close dan lightbox-overlay untuk ditutup juga
    if (e.target.closest('.modal-close-btn, .btn-modal-cancel, .lightbox-close') || e.target.classList.contains('modal-overlay') || e.target.classList.contains('lightbox-overlay')) {
        closeAllActiveModals();
    }
});

// =============================================
// UTILITIES
// =============================================
function resetStarsUI() {
    const starRatingRow = document.getElementById('starRatingRow');
    if (!starRatingRow) return;
    starRatingRow.querySelectorAll('.review-star-item').forEach(s => {
        s.classList.remove('bi-star-fill', 'active');
        s.classList.add('bi-star');
        s.style.color = '';
    });
}

function openModal(targetModal) {
    if (targetModal) {
        targetModal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
}

// PERBAIKAN 4: Menambahkan lightbox-overlay agar ikut tertutup saat fungsi ini dipanggil
function closeAllActiveModals() {
    document.querySelectorAll('.modal-overlay, .lightbox-overlay').forEach(m => m.classList.remove('open'));
    document.body.style.overflow = '';
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeAllActiveModals();
});