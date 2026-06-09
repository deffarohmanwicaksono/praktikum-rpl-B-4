document.addEventListener('DOMContentLoaded', () => {
    const wishlistGrid      = document.getElementById('wishlistGrid');
    const wishlistEmptyFull = document.getElementById('wishlistEmptyFull');
    const clearAllBtn       = document.getElementById('clearAllBtn');
    const wishlistCount     = document.getElementById('wishlistCount');
    const csrfToken         = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // ==============================================
    // CEK EMPTY STATE
    // ==============================================
    const checkEmptyState = () => {
        const remainingItems = document.querySelectorAll('.product-card');
        if (remainingItems.length === 0) {
            if (wishlistGrid)      wishlistGrid.style.display      = 'none';
            if (clearAllBtn)       clearAllBtn.style.display       = 'none';
            if (wishlistEmptyFull) wishlistEmptyFull.style.display = 'flex';
        } else {
            if (wishlistCount) wishlistCount.textContent = remainingItems.length;
        }
    };

    // ==============================================
    // SETUP TOMBOL HATI
    // ==============================================
    const setupWishlistBtn = (heartBtn) => {
        const productId = heartBtn.getAttribute('data-product-id');
        if (!productId) return;

        const icon = heartBtn.querySelector('i');
        if (icon) icon.className = 'bi bi-heart-fill';
        heartBtn.classList.add('active');

        const newBtn = heartBtn.cloneNode(true);
        heartBtn.parentNode.replaceChild(newBtn, heartBtn);

        newBtn.addEventListener('click', async (e) => {
            e.preventDefault();
            e.stopPropagation();

            const card = newBtn.closest('.product-card');
            if (card) card.style.opacity = '0.5';

            try {
                const response = await fetch(`/wishlist/${productId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                });

                const result = await response.json();

                if (result.success) {
                    if (card) {
                        card.style.transition = 'all 0.3s ease';
                        card.style.transform  = 'scale(0.9)';
                        card.style.opacity    = '0';
                    }
                    setTimeout(() => {
                        // Hapus .product-card atau parent terdekat di grid
                        const wrapper = card?.parentElement ?? card;
                        wrapper?.remove();
                        checkEmptyState();
                    }, 300);
                } else {
                    if (card) card.style.opacity = '1';
                }
            } catch (err) {
                console.error('Gagal menghapus item:', err);
                if (card) card.style.opacity = '1';
            }
        });
    };

    document.querySelectorAll('.wishlist-btn').forEach(setupWishlistBtn);

    // ==============================================
    // HAPUS SEMUA
    // ==============================================
    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', async () => {
            if (!confirm('Apakah kamu yakin ingin mengosongkan seluruh wishlist?')) return;

            clearAllBtn.disabled = true;

            try {
                const response = await fetch('/wishlist-clear', {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                });

                const result = await response.json();

                if (result.success) {
                    if (wishlistGrid) {
                        wishlistGrid.style.transition = 'opacity 0.3s ease';
                        wishlistGrid.style.opacity    = '0';
                        setTimeout(() => {
                            wishlistGrid.innerHTML = '';
                            checkEmptyState();
                        }, 300);
                    }
                }
            } catch (err) {
                console.error('Gagal mengosongkan wishlist:', err);
                clearAllBtn.disabled = false;
            }
        });
    }
});