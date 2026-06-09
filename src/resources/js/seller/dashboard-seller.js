document.addEventListener('DOMContentLoaded', () => {

    // 1. SELECTORS
    const searchInput = document.getElementById('searchProductInput');
    const filterSelect = document.getElementById('filterStatusSelect');
    const rows = document.querySelectorAll('.product-row');
    const emptyStateRow = document.getElementById('emptyStateRow');

    // 2. FILTER & SEARCH LOGIC
    const filterTable = () => {
        const searchTerm = searchInput.value.toLowerCase();
        const filterValue = filterSelect.value;
        let visibleCount = 0;

        rows.forEach(row => {
            // Ambil data dari baris
            const name = row.querySelector('.product-name-text').textContent.toLowerCase();
            const statusClass = row.dataset.statusClass; // Mengambil dari atribut data-status-class

            // Cek kecocokan
            const matchesSearch = name.includes(searchTerm);
            const matchesFilter = (filterValue === "" || statusClass === filterValue);

            // Tampilkan atau sembunyikan baris
            if (matchesSearch && matchesFilter) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        // Tampilkan pesan "Tidak ada produk" jika hasil pencarian kosong
        if (emptyStateRow) {
            emptyStateRow.style.display = visibleCount === 0 ? '' : 'none';
        }
    };

    // Event Listener
    searchInput.addEventListener('input', filterTable);
    filterSelect.addEventListener('change', filterTable);


    // 3. ACTION BUTTON: HAPUS
    // Menggunakan Event Delegation agar tombol hapus tetap berfungsi 
    // meski daftar produk berubah (setelah filter)
    document.querySelector('.barang-table-new').addEventListener('click', (e) => {
        if (e.target.closest('.btn-hapus-produk')) {
            const btn = e.target.closest('.btn-hapus-produk');
            const row = btn.closest('.product-row');
            const name = row.querySelector('.product-name-text').textContent;

            const isConfirmed = confirm(`Hapus "${name}" dari daftar barang Anda?`);

            if (!isConfirmed) return;

            row.style.opacity = '0';
            row.style.transform = 'translateX(20px)';
            row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

            setTimeout(() => {
                row.remove();
                // Opsional: Cek lagi apakah setelah dihapus tabel jadi kosong
                filterTable(); 
            }, 300);
        }
    });
});