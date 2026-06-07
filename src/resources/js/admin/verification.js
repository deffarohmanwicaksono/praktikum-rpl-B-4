// =============================================
// DATA: productData is injected globally from Blade
// =============================================

let activeId = Object.keys(productData)[0] ? parseInt(Object.keys(productData)[0]) : 0;
let activeImgIdx  = 0;   // active thumbnail index
let alasanVisible = true; // alasan section state

// =============================================
// DETAIL PANEL: Load product data
// =============================================
function loadDetail(id) {
    const d = productData[id];
    if (!d) return;
    activeId     = id;
    activeImgIdx = 0;

    // Text fields
    document.getElementById('detailName').textContent       = d.name;
    document.getElementById('detailPrice').textContent      = d.price;
    document.getElementById('detailSellerName').textContent = d.seller;
    document.getElementById('detailSellerHandle').textContent = d.handle;
    document.getElementById('detailKategori').textContent   = d.kategori;
    document.getElementById('detailKondisi').textContent    = d.kondisi;
    document.getElementById('detailDiajukan').textContent   = d.diajukan;
    document.getElementById('detailDeskripsi').textContent  = d.deskripsi;

    // Main image
    const mainImg = document.getElementById('detailMainImg');
    mainImg.src = d.images[0];
    document.getElementById('imgCounter').textContent = `1 / ${d.images.length}`;

    // Thumbnail strip
    const thumbWrap = document.getElementById('detailThumbnails');
    thumbWrap.innerHTML = '';
    d.images.forEach((src, idx) => {
        const thumbSrc = src.replace('w=600', 'w=120');
        const btn = document.createElement('button');
        btn.className = 'thumb-btn' + (idx === 0 ? ' active' : '');
        btn.dataset.src = src;
        btn.dataset.idx = idx;
        btn.innerHTML = `<img src="${thumbSrc}" alt="">`;
        btn.addEventListener('click', () => switchImage(idx, d.images[idx], btn));
        thumbWrap.appendChild(btn);
    });

    // Update form actions
    const formApprove = document.getElementById('formApprove');
    if (formApprove) {
        formApprove.action = `/admin/verification/${id}/approve`;
    }
    const formReject = document.getElementById('formReject');
    if (formReject) {
        formReject.action = `/admin/verification/${id}/reject`;
    }

    // Reset alasan textarea
    const alasanInput = document.getElementById('alasanInput');
    if (alasanInput) {
        alasanInput.value = '';
    }
}

function switchImage(idx, src, btn) {
    activeImgIdx = idx;
    document.getElementById('detailMainImg').src = src;
    document.getElementById('imgCounter').textContent =
        `${idx + 1} / ${productData[activeId].images.length}`;
    document.querySelectorAll('.thumb-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
}

// =============================================
// TABLE ROWS: Click Detail button
// =============================================
const verifTableBody = document.getElementById('verifTableBody');
if (verifTableBody) {
    verifTableBody.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-detail');
        if (!btn) return;
        const id = parseInt(btn.dataset.id);

        // Update active row highlight
        document.querySelectorAll('.verif-row').forEach(r => r.classList.remove('active-row'));
        btn.closest('.verif-row').classList.add('active-row');

        // Update Detail button state
        document.querySelectorAll('.btn-detail').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        loadDetail(id);

        // Show alasan section if hidden
        const alasanSection = document.getElementById('alasanSection');
        if (alasanSection) {
            alasanSection.classList.remove('hidden');
        }
    });
}

// =============================================
// SETUJUI button
// =============================================
const btnSetujui = document.getElementById('btnSetujui');
if (btnSetujui) {
    btnSetujui.addEventListener('click', () => {
        const name = productData[activeId]?.name || '';
        const modalName = document.getElementById('modalSetujuiName');
        if (modalName) modalName.textContent = name;
        openModal('modalSetujui');
    });
}

// =============================================
// TOLAK button → show alasan + open modal
// =============================================
const btnTolak = document.getElementById('btnTolak');
if (btnTolak) {
    btnTolak.addEventListener('click', () => {
        const alasanInput = document.getElementById('alasanInput');
        const alasan = alasanInput ? alasanInput.value.trim() : '';
        if (!alasan) {
            // Highlight textarea and focus
            if (alasanInput) {
                alasanInput.classList.add('error');
                alasanInput.focus();
                alasanInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => alasanInput.classList.remove('error'), 2000);
            }
            return;
        }
        const name = productData[activeId]?.name || '';
        const modalName = document.getElementById('modalTolakName');
        if (modalName) modalName.textContent = name;
        openModal('modalTolak');
    });
}

// Confirm Setujui
const btnModalSetujui = document.querySelector('.btn-modal-setujui');
if (btnModalSetujui) {
    btnModalSetujui.addEventListener('click', () => {
        const formApprove = document.getElementById('formApprove');
        if (formApprove) formApprove.submit();
    });
}

// Confirm Tolak
const btnModalTolak = document.querySelector('.btn-modal-tolak');
if (btnModalTolak) {
    btnModalTolak.addEventListener('click', () => {
        const alasanInput = document.getElementById('alasanInput');
        const alasan = alasanInput ? alasanInput.value.trim() : '';
        const rejectAlasanInput = document.getElementById('rejectAlasanInput');
        if (rejectAlasanInput) rejectAlasanInput.value = alasan;

        const formReject = document.getElementById('formReject');
        if (formReject) formReject.submit();
    });
}

// =============================================
// MODAL HELPERS
// =============================================
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) {
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
}

function closeAllModals() {
    document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('open'));
    document.body.style.overflow = '';
}

// Close buttons (data-modal attribute)
document.querySelectorAll('.modal-close-btn, .btn-modal-cancel').forEach(btn => {
    btn.addEventListener('click', () => {
        const target = btn.dataset.modal;
        const modal = document.getElementById(target);
        if (modal) {
            modal.classList.remove('open');
            document.body.style.overflow = '';
        }
    });
});

// Close on overlay click
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeAllModals();
    });
});

// Close on Escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeAllModals();
});

// =============================================
// ADMIN DROPDOWN
// =============================================
const adminToggle  = document.getElementById('adminToggle');
const adminMenu    = document.getElementById('adminMenu');
const adminChevron = document.getElementById('adminChevron');

if (adminToggle && adminMenu) {
    adminToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = adminMenu.classList.toggle('open');
        if (adminChevron) adminChevron.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
        adminToggle.setAttribute('aria-expanded', String(isOpen));
    });
}

document.addEventListener('click', (e) => {
    if (!e.target.closest('#adminDropdown') && adminMenu) {
        adminMenu.classList.remove('open');
        if (adminChevron) adminChevron.style.transform = 'rotate(0deg)';
    }
});

// =============================================
// INIT: load first item on page load
// =============================================
if (activeId > 0) {
    loadDetail(activeId);
}