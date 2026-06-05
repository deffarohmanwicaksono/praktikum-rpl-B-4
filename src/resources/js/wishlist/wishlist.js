document.addEventListener('DOMContentLoaded', () => {

    /* ==============================================
       CONSTANTS & STATE
       ============================================== */

    const STORAGE_KEY = 'seMartWishlist';

    const wishlistGrid      = document.getElementById('wishlistGrid');
    const wishlistCount     = document.getElementById('wishlistCount');
    const clearAllBtn       = document.getElementById('clearAllBtn');
    const wishlistEmptyFull = document.getElementById('wishlistEmptyFull');

    /* ==============================================
       HELPERS
       ============================================== */

    const getWishlist = () =>
        JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];

    const saveWishlist = (items) =>
        localStorage.setItem(STORAGE_KEY, JSON.stringify(items));

    /* ==============================================
       RENDER
       ============================================== */

    const renderWishlist = () => {
        const items = getWishlist();

        wishlistCount.textContent = items.length;
        clearAllBtn.disabled      = items.length === 0;

        wishlistGrid.innerHTML = '';

        if (items.length === 0) {
            wishlistGrid.style.display      = 'none';
            wishlistEmptyFull.style.display = 'flex';
            return;
        }

        // Grid sudah punya class .product-grid dari blade,
        // tinggal pastikan display tidak ter-override jadi none
        wishlistGrid.style.display      = '';
        wishlistEmptyFull.style.display = 'none';

        items.forEach((item) => {
            const card = buildCard(item);
            wishlistGrid.appendChild(card);
        });
    };

    const buildCard = (item) => {
        const { name, price, condition, image } = item;

        const card = document.createElement('div');
        card.className = 'product-card';

        card.innerHTML = `
            <div class="card-img-wrap">
                <img
                    class="card-img"
                    src="${escapeAttr(image)}"
                    alt="${escapeAttr(name)}"
                    loading="lazy"
                >
                <button
                    class="wishlist-btn active"
                    data-name="${escapeAttr(name)}"
                    aria-label="Hapus dari wishlist"
                >
                    <i class="bi bi-heart-fill"></i>
                </button>
            </div>

            <div class="card-body-custom">
                <p class="product-name">${escapeHtml(name)}</p>
                <p class="product-price">${escapeHtml(price)}</p>
                <span class="condition-badge">${escapeHtml(condition)}</span>
            </div>

            <button
                class="card-remove-btn"
                data-name="${escapeAttr(name)}"
                aria-label="Hapus produk dari wishlist"
            >
                <i class="bi bi-trash"></i>
                Hapus
            </button>
        `;

        // Klik "Hapus" → hapus dari wishlist
        card
            .querySelector('.card-remove-btn')
            .addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                removeItem(name);
            });

        return card;
    };

    /* ==============================================
       REMOVE ITEM
       ============================================== */

    const removeItem = (name) => {
        const updated = getWishlist().filter((item) => item.name !== name);
        saveWishlist(updated);
        renderWishlist();
    };

    /* ==============================================
       CLEAR ALL
       ============================================== */

    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', () => {
            if (getWishlist().length === 0) return;

            saveWishlist([]);
            renderWishlist();
        });
    }

    /* ==============================================
       ESCAPE UTILITIES
       ============================================== */

    const escapeHtml = (str = '') =>
        String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');

    const escapeAttr = (str = '') =>
        String(str).replace(/"/g, '&quot;');

    /* ==============================================
       INIT
       ============================================== */

    renderWishlist();
});