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
            const url = btn.dataset.url;

            const isConfirmed = confirm(`Hapus "${name}" dari daftar barang Anda?\nTindakan ini tidak dapat dibatalkan.`);

            if (!isConfirmed) return;

            // Submit the actual form
            const form = document.getElementById('formDeleteProduct');
            if (form && url) {
                // Tampilkan efek loading pada tombol hapus
                btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                btn.disabled = true;

                form.action = url;
                form.submit();
            } else {
                // Fallback (seharusnya tidak terjadi)
                row.remove();
                filterTable(); 
            }
        }
    });
});