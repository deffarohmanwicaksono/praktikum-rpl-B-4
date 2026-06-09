// ==========================================================================
// SeMart Products Page Interactions
// ==========================================================================

// =============================================
// STATE & DOM ELEMENTS
// =============================================
let activeRow = document.querySelector('.product-row.active-row');
let rowToDelete = null;

// Modal DOM
const modalHapus      = document.getElementById('modalHapus');
const modalHapusName  = document.getElementById('modalHapusName');
const confirmHapusBtn = document.getElementById('confirmHapusBtn');

// Table & Toolbar DOM
const tableBody       = document.getElementById('productsTableBody');
const searchInput     = document.getElementById('searchInput');
const filterStatus    = document.getElementById('filterStatus');
const filterCategory  = document.getElementById('filterCategory');
const tableInfoText   = document.getElementById('tableInfoText');

// Detail Panel DOM
const detailCard         = document.getElementById('detailCard');
const detailMainImg      = document.getElementById('detailMainImg');
const detailName         = document.getElementById('detailName');
const detailPrice        = document.getElementById('detailPrice');
const detailSellerName   = document.getElementById('detailSellerName');
const detailSellerHandle = document.getElementById('detailSellerHandle');
const detailKategori     = document.getElementById('detailKategori');
const detailKondisi      = document.getElementById('detailKondisi');
const detailTanggal      = document.getElementById('detailTanggal');
const detailDeskripsi    = document.getElementById('detailDeskripsi');
const btnHapusDetail     = document.getElementById('btnHapus');


// =============================================
// HELPER: UPDATE TABLE INFO TEXT
// =============================================
function updateTableInfo() {
    if (!tableInfoText) return;

    const allRows = document.querySelectorAll('.product-row');
    let visibleCount = 0;
    
    allRows.forEach(row => {
        if (row.style.display !== 'none') {
            visibleCount++;
        }
    });

    const totalCount = allRows.length;

    if (totalCount === 0) {
        tableInfoText.textContent = 'Tidak ada produk yang tersisa.';
    } else if (visibleCount === 0) {
        tableInfoText.textContent = `Menampilkan 0 produk dari total ${totalCount} produk`;
    } else {
        tableInfoText.textContent = `Menampilkan 1–${visibleCount} dari ${totalCount} produk`;
    }
}


// =============================================
// SEARCH & FILTER LOGIC
// =============================================
function filterTable() {
    const searchTerm  = searchInput.value.toLowerCase();
    const statusVal   = filterStatus.value.toLowerCase();
    const categoryVal = filterCategory.value.toLowerCase();
    
    const rows = document.querySelectorAll('.product-row');
    
    rows.forEach(row => {
        const productData = JSON.parse(row.dataset.product);
        
        const matchSearch = productData.name.toLowerCase().includes(searchTerm) || 
                            productData.seller_name.toLowerCase().includes(searchTerm);
                            
        const matchStatus = statusVal === "" || productData.status.toLowerCase() === statusVal;
        const matchCategory = categoryVal === "" || productData.category.toLowerCase() === categoryVal;
        
        if (matchSearch && matchStatus && matchCategory) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });

    updateTableInfo();
}

searchInput.addEventListener('input', filterTable);
filterStatus.addEventListener('change', filterTable);
filterCategory.addEventListener('change', filterTable);


// =============================================
// TABLE EVENT DELEGATION (PILIH PRODUK)
// =============================================
tableBody.addEventListener('click', (e) => {
    const row = e.target.closest('.product-row');
    if (!row) return;

    if (activeRow) {
        activeRow.classList.remove('active-row');
        const oldBtn = activeRow.querySelector('.btn-detail');
        if (oldBtn) oldBtn.classList.remove('active');
    }

    row.classList.add('active-row');
    const newBtn = row.querySelector('.btn-detail');
    if (newBtn) newBtn.classList.add('active');
    
    activeRow = row;

    const productData = JSON.parse(row.dataset.product);

    if (detailCard) {
        detailCard.style.display = 'block';
        
        detailMainImg.src = productData.detail_image;
        const firstThumbBtn = document.querySelector('.detail-thumbnails .thumb-btn.active');
        if (firstThumbBtn) {
            firstThumbBtn.dataset.src = productData.detail_image;
            firstThumbBtn.querySelector('img').src = productData.image;
        }

        detailName.textContent         = productData.name;
        detailPrice.textContent        = productData.price;
        detailSellerName.textContent   = productData.seller_name;
        detailSellerHandle.textContent = productData.seller_handle;
        detailKategori.textContent     = productData.category;
        detailKondisi.textContent      = productData.condition;
        detailTanggal.textContent      = productData.date;
        detailDeskripsi.textContent    = productData.description;
    }
});


// =============================================
// TRIGGER HAPUS & MODALS
// =============================================
if (btnHapusDetail) {
    btnHapusDetail.addEventListener('click', () => {
        if (!activeRow) return;
        const productName = detailName.textContent.trim();
        rowToDelete = activeRow;
        modalHapusName.textContent = productName;
        openModal('modalHapus');
    });
}

confirmHapusBtn.addEventListener('click', () => {
    if (rowToDelete) {
        rowToDelete.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        rowToDelete.style.opacity = '0';
        rowToDelete.style.transform = 'translateX(-12px)';
        
        setTimeout(() => {
            rowToDelete.remove();
            
            // Hitung ulang teks jumlah produk setelah baris dihapus dari DOM
            updateTableInfo();

            if (activeRow === rowToDelete) {
                activeRow = null;
                const firstAvailableRow = document.querySelector('.product-row:not([style*="display: none"])');
                if (firstAvailableRow) {
                    firstAvailableRow.click();
                } else {
                    if (detailCard) detailCard.style.display = 'none';
                }
            }
            rowToDelete = null;
        }, 300);
    }
    closeAllModals();
});


// =============================================
// MODAL HELPERS
// =============================================
function openModal(id) {
    document.getElementById(id).classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeAllModals() {
    document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('open'));
    document.body.style.overflow = '';
}

document.querySelectorAll('.modal-close-btn, .btn-modal-cancel').forEach(btn => {
    btn.addEventListener('click', () => {
        const target = btn.dataset.modal;
        document.getElementById(target).classList.remove('open');
        document.body.style.overflow = '';
        rowToDelete = null;
    });
});

document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            closeAllModals();
            rowToDelete = null;
        }
    });
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeAllModals();
        rowToDelete = null;
    }
});

// Jalankan perhitungan pertama kali saat halaman di-load
document.addEventListener('DOMContentLoaded', updateTableInfo);