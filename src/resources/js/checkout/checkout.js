// =============================================
// PAYMENT SELECTION
// =============================================

const payLabels = document.querySelectorAll('.pay-option');
const selectedPaymentMethod = document.getElementById('selectedPaymentMethod');

payLabels.forEach(label => {
    label.addEventListener('click', () => {
        payLabels.forEach(item => item.classList.remove('selected'));
        label.classList.add('selected');
        
        const input = label.querySelector('input');
        input.checked = true;
        
        if (selectedPaymentMethod) {
            selectedPaymentMethod.value = input.value;
        }
    });
});

// =============================================
// COUNTDOWN TIMER (DYNAMIC VERSION)
// =============================================

// Mengambil data timestamp statis asli dari database lewat window.checkoutData di Blade
const expiredAt = window.checkoutData ? window.checkoutData.expiredAt : Date.now();

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

        if (payBtn) {
            payBtn.disabled = true;
            payBtn.style.opacity = '.6';
            payBtn.style.cursor = 'not-allowed';
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

// Validate submission
if (payBtn) {
    payBtn.addEventListener('click', (e) => {
        if (Date.now() > expiredAt) {
            e.preventDefault();
            alert('Waktu pembayaran telah habis');
            return;
        }
    });
}