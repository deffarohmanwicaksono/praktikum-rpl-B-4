// ==========================================================================
// SeMart Transactions Page Interactions
// ==========================================================================

document.addEventListener('DOMContentLoaded', () => {
    // Selector Elemen Utama Toolbar
    const tableBody = document.getElementById('transactionsTableBody');
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const filterDate = document.getElementById('filterDate');
    const tableInfoText = document.getElementById('tableInfoText');
    const detailCard = document.getElementById('detailCard');

    // Selector Elemen Detail di Panel Kanan
    const detailMainImg = document.getElementById('detailMainImg');
    const receiptPlaceholder = document.getElementById('receiptPlaceholder'); // Ditambahkan selector placeholder
    const detailProductName = document.getElementById('detailProductName');
    const detailProductPrice = document.getElementById('detailProductPrice');
    const detailBuyerName = document.getElementById('detailBuyerName');
    const detailBuyerHandle = document.getElementById('detailBuyerHandle');
    const detailSellerName = document.getElementById('detailSellerName');
    const detailSellerHandle = document.getElementById('detailSellerHandle');
    const detailMethod = document.getElementById('detailMethod');
    const detailDateTime = document.getElementById('detailDateTime');
    const detailStatus = document.getElementById('detailStatus');

    // ==========================================================================
    // FUNGSI 1: Update Panel Detail Kanan
    // ==========================================================================
    function updateDetailPanel(data) {
        if (!data) return;

        // Logika Pengaturan Tampilan Bukti Pembayaran vs Placeholder
        if (detailMainImg && receiptPlaceholder) {
            if (data.payment_receipt) {
                detailMainImg.src = data.payment_receipt;
                detailMainImg.alt = `Bukti Pembayaran - ${data.product_name}`;
                detailMainImg.style.display = 'block';
                receiptPlaceholder.style.display = 'none';
            } else {
                detailMainImg.src = '';
                detailMainImg.alt = '';
                detailMainImg.style.display = 'none';
                receiptPlaceholder.style.display = 'block';
            }
        }

        // Update data teks teks lainnya
        if (detailProductName) detailProductName.textContent = data.product_name;
        if (detailProductPrice) detailProductPrice.textContent = data.price;
        if (detailBuyerName) detailBuyerName.textContent = data.buyer_name;
        if (detailBuyerHandle) detailBuyerHandle.textContent = data.buyer_handle;
        if (detailSellerName) detailSellerName.textContent = data.seller_name;
        if (detailSellerHandle) detailSellerHandle.textContent = data.seller_handle;
        if (detailMethod) detailMethod.textContent = data.method_text;
        if (detailDateTime) detailDateTime.textContent = `${data.date}, ${data.time}`;

        if (detailStatus) {
            detailStatus.textContent = data.status;
            detailStatus.className = 'status-badge';
            detailStatus.classList.add(data.status_class);
        }

        // Trigger animasi fade-in kartu detail
        if (detailCard) {
            detailCard.style.animation = 'none';
            void detailCard.offsetHeight; 
            detailCard.style.animation = 'cardFadeIn 0.38s ease both';
        }
    }

    // ==========================================================================
    // FUNGSI 2: Manajemen Highlight Baris Aktif
    // ==========================================================================
    function setActiveRow(selectedRow) {
        const allRows = tableBody.querySelectorAll('.transaction-row');
        allRows.forEach(row => row.classList.remove('active-row'));

        const allButtons = tableBody.querySelectorAll('.btn-detail');
        allButtons.forEach(btn => btn.classList.remove('active'));

        selectedRow.classList.add('active-row');
        const activeBtn = selectedRow.querySelector('.btn-detail');
        if (activeBtn) activeBtn.classList.add('active');
    }

    // Event Delegation: Klik Baris Tabel
    if (tableBody) {
        tableBody.addEventListener('click', (e) => {
            const targetRow = e.target.closest('.transaction-row');
            if (!targetRow) return;

            try {
                const transactionData = JSON.parse(targetRow.dataset.transaction);
                setActiveRow(targetRow);
                updateDetailPanel(transactionData);
            } catch (error) {
                console.error("Gagal membaca data transaksi:", error);
            }

            const btnDetail = e.target.closest('.btn-detail');
            if (btnDetail) {
                btnDetail.style.transform = 'scale(0.95)';
                setTimeout(() => { btnDetail.style.transform = 'scale(1)'; }, 130);
            }
        });
    }

    // ==========================================================================
    // FUNGSI 3: Multi-Filter Client-Side (Search + Status + Tanggal)
    // ==========================================================================
    function filterTransactions() {
        const searchQuery = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const statusFilter = filterStatus ? filterStatus.value.toLowerCase() : '';
        const dateFilter = filterDate ? filterDate.value : '';
        
        const rows = tableBody.querySelectorAll('.transaction-row');
        let visibleCount = 0;
        let firstVisibleRow = null;

        rows.forEach(row => {
            try {
                const data = JSON.parse(row.dataset.transaction);
                
                // 1. Validasi Filter Teks (Search)
                const matchesSearch = 
                    data.product_name.toLowerCase().includes(searchQuery) ||
                    data.buyer_name.toLowerCase().includes(searchQuery) ||
                    data.seller_name.toLowerCase().includes(searchQuery);

                // 2. Validasi Filter Dropdown Status
                const matchesStatus = statusFilter === '' || data.status_class.includes(statusFilter);

                // 3. Validasi Filter Dropdown Tanggal
                const matchesDate = (() => {
                    if (dateFilter === '') return true;
                    
                    const txDate = new Date(data.date_raw);
                    const today = new Date();
                    
                    // Normalisasi jam/menit/detik menjadi 00:00 agar hitungan hari presisi
                    today.setHours(0, 0, 0, 0);
                    txDate.setHours(0, 0, 0, 0);
                    
                    // Hitung selisih hari
                    const diffTime = today - txDate;
                    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                    if (dateFilter === 'today') {
                        return diffDays === 0;
                    } else if (dateFilter === '7days') {
                        return diffDays >= 0 && diffDays <= 7;
                    } else if (dateFilter === '30days') {
                        return diffDays >= 0 && diffDays <= 30;
                    }
                    return true;
                })();

                // Gabungkan kondisi akhir: Baris harus lolos ketiga filter di atas
                if (matchesSearch && matchesStatus && matchesDate) {
                    row.style.display = ''; // Tampilkan
                    visibleCount++;
                    if (!firstVisibleRow) firstVisibleRow = row;
                } else {
                    row.style.display = 'none'; // Sembunyikan
                }
            } catch (err) {
                row.style.display = '';
            }
        });

        // Update info kuantitas di footer tabel
        if (tableInfoText) {
            tableInfoText.textContent = `Menampilkan 1–${visibleCount} dari ${visibleCount} transaksi`;
        }

        // Auto-select baris pertama yang lolos seleksi filter
        if (firstVisibleRow) {
            const data = JSON.parse(firstVisibleRow.dataset.transaction);
            setActiveRow(firstVisibleRow);
            updateDetailPanel(data);
        }
    }

    // Trigger Listener Filter & Search
    if (searchInput) {
        let typingTimer;
        searchInput.addEventListener('keyup', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(filterTransactions, 300);
        });
    }

    if (filterStatus) {
        filterStatus.addEventListener('change', filterTransactions);
    }
    
    if (filterDate) {
        filterDate.addEventListener('change', filterTransactions); // Mengaktifkan filter tanggal
    }
});