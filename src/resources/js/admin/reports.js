// =============================================
// DATA
// =============================================
const reportData = {
    1: {
        id: 1,
        productName:   'Jaket Denim Pria',
        category:      'Pakaian',
        price:         'Rp120.000',
        condition:     'Bekas Seperti Baru',
        sellerName:    'Andi Pratama',
        sellerHandle:  '@andi.pratama',
        pelapor:       'Budi Santoso, @budi.santoso',
        dilaporkan:    '05 Juni 2026, 09:14 WIB',
        alasan:        'Foto produk tidak sesuai dengan kondisi asli barang. Barang yang saya terima jauh berbeda dari foto yang dipasang.',
        status:        'menunggu',
        peringatan:    null,
        images: [
            'https://images.unsplash.com/photo-1551537482-f2075a1d41f2?w=600&q=80',
            'https://images.unsplash.com/photo-1544022613-e87ca75a784a?w=600&q=80',
            'https://images.unsplash.com/photo-1495105787522-5334e3ffa0ef?w=600&q=80',
        ]
    },
    2: {
        id: 2,
        productName:   'Tas Ransel Eiger Original',
        category:      'Sepatu & Tas',
        price:         'Rp175.000',
        condition:     'Bekas Baik',
        sellerName:    'Siti Aisyah',
        sellerHandle:  '@siti.aisyah',
        pelapor:       'Fajar Ramadhan, @fajar.ramadhan',
        dilaporkan:    '03 Juni 2026, 14:30 WIB',
        alasan:        'Seller tidak merespons pesan selama lebih dari 5 hari setelah pembayaran dilakukan.',
        status:        'ditindaklanjuti',
        peringatan:    'Anda mendapatkan peringatan dari admin SeMart karena tidak merespons pembeli dalam waktu yang wajar. Harap segera konfirmasi setiap transaksi dalam 1x24 jam. Pelanggaran berulang dapat mengakibatkan pembekuan akun.',
        images: [
            'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&q=80',
            'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?w=600&q=80',
        ]
    },
    3: {
        id: 3,
        productName:   'Kalkulator Casio fx-991EX',
        category:      'Elektronik',
        price:         'Rp85.000',
        condition:     'Bekas Seperti Baru',
        sellerName:    'Budi Santoso',
        sellerHandle:  '@budi.santoso',
        pelapor:       'Nabila Putri, @nabila.putri',
        dilaporkan:    '01 Juni 2026, 11:05 WIB',
        alasan:        'Laporan dianggap tidak valid karena tidak disertai bukti pendukung yang cukup.',
        status:        'ditolak',
        peringatan:    null,
        images: [
            'https://images.unsplash.com/photo-1564466809058-bf4114d55352?w=600&q=80',
            'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?w=600&q=80',
        ]
    },
    4: {
        id: 4,
        productName:   'Buku Atomic Habits',
        category:      'Buku',
        price:         'Rp90.000',
        condition:     'Bekas Layak Pakai',
        sellerName:    'Dewi Lestari',
        sellerHandle:  '@dewi.lestari',
        pelapor:       'Clara Renata, @clara.renata',
        dilaporkan:    '28 Mei 2026, 16:22 WIB',
        alasan:        'Harga yang diminta lebih tinggi dari yang tertera di listing setelah pembeli menghubungi seller.',
        status:        'menunggu',
        peringatan:    null,
        images: [
            'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=600&q=80',
            'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=600&q=80',
        ]
    }
};

// =============================================
// STATE
// =============================================
let activeId        = 1;
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
        document.getElementById('btnTindak').addEventListener('click', () => {
            document.getElementById('peringatanForm').classList.add('visible');
            document.getElementById('peringatanTextarea').focus();
            document.getElementById('peringatanForm').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        });

        // Event: Kirim Peringatan → validasi → modal konfirmasi
        document.getElementById('btnKirimPeringatan').addEventListener('click', () => {
            const ta = document.getElementById('peringatanTextarea');
            const val = ta.value.trim();
            if (!val) {
                ta.classList.add('error');
                ta.focus();
                setTimeout(() => ta.classList.remove('error'), 2000);
                return;
            }
            pendingWarning = val;
            pendingAction  = 'tindaklanjuti';
            document.getElementById('modalTindakSellerName').textContent  = d.sellerName;
            document.getElementById('modalTindakProductName').textContent = d.productName;
            openModal('modalTindaklanjuti');
        });

        // Event: Tolak → modal konfirmasi
        document.getElementById('btnTolak').addEventListener('click', () => {
            pendingAction = 'tolak';
            document.getElementById('modalTolakProductName').textContent = d.productName;
            openModal('modalTolakLaporan');
        });

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

    // Action area
    renderActionArea(id);
}

// =============================================
// UPDATE STATUS DI TABEL & DATA
// =============================================
function updateRowStatus(id, newStatus) {
    reportData[id].status = newStatus;

    // Cari row
    const row = document.querySelector(`.report-row[data-id="${id}"]`);
    if (!row) return;

    const badge = row.querySelector('.status-badge');
    if (badge) {
        badge.className = `status-badge status-${newStatus}`;
        badge.textContent = statusLabel[newStatus];
    }
}

// =============================================
// CONFIRM TINDAKLANJUTI
// =============================================
document.getElementById('btnConfirmTindak').addEventListener('click', () => {
    if (pendingAction !== 'tindaklanjuti') return;

    // Simpan peringatan ke data
    reportData[activeId].peringatan = pendingWarning;
    updateRowStatus(activeId, 'ditindaklanjuti');

    closeAllModals();

    // Re-render action area dengan status baru
    renderActionArea(activeId);

    pendingAction  = null;
    pendingWarning = '';
});

// =============================================
// CONFIRM TOLAK
// =============================================
document.getElementById('btnConfirmTolak').addEventListener('click', () => {
    if (pendingAction !== 'tolak') return;

    updateRowStatus(activeId, 'ditolak');
    closeAllModals();
    renderActionArea(activeId);

    pendingAction = null;
});

// =============================================
// TABLE ROW CLICK 
// =============================================
document.getElementById('reportTableBody').addEventListener('click', (e) => {
    const btn = e.target.closest('.btn-detail');
    if (!btn) return;

    const id = parseInt(btn.dataset.id);

    document.querySelectorAll('.report-row').forEach(r => r.classList.remove('active-row'));
    btn.closest('.report-row').classList.add('active-row');

    document.querySelectorAll('.btn-detail').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    loadDetail(id);
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
        if (target) document.getElementById(target).classList.remove('open');
        document.body.style.overflow = '';
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

if (adminToggle) {
    adminToggle.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = adminMenu.classList.toggle('open');
        adminChevron.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
        adminToggle.setAttribute('aria-expanded', String(isOpen));
    });

    document.addEventListener('click', (e) => {
        if (!e.target.closest('#adminDropdown')) {
            adminMenu.classList.remove('open');
            adminChevron.style.transform = 'rotate(0deg)';
        }
    });
}

// =============================================
// INIT
// =============================================
loadDetail(1);