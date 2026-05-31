// =============================================
// PAYMENT SELECTION
// =============================================

const payLabels = document.querySelectorAll('.pay-option');

const methodMap = {
    bca: 'Transfer Bank BCA',
    shopeepay: 'ShopeePay',
    gopay: 'GoPay',
    ovo: 'OVO',
    dana: 'DANA'
};

payLabels.forEach(label => {
    label.addEventListener('click', () => {
        payLabels.forEach(item => item.classList.remove('selected'));
        label.classList.add('selected');
        label.querySelector('input').checked = true;
    });
});

// =============================================
// COUNTDOWN TIMER (DYNAMIC VERSION)
// =============================================

// Mengambil data timestamp statis asli dari database lewat window.checkoutData di Blade
const expiredAt = window.checkoutData ? window.checkoutData.expiredAt : Date.now();

const purchaseLink = document.getElementById('purchaseLink');
const payBtn = document.getElementById('payBtn');

function pad(number) {
    return String(number).padStart(2, '0');
}

function tick() {
    const left = expiredAt - Date.now();

    // JIKA WAKTU HABIS
    if (left <= 0) {
        document.getElementById('cdHour').textContent = '00';
        document.getElementById('cdMin').textContent = '00';
        document.getElementById('cdSec').textContent = '00';

        document.querySelector('.cd-label').textContent = 'Waktu pembayaran habis';

        payBtn.disabled = true;
        payBtn.style.opacity = '.6';
        payBtn.style.cursor = 'not-allowed';

        if (purchaseLink) {
            purchaseLink.removeAttribute('href');
            purchaseLink.classList.add('disabled');
        }

        // Otomatis kick user kembali ke halaman chat jika waktu habis saat halaman terbuka
        alert('Waktu pembayaran telah habis!');
        window.location.href = '/chat'; 

        return;
    }

    // HITUNG SISA WAKTU
    const hours = Math.floor(left / 3600000);
    const minutes = Math.floor((left % 3600000) / 60000);
    const seconds = Math.floor((left % 60000) / 1000);

    document.getElementById('cdHour').textContent = pad(hours);
    document.getElementById('cdMin').textContent = pad(minutes);
    document.getElementById('cdSec').textContent = pad(seconds);

    // KONDISI DARURAT (SISA < 5 MENIT) -> JADI KELAP-KELIP MERAH
    const urgent = left < 5 * 60 * 1000;

    ['cdHour', 'cdMin', 'cdSec'].forEach(id => {
        document.getElementById(id).classList.toggle('urgent', urgent);
    });
}

tick();
const timerInterval = setInterval(tick, 1000);

// =============================================
// MODALS LOGIC
// =============================================

const proofModal = document.getElementById('proofModal');
const closeProofModal = document.getElementById('closeProofModal');
const successModal = document.getElementById('successModal');
const modalClose = document.getElementById('modalClose');

// OPEN PAYMENT PROOF MODAL
payBtn.addEventListener('click', () => {
    if (Date.now() > expiredAt) {
        alert('Waktu pembayaran telah habis');
        return;
    }

    proofModal.classList.add('open');
    document.body.style.overflow = 'hidden';
});

// CLOSE PAYMENT PROOF MODAL
function closeProof() {
    proofModal.classList.remove('open');
    document.body.style.overflow = '';
}

closeProofModal.addEventListener('click', closeProof);

proofModal.addEventListener('click', e => {
    if (e.target === proofModal) {
        closeProof();
    }
});

// =============================================
// IMAGE PREVIEW
// =============================================

const paymentProof = document.getElementById('paymentProof');
const proofPreview = document.getElementById('proofPreview');

paymentProof.addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = event => {
        proofPreview.innerHTML = `
            <img src="${event.target.result}" alt="Bukti Pembayaran">
        `;
    };
    reader.readAsDataURL(file);
});

// =============================================
// SUBMIT PAYMENT PROOF
// =============================================

document.getElementById('submitProof').addEventListener('click', () => {
    const file = paymentProof.files[0];

    if (!file) {
        alert('Silakan upload bukti pembayaran terlebih dahulu.');
        return;
    }

    closeProof();

    const selected = document.querySelector('.pay-option.selected');
    const method = methodMap[selected.dataset.method];

    document.getElementById('modalMethod').textContent = method;

    successModal.classList.add('open');
    document.body.style.overflow = 'hidden';

    // NANTI DI INTEGRASI BACKEND:
    // const formData = new FormData();
    // formData.append('payment_proof', file);
    // fetch('/api/checkout/submit', { method: 'POST', body: formData })
});

// =============================================
// SUCCESS MODAL
// =============================================

function closeSuccessModal() {
    successModal.classList.remove('open');
    document.body.style.overflow = '';
}

modalClose.addEventListener('click', closeSuccessModal);

successModal.addEventListener('click', e => {
    if (e.target === successModal) {
        closeSuccessModal();
    }
});

// =============================================
// GLOBAL ESC KEY LISTENER
// =============================================

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        closeProof();
        closeSuccessModal();
    }
});