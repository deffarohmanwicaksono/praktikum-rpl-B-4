// =============================================
// DATA: Product detail per row
// =============================================
const productData = {
    1: {
        name:      'Jaket Denim Pria',
        price:     'Rp120.000',
        seller:    'Andi Pratama',
        handle:    '@andi.pratama',
        kategori:  'Pakaian',
        kondisi:   'Bekas Seperti Baru',
        diajukan:  '12 Mei 2024, 14:30 WIB',
        deskripsi: 'Jaket denim warna biru dongker. Kondisi masih sangat baik, bahan tebal dan nyaman dipakai.',
        images: [
            'https://images.unsplash.com/photo-1551537482-f2075a1d41f2?w=600&q=80',
            'https://images.unsplash.com/photo-1544022613-e87ca75a784a?w=600&q=80',
            'https://images.unsplash.com/photo-1495105787522-5334e3ffa0ef?w=600&q=80',
            'https://images.unsplash.com/photo-1591047139829-d91aecb6caea?w=600&q=80'
        ]
    },
    2: {
        name:      'Tas Ransel Eiger Original',
        price:     'Rp175.000',
        seller:    'Siti Aisyah',
        handle:    '@siti.aisyah',
        kategori:  'Tas',
        kondisi:   'Bekas Baik',
        diajukan:  '12 Mei 2024, 10:15 WIB',
        deskripsi: 'Tas ransel Eiger original kapasitas 30L. Tidak ada kerusakan, semua resleting berfungsi baik.',
        images: [
            'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&q=80',
            'https://images.unsplash.com/photo-1622560480605-d83c853bc5c3?w=600&q=80',
            'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=600&q=80',
            'https://images.unsplash.com/photo-1491637639811-60e2756cc1c7?w=600&q=80'
        ]
    },
    3: {
        name:      'Kalkulator Casio fx-991EX',
        price:     'Rp85.000',
        seller:    'Budi Santoso',
        handle:    '@budi.santoso',
        kategori:  'Elektronik',
        kondisi:   'Bekas Seperti Baru',
        diajukan:  '11 Mei 2024, 16:45 WIB',
        deskripsi: 'Kalkulator scientific Casio fx-991EX. Semua fungsi normal, layar bersih, tidak ada goresan.',
        images: [
            'https://images.unsplash.com/photo-1564466809058-bf4114d55352?w=600&q=80',
            'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?w=600&q=80',
            'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=600&q=80',
            'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=600&q=80'
        ]
    },
    4: {
        name:      'Buku Atomic Habits',
        price:     'Rp90.000',
        seller:    'Dewi Lestari',
        handle:    '@dewi.lestari',
        kategori:  'Buku',
        kondisi:   'Bekas Layak Pakai',
        diajukan:  '10 Mei 2024, 09:20 WIB',
        deskripsi: 'Buku Atomic Habits karya James Clear edisi terjemahan. Kondisi baik, tidak ada coretan, sampul lengkap.',
        images: [
            'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=600&q=80',
            'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=600&q=80',
            'https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=600&q=80',
            'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?w=600&q=80'
        ]
    }
};

let activeId      = 1;   // currently selected row
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

    // Reset alasan textarea
    document.getElementById('alasanInput').value = '';
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
document.getElementById('verifTableBody').addEventListener('click', (e) => {
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
    document.getElementById('alasanSection').classList.remove('hidden');
});

// =============================================
// SETUJUI button
// =============================================
document.getElementById('btnSetujui').addEventListener('click', () => {
    const name = productData[activeId]?.name || '';
    document.getElementById('modalSetujuiName').textContent = name;
    openModal('modalSetujui');
});

// =============================================
// TOLAK button → show alasan + open modal
// =============================================
document.getElementById('btnTolak').addEventListener('click', () => {
    const alasan = document.getElementById('alasanInput').value.trim();
    if (!alasan) {
        // Highlight textarea and scroll to it
        const ta = document.getElementById('alasanInput');
        ta.classList.add('error');
        ta.focus();
        ta.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => ta.classList.remove('error'), 2000);
        return;
    }
    const name = productData[activeId]?.name || '';
    document.getElementById('modalTolakName').textContent = name;
    openModal('modalTolak');
});

// Confirm Setujui
document.querySelector('.btn-modal-setujui').addEventListener('click', () => {
    closeAllModals();
    removeActiveRow();
});

// Confirm Tolak
document.querySelector('.btn-modal-tolak').addEventListener('click', () => {
    closeAllModals();
    removeActiveRow();
});

function removeActiveRow() {
    const row = document.querySelector('.verif-row.active-row');
    if (row) {
        row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        row.style.opacity = '0';
        row.style.transform = 'translateX(12px)';
        setTimeout(() => row.remove(), 300);
    }
}

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

// Close buttons (data-modal attribute)
document.querySelectorAll('.modal-close-btn, .btn-modal-cancel').forEach(btn => {
    btn.addEventListener('click', () => {
        const target = btn.dataset.modal;
        document.getElementById(target).classList.remove('open');
        document.body.style.overflow = '';
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

// =============================================
// INIT: load first item on page load
// =============================================
loadDetail(1);