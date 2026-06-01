document.addEventListener('DOMContentLoaded', () => {

    // =============================================
    // PRICE INPUT — format rupiah & hitung selisih
    // =============================================
    const agreedPriceInput = document.getElementById('agreedPrice');
    const priceDiffEl      = document.getElementById('priceDiff');
    
    // Mengambil nilai listingPrice dinamis dari window yang di-inject via Blade
    const LISTING_PRICE    = window.purchaseData ? window.purchaseData.listingPrice : 7500000;

    agreedPriceInput.addEventListener('input', () => {
        let raw = agreedPriceInput.value.replace(/\D/g, '');
        const num = parseInt(raw) || 0;
        agreedPriceInput.value = num ? num.toLocaleString('id-ID') : '';
        const diff = num - LISTING_PRICE;
        
        if (diff === 0) {
            priceDiffEl.textContent = 'Sama dengan harga listing';
            priceDiffEl.className = 'price-diff neutral';
        } else if (diff < 0) {
            priceDiffEl.textContent = `–Rp ${Math.abs(diff).toLocaleString('id-ID')}`;
            priceDiffEl.className = 'price-diff negative';
        } else {
            priceDiffEl.textContent = `+Rp ${diff.toLocaleString('id-ID')}`;
            priceDiffEl.className = 'price-diff positive';
        }
    });

    // =============================================
    // DURATION OPTIONS
    // =============================================
    const durationLabels = {
        '15': '15 Menit', '30': '30 Menit', '60': '1 Jam',
        '180': '3 Jam', '360': '6 Jam', '720': '12 Jam', '1440': '24 Jam'
    };

    document.querySelectorAll('.duration-option').forEach(opt => {
        opt.addEventListener('click', () => {
            document.querySelectorAll('.duration-option').forEach(o => o.classList.remove('selected'));
            opt.classList.add('selected');
            opt.querySelector('input').checked = true;
            updateDeadlinePreview(opt.querySelector('input').value);
        });
    });

    function updateDeadlinePreview(minutes) {
        const now = new Date();
        now.setMinutes(now.getMinutes() + parseInt(minutes));
        const opts = { day: 'numeric', month: 'long', year: 'numeric',
                       hour: '2-digit', minute: '2-digit', hour12: false };
        document.getElementById('deadlinePreview').textContent =
            now.toLocaleDateString('id-ID', opts) + ' WIB';
    }

    // Init preview default (3 Jam)
    updateDeadlinePreview('180');

    // =============================================
    // NOTE CHAR COUNTER
    // =============================================
    const noteTextarea = document.getElementById('sellerNote');
    noteTextarea.addEventListener('input', () => {
        document.getElementById('noteCharCount').textContent = noteTextarea.value.length;
    });

    // =============================================
    // INFO COLLAPSIBLE
    // =============================================
    const infoToggleBtn    = document.getElementById('infoToggleBtn');
    const infoCollapseBody = document.getElementById('infoCollapseBody');
    const infoChevron      = document.getElementById('infoChevron');

    infoToggleBtn.addEventListener('click', () => {
        const isOpen = infoCollapseBody.classList.toggle('collapsed');
        infoChevron.style.transform = isOpen ? 'rotate(180deg)' : 'rotate(0deg)';
        infoToggleBtn.setAttribute('aria-expanded', String(!isOpen));
    });

    // =============================================
    // PAYMENT METHOD MODAL (FULL CRUD LOGIC)
    // =============================================
    const paymentMethodModal = document.getElementById('paymentMethodModal');
    const closeMethodModal   = document.getElementById('closeMethodModal');
    const cancelMethodModal  = document.getElementById('cancelMethodModal');
    
    const methodTypeInput     = document.getElementById('methodType');
    const methodProviderInput = document.getElementById('methodProvider');
    const methodAccountInput  = document.getElementById('methodAccount');
    const methodOwnerInput    = document.getElementById('methodOwner');
    const saveMethodBtn       = document.getElementById('saveMethodBtn');
    const paymentMethodList   = document.getElementById('paymentMethodList');

    let editingMethodId = null;

    // Attach ke window agar bisa dipanggil dari inline onclick HTML
    window.openAddModal = function() {
        editingMethodId = null;
        document.getElementById('modalMethodTitle').textContent = 'Tambah Metode Pembayaran';
        
        methodTypeInput.value     = '';
        methodProviderInput.value = '';
        methodAccountInput.value  = '';
        
        paymentMethodModal.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    window.openEditModal = function(id) {
        editingMethodId = id;
        document.getElementById('modalMethodTitle').textContent = 'Edit Metode Pembayaran';
        
        const row = document.querySelector(`.pm-row[data-id="${id}"]`);
        if (row) {
            const typeLabelText = row.querySelector('.pm-type-label').textContent; 
            const accountValText = row.querySelector('.pm-detail-row:nth-child(2) .pm-detail-val').textContent;
            const ownerValText = row.querySelector('.pm-detail-row:nth-child(3) .pm-detail-val').textContent;
            
            if (typeLabelText.includes('Transfer Bank')) {
                methodTypeInput.value = 'bank';
            } else {
                methodTypeInput.value = 'ewallet';
            }
            
            const providerName = typeLabelText.split('–')[1] ? typeLabelText.split('–')[1].trim() : '';
            methodProviderInput.value = providerName;
            methodAccountInput.value = accountValText;
            methodOwnerInput.value = ownerValText;
        }

        paymentMethodModal.classList.add('open');
        document.body.style.overflow = 'hidden';
    };

    window.deleteMethod = function(id) {
        const row = document.querySelector(`.pm-row[data-id="${id}"]`);
        if (row) { 
            row.style.animation = 'fadeOut 0.25s ease forwards'; 
            setTimeout(() => {
                row.remove();
                showToast('Metode pembayaran dihapus');
            }, 250); 
        }
    };

    [closeMethodModal, cancelMethodModal].forEach(btn => {
        btn.addEventListener('click', () => {
            paymentMethodModal.classList.remove('open');
            document.body.style.overflow = '';
        });
    });

    saveMethodBtn.addEventListener('click', () => {
        const type = methodTypeInput.value;
        const provider = methodProviderInput.value.trim();
        const account = methodAccountInput.value.trim();
        const owner = methodOwnerInput.value.trim();

        if (!type || !provider || !account || !owner) {
            alert('Mohon isi semua field data yang bertanda bintang (*)');
            return;
        }

        const typeLabel = type === 'bank' ? 'Transfer Bank' : 'E-Wallet';
        const keyLabel = type === 'bank' ? 'No. Rekening' : 'No. HP';
        const iconClass = type === 'bank' ? 'bi-bank2' : 'bi-phone';
        const modifierClass = type === 'bank' ? 'pm-icon--bank' : 'pm-icon--ewallet';

        const rowInnerContent = `
            <div class="pm-left">
                <div class="pm-type-icon ${modifierClass}">
                    <i class="bi ${iconClass}"></i>
                </div>
                <div class="pm-info">
                    <span class="pm-type-label">${typeLabel} – ${provider}</span>
                    <div class="pm-detail-row">
                        <span class="pm-detail-key">${keyLabel}</span>
                        <span class="pm-detail-val">${account}</span>
                    </div>
                    <div class="pm-detail-row">
                        <span class="pm-detail-key">a/n</span>
                        <span class="pm-detail-val">${owner}</span>
                    </div>
                </div>
            </div>
            <div class="pm-actions">
                <button class="pm-btn pm-btn--edit" onclick="openEditModal('${editingMethodId || ''}')">
                    <i class="bi bi-pencil"></i> Edit
                </button>
                <button class="pm-btn pm-btn--delete" onclick="deleteMethod('${editingMethodId || ''}')">
                    <i class="bi bi-trash3"></i> Hapus
                </button>
            </div>
        `;

        if (editingMethodId) {
            const row = document.querySelector(`.pm-row[data-id="${editingMethodId}"]`);
            if (row) {
                row.innerHTML = rowInnerContent;
                row.querySelector('.pm-btn--edit').setAttribute('onclick', `openEditModal('${editingMethodId}')`);
                row.querySelector('.pm-btn--delete').setAttribute('onclick', `deleteMethod('${editingMethodId}')`);
            }
            showToast('Metode pembayaran diperbarui');
        } else {
            const uniqueId = 'pm_' + Date.now();
            const newRow = document.createElement('div');
            newRow.className = 'pm-row';
            newRow.setAttribute('data-id', uniqueId);
            newRow.innerHTML = rowInnerContent;
            
            newRow.querySelector('.pm-btn--edit').setAttribute('onclick', `openEditModal('${uniqueId}')`);
            newRow.querySelector('.pm-btn--delete').setAttribute('onclick', `deleteMethod('${uniqueId}')`);
            
            paymentMethodList.appendChild(newRow);
            showToast('Metode pembayaran ditambahkan');
        }

        paymentMethodModal.classList.remove('open');
        document.body.style.overflow = '';
    });

    // =============================================
    // CONFIRM SEND MODAL
    // =============================================
    const confirmSendModal = document.getElementById('confirmSendModal');
    const successModal     = document.getElementById('successModal');

    document.getElementById('submitLinkBtn').addEventListener('click', () => {
        const priceRaw = agreedPriceInput.value || '7.200.000';
        document.getElementById('confirmPrice').textContent = 'Rp ' + priceRaw;
        const selDur = document.querySelector('.duration-option.selected input');
        document.getElementById('confirmDuration').textContent = durationLabels[selDur.value] || '3 Jam';
        
        confirmSendModal.classList.add('open');
        document.body.style.overflow = 'hidden';
    });

    document.getElementById('cancelSendBtn').addEventListener('click', () => {
        confirmSendModal.classList.remove('open');
        document.body.style.overflow = '';
    });
    document.getElementById('closeConfirmModal').addEventListener('click', () => {
        confirmSendModal.classList.remove('open');
        document.body.style.overflow = '';
    });

    document.getElementById('confirmSendBtn').addEventListener('click', () => {
        confirmSendModal.classList.remove('open');
        successModal.classList.add('open');
    });

    document.getElementById('backToChatBtn').addEventListener('click', () => {
        successModal.classList.remove('open');
        document.body.style.overflow = '';
    });

    // Close modals on overlay click + ESC
    [paymentMethodModal, confirmSendModal, successModal].forEach(m => {
        m.addEventListener('click', e => { 
            if (e.target === m) { 
                m.classList.remove('open'); 
                document.body.style.overflow = ''; 
            } 
        });
    });
    
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            [paymentMethodModal, confirmSendModal, successModal].forEach(m => { m.classList.remove('open'); });
            document.body.style.overflow = '';
        }
    });

    // =============================================
    // TOAST
    // =============================================
    function showToast(msg) {
        const t = document.getElementById('toastContainer');
        document.getElementById('toastMsg').textContent = msg;
        t.classList.add('show');
        clearTimeout(t._t);
        t._t = setTimeout(() => t.classList.remove('show'), 2800);
    }
});