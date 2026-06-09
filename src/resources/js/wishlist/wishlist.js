document.addEventListener('DOMContentLoaded', () => {
    const wishlistGrid = document.getElementById('wishlistGrid');
    const wishlistEmptyFull = document.getElementById('wishlistEmptyFull');
    const clearAllBtn = document.getElementById('clearAllBtn');
    const wishlistCount = document.getElementById('wishlistCount');

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    const checkEmptyState = () => {
        const remainingCards = document.querySelectorAll('.wishlist-card-wrapper');
        if (remainingCards.length === 0) {
            if (wishlistGrid) wishlistGrid.style.display = 'none';
            if (clearAllBtn) clearAllBtn.style.display = 'none';
            if (wishlistEmptyFull) wishlistEmptyFull.style.display = 'flex';
        } else {
            if (wishlistCount) wishlistCount.textContent = remainingCards.length;
        }
    };

    // ==============================================
    // HAPUS SATU ITEM (SINGLE REMOVE)
    // ==============================================
    document.querySelectorAll('.backend-remove-btn').forEach(button => {
        button.addEventListener('click', async (e) => {
            e.preventDefault();
            const wrapper = button.closest('.wishlist-card-wrapper');
            const productId = wrapper.getAttribute('data-product-id');

            if (!productId) return;

            button.disabled = true;

            try {
                const response = await fetch(`${window.wishlistRoutes.baseUrl}/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    // Animasi hapus elemen dari layar secara visual
                    wrapper.style.opacity = '0';
                    wrapper.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        wrapper.remove();
                        checkEmptyState();
                    }, 300);
                }
            } catch (error) {
                console.error('Gagal menghapus item:', error);
                button.disabled = false;
            }
        });
    });

    // ==============================================
    // 2. HAPUS SEMUA (CLEAR ALL)
    // ==============================================
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', async () => {
            if (!confirm('Apakah kamu yakin ingin mengosongkan seluruh wishlist?')) return;

            clearAllBtn.disabled = true;

            try {
                const response = await fetch(window.wishlistRoutes.clearAll, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (result.success) {
                    if (wishlistGrid) {
                        wishlistGrid.style.opacity = '0';
                        setTimeout(() => {
                            wishlistGrid.innerHTML = '';
                            checkEmptyState();
                        }, 300);
                    }
                }
            } catch (error) {
                console.error('Gagal mengosongkan wishlist:', error);
                clearAllBtn.disabled = false;
            }
        });
    }
});