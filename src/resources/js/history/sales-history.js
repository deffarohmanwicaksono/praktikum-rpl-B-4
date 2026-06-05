const processSalesLiveQuery = () => {
    const tableBody    = document.getElementById('salesHistoryBody');
    const searchInput  = document.getElementById('searchSalesInput');
    const filterSelect = document.getElementById('filterStatusSelect');
    const sortSelect   = document.getElementById('sortSalesSelect'); // Opsional jika nanti mau ditambah

    // FIX: Hilangkan sortSelect dari validasi wajib agar fungsi tidak mati total
    if (!tableBody || !searchInput || !filterSelect) return;

    const searchQuery = searchInput.value.toLowerCase().trim();
    const statusFilter = filterSelect.value;
    
    let visibleRowsCount = 0;
    // FIX: Mengubah .purchase-row menjadi .sales-row sesuai HTML Penjualan
    const allRows = Array.from(tableBody.querySelectorAll('.sales-row'));

    // Filter Logic
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

    // Sort Logic (Hanya berjalan jika elemen sortSelect tersedia di HTML)
    if (sortSelect && sortSelect.value) {
        const sortBy = sortSelect.value;
        allRows.sort((rowA, rowB) => {
            if (sortBy === 'baru') return new Date(rowB.dataset.date) - new Date(rowA.dataset.date);
            if (sortBy === 'lama') return new Date(rowA.dataset.date) - new Date(rowB.dataset.date);
            return 0;
        });
        allRows.forEach(row => tableBody.appendChild(row));
    }

    // Handle Empty State saat Live Search
    const existRuntimeRow = document.getElementById('runtimeEmptySalesRow');
    if (visibleRowsCount === 0 && allRows.length > 0) {
        if (!existRuntimeRow) {
            const emptyRow = document.createElement('tr');
            emptyRow.id = 'runtimeEmptySalesRow';
            emptyRow.innerHTML = `
                <td colspan="6" class="empty-state-cell">
                    <div class="no-results-inner-new">
                        <div class="empty-icon-wrap"><i class="bi bi-search"></i></div>
                        <h3 class="no-results-title-new">Data tidak ditemukan</h3>
                        <p class="no-results-desc-new">Coba kata kunci atau filter status yang lain.</p>
                    </div>
                </td>`;
            tableBody.appendChild(emptyRow);
        }
    } else if (existRuntimeRow) {
        existRuntimeRow.remove();
    }
};

// Event Listener untuk Filter dan Search
document.addEventListener('input', (e) => { if (e.target.id === 'searchSalesInput') processSalesLiveQuery(); });
document.addEventListener('change', (e) => { if (e.target.id === 'filterStatusSelect' || e.target.id === 'sortSalesSelect') processSalesLiveQuery(); });

let currentRowToClose = null;

document.addEventListener('click', (e) => {
    
    // FIX: Logika untuk membuka Lightbox saat gambar bukti transfer diklik
    const proofImage = e.target.closest('.payment-proof-image');
    if (proofImage) {
        const lightbox = document.getElementById('imageLightbox');
        const lightboxImg = document.getElementById('lightboxImage');
        
        if (lightbox && lightboxImg) {
            lightboxImg.src = proofImage.src;
            openModal(lightbox); // Menggunakan fungsi openModal yang sama
        }
        return;
    }

    // 1. LOGIKA MODAL DETAIL PENJUALAN
    const detailBtn = e.target.closest('.btn-detail-view');
    if (detailBtn) {
        document.getElementById('modalTrxId').textContent = detailBtn.dataset.id;
        document.getElementById('modalProductName').textContent = detailBtn.dataset.name;
        document.getElementById('modalBuyerName').textContent = detailBtn.dataset.buyer;
        document.getElementById('modalTotalIncome').textContent = detailBtn.dataset.income;
        document.getElementById('modalDateTime').textContent = detailBtn.dataset.date;
        
        const modalTrxStatus = document.getElementById('modalTrxStatus');
        modalTrxStatus.textContent = detailBtn.dataset.status;
        modalTrxStatus.className = `status-badge ${detailBtn.dataset.statusClass}`;
        
        // FIX: Menyesuaikan pemanggilan dataset payment proof (data-payment)
        const proofImg = document.getElementById('modalPaymentProof');
        const proofWrapper = proofImg ? proofImg.closest('.payment-proof-wrapper') : null;
        
        if (proofImg && detailBtn.dataset.payment) {
            proofImg.src = detailBtn.dataset.payment;
            if (proofWrapper) proofWrapper.style.display = 'flex';
        } else if (proofWrapper) {
            // Sembunyikan bingkai jika gambar bukti tidak dikirim
            proofWrapper.style.display = 'none';
        }
        
        openModal(document.getElementById('modalDetailSales'));
        return;
    }

    // 2. TOMBOL BUKA MODAL TUTUP PENJUALAN
    const closeSaleBtn = e.target.closest('.btn-close-sale');
    if (closeSaleBtn) {
        // FIX: Mengubah .purchase-row menjadi .sales-row
        currentRowToClose = closeSaleBtn.closest('.sales-row');
        document.getElementById('confirmProductName').textContent = closeSaleBtn.dataset.name;
        document.getElementById('confirmTrxId').value = closeSaleBtn.dataset.id;
        
        openModal(document.getElementById('modalConfirmClose'));
        return;
    }

    // 3. KONFIRMASI TUTUP PENJUALAN (SUBMIT)
    if (e.target.id === 'btnSubmitCloseSale') {
        if (currentRowToClose) {
            const statusCell = currentRowToClose.querySelector('.col-status');
            statusCell.innerHTML = `<span class="status-badge status-selesai">Selesai</span>`;
            currentRowToClose.dataset.statusClass = 'status-selesai';
            
            const detailButton = currentRowToClose.querySelector('.btn-detail-view');
            if (detailButton) {
                detailButton.dataset.status = 'Selesai';
                detailButton.dataset.statusClass = 'status-selesai';
            }

            const btnClose = currentRowToClose.querySelector('.btn-close-sale');
            if (btnClose) btnClose.remove();
        }
        closeAllActiveModals();
        return;
    }

    // 4. TUTUP MODAL GENERAL (Tombol Batal / Klik Overlay / Klik Overlay Lightbox / Tombol Tutup Lightbox)
    if (e.target.closest('.modal-close-btn, .btn-modal-cancel, .lightbox-close') || e.target.classList.contains('modal-overlay') || e.target.classList.contains('lightbox-overlay')) {
        closeAllActiveModals();
    }
});

// Utility Functions Modal
function openModal(targetModal) { 
    if (targetModal) { 
        targetModal.classList.add('open'); 
        document.body.style.overflow = 'hidden'; 
    } 
}

// FIX: Update closeAllActiveModals agar menutup lightbox-overlay juga
function closeAllActiveModals() { 
    document.querySelectorAll('.modal-overlay, .lightbox-overlay').forEach(m => m.classList.remove('open')); 
    document.body.style.overflow = ''; 
    currentRowToClose = null; 
}

document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeAllActiveModals(); });