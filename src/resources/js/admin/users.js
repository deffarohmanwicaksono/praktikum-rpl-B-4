// ==========================================================================
// SeMart Users Management Page Interactions
// ==========================================================================

document.addEventListener('DOMContentLoaded', () => {
    // Selector Elemen Utama Toolbar & Tabel
    const tableBody = document.getElementById('usersTableBody');
    const searchInput = document.getElementById('searchInput');
    const filterStatus = document.getElementById('filterStatus');
    const filterRole = document.getElementById('filterRole');
    const tableInfoText = document.getElementById('tableInfoText');
    const detailCard = document.getElementById('detailCard');

    // Selector Elemen Detail Panel Kanan
    const detailUserName = document.getElementById('detailUserName');
    const detailUserEmail = document.getElementById('detailUserEmail');
    const detailUserRole = document.getElementById('detailUserRole');
    const detailUserStatus = document.getElementById('detailUserStatus');
    const detailUserPhone = document.getElementById('detailUserPhone');
    const detailUserJoined = document.getElementById('detailUserJoined');

    // Selector Elemen Modal 
    const modalStatusUser = document.getElementById('modalStatusUser');
    const modalStatusTitle = document.getElementById('modalStatusTitle');
    const modalStatusIcon = document.getElementById('modalStatusIcon');
    const modalActionText = document.getElementById('modalActionText');
    const modalUserName = document.getElementById('modalUserName');
    const confirmStatusBtn = document.getElementById('confirmStatusBtn');

    let targetUserRow = null;
    let currentAction = ''; // 'blokir' atau 'aktifkan'

    // ==========================================================================
    // FUNGSI 1: Update Panel Detail Kanan
    // ==========================================================================
    function updateDetailPanel(data) {
        if (!data) return;

        if (detailUserName) detailUserName.textContent = data.name;
        if (detailUserEmail) detailUserEmail.textContent = data.email;
        if (detailUserPhone) detailUserPhone.textContent = data.phone;
        if (detailUserJoined) detailUserJoined.textContent = data.joined;

        // Render Multi-Badge Role
        if (detailUserRole) {
            let roleHtml = '<div class="role-badges-wrap text-left">';
            data.roles.forEach(role => {
                roleHtml += `<span class="role-badge role-${role.toLowerCase()}">${role}</span>`;
            });
            roleHtml += '</div>';
            detailUserRole.innerHTML = roleHtml;
        }

        // Render Status Badge
        if (detailUserStatus) {
            detailUserStatus.innerHTML = `<span class="status-badge ${data.status_class}">${data.status}</span>`;
        }

        // Animasi Fade-In Panel Kartu Detail
        if (detailCard) {
            detailCard.style.animation = 'none';
            void detailCard.offsetHeight; 
            detailCard.style.animation = 'cardFadeIn 0.35s ease both';
        }
    }

    // ==========================================================================
    // FUNGSI 2: Manajemen Highlight Baris Aktif
    // ==========================================================================
    function setActiveRow(selectedRow) {
        const allRows = tableBody.querySelectorAll('.user-row');
        allRows.forEach(row => row.classList.remove('active-row'));

        const allButtons = tableBody.querySelectorAll('.btn-detail');
        allButtons.forEach(btn => btn.classList.remove('active'));

        selectedRow.classList.add('active-row');
        const activeBtn = selectedRow.querySelector('.btn-detail');
        if (activeBtn) activeBtn.classList.add('active');
    }

    // ==========================================================================
    // FUNGSI 3: Multi-Filter Client-Side (Search + Status + Role)
    // ==========================================================================
    function filterUsers() {
        const searchQuery = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const statusQuery = filterStatus ? filterStatus.value.toLowerCase() : '';
        const roleQuery = filterRole ? filterRole.value.toLowerCase() : '';
        
        const rows = tableBody.querySelectorAll('.user-row');
        let visibleCount = 0;
        let firstVisibleRow = null;

        rows.forEach(row => {
            try {
                const userData = JSON.parse(row.dataset.user);
                
                // 1. Filter Search (Nama & Email)
                const matchesSearch = 
                    userData.name.toLowerCase().includes(searchQuery) ||
                    userData.email.toLowerCase().includes(searchQuery);

                // 2. Filter Dropdown Status
                const matchesStatus = statusQuery === '' || userData.status_class.includes(statusQuery);

                // 3. Filter Dropdown Role
                const matchesRole = roleQuery === '' || userData.roles.some(role => role.toLowerCase() === roleQuery);

                // Kombinasi Keberhasilan Filter
                if (matchesSearch && matchesStatus && matchesRole) {
                    row.style.display = '';
                    visibleCount++;
                    if (!firstVisibleRow) firstVisibleRow = row;
                } else {
                    row.style.display = 'none';
                }
            } catch (err) {
                row.style.display = '';
            }
        });

        // Ubah Teks Kuantitas Informasi Footer Tabel
        if (tableInfoText) {
            tableInfoText.textContent = `Menampilkan 1–${visibleCount} dari ${visibleCount} user`;
        }

        // Otomatis sorot data teratas yang berhasil difilter
        if (firstVisibleRow) {
            const data = JSON.parse(firstVisibleRow.dataset.user);
            setActiveRow(firstVisibleRow);
            updateDetailPanel(data);
        }
    }

    // Listener Input Penyaringan
    if (searchInput) {
        let typingTimer;
        searchInput.addEventListener('keyup', () => {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(filterUsers, 250);
        });
    }
    if (filterStatus) filterStatus.addEventListener('change', filterUsers);
    if (filterRole) filterRole.addEventListener('change', filterUsers);


    // ==========================================================================
    // FUNGSI 4: Modals & Klik Baris Tabel Delegation
    // ==========================================================================
    if (tableBody) {
        tableBody.addEventListener('click', (e) => {
            const targetRow = e.target.closest('.user-row');
            if (!targetRow) return;

            // Baca Data JSON Atribut Utama
            let userData = null;
            try {
                userData = JSON.parse(targetRow.dataset.user);
            } catch (error) {
                console.error("Gagal mem-parsing data user:", error);
                return;
            }

            const toggleBtn = e.target.closest('.btn-status-toggle');
            if (toggleBtn) {
                const userName = toggleBtn.dataset.name;
                const action = toggleBtn.dataset.action; 
                
                targetUserRow = targetRow;
                currentAction = action;
                modalUserName.textContent = userName;
                confirmStatusBtn.setAttribute('data-id', toggleBtn.dataset.id);
                
                if (action === 'blokir') {
                    modalStatusTitle.textContent = 'Konfirmasi Blokir Pengguna';
                    modalActionText.textContent = 'memblokir';
                    modalStatusIcon.className = 'modal-icon-wrap danger';
                    modalStatusIcon.innerHTML = '<i class="bi bi-lock-fill" style="color:#ef4444;"></i>';
                    confirmStatusBtn.className = 'btn-modal-submit bg-danger';
                    confirmStatusBtn.textContent = 'Ya, Blokir';
                } else {
                    modalStatusTitle.textContent = 'Konfirmasi Aktifkan Pengguna';
                    modalActionText.textContent = 'mengaktifkan kembali';
                    modalStatusIcon.className = 'modal-icon-wrap success';
                    modalStatusIcon.innerHTML = '<i class="bi bi-check-circle-fill" style="color:#166534;"></i>';
                    confirmStatusBtn.className = 'btn-modal-submit bg-success';
                    confirmStatusBtn.textContent = 'Ya, Aktifkan';
                }
                
                openModal('modalStatusUser');
                return;
            }

            // Default Klik Baris biasa: Ganti Konten Detail Sebelah Kanan
            setActiveRow(targetRow);
            updateDetailPanel(userData);
        });
    }

    // Handler Eksekusi Perubahan Status di Dalam Modal
    if (confirmStatusBtn) {
        confirmStatusBtn.addEventListener('click', () => {
            if (targetUserRow && currentAction) {
                const userId = confirmStatusBtn.getAttribute('data-id');
                const form = document.getElementById('formStatusUser');
                if (form && userId) {
                    form.action = `/admin/users/${userId}/toggle-status`;
                    form.submit();
                }
            }
            closeAllModals();
        });
    }

    // Core Helper Modals
    function openModal(id) {
        document.getElementById(id).classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeAllModals() {
        document.querySelectorAll('.modal-overlay').forEach(m => m.classList.remove('open'));
        document.body.style.overflow = '';
        targetUserRow = null;
        currentAction = '';
    }

    document.querySelectorAll('.modal-close-btn, .btn-modal-cancel').forEach(btn => {
        btn.addEventListener('click', closeAllModals);
    });

    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) closeAllModals();
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeAllModals();
    });
});