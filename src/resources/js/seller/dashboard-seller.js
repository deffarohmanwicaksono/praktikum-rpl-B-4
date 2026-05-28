document.addEventListener('DOMContentLoaded', () => {

    // =============================================
    // ACTION BUTTONS: HAPUS CONFIRMATION
    // =============================================
    document.querySelectorAll('.btn-hapus').forEach(btn => {

        btn.addEventListener('click', e => {

            const row = e.target.closest('.table-row');

            const name = row
                .querySelector('.product-cell-name')
                .textContent;

            const isConfirmed = confirm(
                `Hapus "${name}" dari daftar barang Anda?`
            );

            if (!isConfirmed) return;

            row.style.opacity = '0';
            row.style.transform = 'translateX(20px)';
            row.style.transition =
                'opacity 0.3s ease, transform 0.3s ease';

            setTimeout(() => {
                row.remove();
            }, 300);
        });
    });

    // =============================================
    // ACTION BUTTONS: TUTUP JADI SOLD OUT
    // =============================================
    document.querySelectorAll('.btn-tutup').forEach(btn => {

        btn.addEventListener('click', function (e) {

            e.preventDefault();

            const isConfirmed = confirm(
                'Ubah status barang ini menjadi Sold Out?'
            );

            if (!isConfirmed) return;

            const tableRow = this.closest('tr');

            const statusBadge =
                tableRow.querySelector('.status-badge');

            if (statusBadge) {
                statusBadge.textContent = 'Sold Out';

                statusBadge.className =
                    'status-badge sold-out';
            }

            this.remove();
        });
    });
});