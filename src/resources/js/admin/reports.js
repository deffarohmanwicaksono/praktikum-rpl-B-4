// =============================================
// DATA: reportData is injected globally from Blade
// =============================================

let activeId = Object.keys(reportData)[0] ? parseInt(Object.keys(reportData)[0]) : 0;
let pendingAction   = null; // 'tindaklanjuti' | 'tolak'
let pendingWarning  = '';

// =============================================
// STATUS LABEL HELPER
// =============================================
const statusLabel = {
    menunggu:        'Menunggu',
    ditindaklanjuti: 'Ditindaklanjuti',
    ditolak:         'Ditolak',
};

// =============================================
// RENDER ACTION AREA 
// =============================================
function renderActionArea(id) {
    const d = reportData[id];
    const area = document.getElementById('detailActionArea');
    if (!area) return;
    area.innerHTML = '';

    if (d.status === 'menunggu') {
        // Dua tombol: Tindaklanjuti + Tolak
        const btnRow = document.createElement('div');
        btnRow.className = 'detail-actions';
        btnRow.innerHTML = `
            <button class="btn-tindaklanjuti" id="btnTindak">
                <i class="bi bi-send-check"></i> Tindaklanjuti
            </button>
            <button class="btn-tolak-laporan" id="btnTolak">
                <i class="bi bi-x-circle"></i> Tolak
            </button>`;
        area.appendChild(btnRow);

        // Form peringatan
        const form = document.createElement('div');
        form.className = 'peringatan-form';
        form.id = 'peringatanForm';
        form.innerHTML = `
            <label>Isi Peringatan untuk Seller</label>
            <textarea
                class="peringatan-textarea"
                id="peringatanTextarea"
                placeholder="Tulis peringatan yang akan dikirim ke seller melalui notifikasi..."
                rows="4"
            ></textarea>
            <button class="btn-kirim-peringatan" id="btnKirimPeringatan">
                <i class="bi bi-send"></i> Kirim Peringatan
            </button>`;
        area.appendChild(form);

        // Event: Tindaklanjuti → tampilkan form peringatan
        const btnTindak = document.getElementById('btnTindak');
        if (btnTindak) {
            btnTindak.addEventListener('click', () => {
                const pForm = document.getElementById('peringatanForm');
                if (pForm) {
                    pForm.classList.add('visible');
                    const pTa = document.getElementById('peringatanTextarea');
                    if (pTa) pTa.focus();
                    pForm.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            });
        }

        // Event: Kirim Peringatan → validasi → modal konfirmasi
        const btnKirimPeringatan = document.getElementById('btnKirimPeringatan');
        if (btnKirimPeringatan) {
            btnKirimPeringatan.addEventListener('click', () => {
                const ta = document.getElementById('peringatanTextarea');
                const val = ta ? ta.value.trim() : '';
                if (!val) {
                    if (ta) {
                        ta.classList.add('error');
                        ta.focus();
                        setTimeout(() => ta.classList.remove('error'), 2000);
                    }
                    return;
                }
                pendingWarning = val;
                pendingAction  = 'tindaklanjuti';
                
                const modalSellerName = document.getElementById('modalTindakSellerName');
                if (modalSellerName) modalSellerName.textContent = d.sellerName;
                const modalProductName = document.getElementById('modalTindakProductName');
                if (modalProductName) modalProductName.textContent = d.productName;
                
                openModal('modalTindaklanjuti');
            });
        }

        // Event: Tolak → modal konfirmasi
        const btnTolak = document.getElementById('btnTolak');
        if (btnTolak) {
            btnTolak.addEventListener('click', () => {
                pendingAction = 'tolak';
                const modalTolakProduct = document.getElementById('modalTolakProductName');
                if (modalTolakProduct) modalTolakProduct.textContent = d.productName;
                openModal('modalTolakLaporan');
            });
        }

    } else if (d.status === 'ditindaklanjuti') {
        // Tampilkan peringatan yang sudah dikirim
        const box = document.createElement('div');
        box.className = 'info-tindak';
        box.innerHTML = `
            <p class="info-tindak-label">
                <i class="bi bi-send-check-fill"></i>
                Peringatan Terkirim ke Seller
            </p>
            <p class="info-tindak-text">${d.peringatan || '-'}</p>`;
        area.appendChild(box);

    } else if (d.status === 'ditolak') {
        // Tampilkan info ditolak
        const box = document.createElement('div');
        box.className = 'info-ditolak';
        box.innerHTML = `<i class="bi bi-slash-circle"></i> Laporan ini telah ditolak dan tidak diproses lebih lanjut.`;
        area.appendChild(box);
    }
}

// =============================================
// LOAD DETAIL
// =============================================
function loadDetail(id) {
    const d = reportData[id];
    if (!d) return;
    activeId = id;

    // Text fields
    document.getElementById('detailName').textContent         = d.productName;
    document.getElementById('detailPrice').textContent        = d.price;
    document.getElementById('detailSellerName').textContent   = d.sellerName;
    document.getElementById('detailSellerHandle').textContent = d.sellerHandle;
    document.getElementById('detailKategori').textContent     = d.category;
    document.getElementById('detailKondisi').textContent      = d.condition;
    document.getElementById('detailDilaporkan').textContent   = d.dilaporkan;
    document.getElementById('detailAlasan').textContent       = d.alasan;

    // Main image
    document.getElementById('detailMainImg').src = d.images[0];

    // Thumbnail strip
    const thumbWrap = document.getElementById('detailThumbnails');
    thumbWrap.innerHTML = '';
    d.images.forEach((src, idx) => {
        const thumbSrc = src.replace('w=600', 'w=120');
        const btn = document.createElement('button');
        btn.className = 'thumb-btn' + (idx === 0 ? ' active' : '');
        btn.dataset.src = src;
        btn.innerHTML = `<img src="${thumbSrc}" alt="">`;
        btn.addEventListener('click', () => {
            document.getElementById('detailMainImg').src = src;
            document.querySelectorAll('.thumb-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
        thumbWrap.appendChild(btn);
    });

    // Update form actions
    const formTindak = document.getElementById('formTindak');
    if (formTindak) {
        formTindak.action = `/admin/reports/${id}/action`;
    }
    const formTolak = document.getElementById('formTolak');
    if (formTolak) {
        formTolak.action = `/admin/reports/${id}/reject`;
    }

    // Action area
    renderActionArea(id);
}

// =============================================
// CONFIRM TINDAKLANJUTI
// =============================================
const btnConfirmTindak = document.getElementById('btnConfirmTindak');
if (btnConfirmTindak) {
    btnConfirmTindak.addEventListener('click', () => {
        if (pendingAction !== 'tindaklanjuti') return;

        const tindakPeringatanInput = document.getElementById('tindakPeringatanInput');
        if (tindakPeringatanInput) {
            tindakPeringatanInput.value = pendingWarning;
        }

        const formTindak = document.getElementById('formTindak');
        if (formTindak) {
            formTindak.submit();
        }
    });
}

// =============================================
// CONFIRM TOLAK
// =============================================
const btnConfirmTolak = document.getElementById('btnConfirmTolak');
if (btnConfirmTolak) {
    btnConfirmTolak.addEventListener('click', () => {
        if (pendingAction !== 'tolak') return;

        const formTolak = document.getElementById('formTolak');
        if (formTolak) {
            formTolak.submit();
        }
    });
}

// =============================================
// TABLE ROW CLICK 
// =============================================
const reportTableBody = document.getElementById('reportTableBody');
if (reportTableBody) {
    reportTableBody.addEventListener('click', (e) => {
        const btn = e.target.closest('.btn-detail');
        if (!btn) return;

        const id = parseInt(btn.dataset.id);

        document.querySelectorAll('.report-row').forEach(r => r.classList.remove('active-row'));
        btn.closest('.report-row').classList.add('active-row');

        document.querySelectorAll('.btn-detail').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        loadDetail(id);
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

document.querySelectorAll('.modal-close-btn, .btn-modal-cancel').forEach(btn => {
    btn.addEventListener('click', () => {
        const target = btn.dataset.modal;
        if (target) {
            const modal = document.getElementById(target);
            if (modal) {
                modal.classList.remove('open');
                document.body.style.overflow = '';
            }
        }
    });
});

document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) closeAllModals();
    });
});

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

    document.addEventListener('click', (e) => {
        if (!e.target.closest('#adminDropdown')) {
            adminMenu.classList.remove('open');
            if (adminChevron) adminChevron.style.transform = 'rotate(0deg)';
        }
    });
}

// =============================================
// INIT
// =============================================
if (activeId > 0) {
    loadDetail(activeId);
}