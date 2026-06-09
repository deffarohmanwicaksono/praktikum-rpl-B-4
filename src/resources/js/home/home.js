document.addEventListener('DOMContentLoaded', () => {

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    function applyFilters(category, sort) {
        const url = new URL(window.location.href);

        if (category && category !== 'semua') {
            url.searchParams.set('category', category);
        } else {
            url.searchParams.delete('category');
        }

        if (sort && sort !== 'terbaru') {
            url.searchParams.set('sort', sort);
        } else {
            url.searchParams.delete('sort');
        }

        window.location.href = url.toString();
    }

    /* ==============================================
       CATEGORY FILTER
       ============================================== */
    document.querySelectorAll('.category-pills .pill').forEach((pill) => {
        pill.addEventListener('click', () => {
            const selectedCategory = pill.getAttribute('data-cat');
            const currentSort = document.querySelector('.sort-option.active')?.getAttribute('data-sort') || 'terbaru';
            applyFilters(selectedCategory, currentSort);
        });
    });

    /* ==============================================
       SORT DROPDOWN
       ============================================== */
    const sortTrigger = document.getElementById('sortTrigger');
    const sortMenu    = document.getElementById('sortMenu');
    const sortChevron = document.getElementById('sortChevron');

    if (sortTrigger && sortMenu) {
        sortTrigger.addEventListener('click', (event) => {
            event.stopPropagation();
            sortMenu.classList.toggle('open');
            if (sortChevron) sortChevron.classList.toggle('rotate');
        });

        document.addEventListener('click', (event) => {
            if (!sortTrigger.contains(event.target) && !sortMenu.contains(event.target)) {
                sortMenu.classList.remove('open');
                if (sortChevron) sortChevron.classList.remove('rotate');
            }
        });
    }

    document.querySelectorAll('.sort-option').forEach((option) => {
        option.addEventListener('click', () => {
            const currentSort      = option.getAttribute('data-sort');
            const selectedCategory = document.querySelector('.category-pills .pill.active')?.getAttribute('data-cat') || 'semua';
            applyFilters(selectedCategory, currentSort);
        });
    });

    /* ==============================================
       WISHLIST — API database (bukan localStorage)
       ============================================== */
    const wishlistedIds = window.wishlistedProductIds || [];

    document.querySelectorAll('.wishlist-btn').forEach((button) => {
        const productId = button.getAttribute('data-product-id');
        if (!productId) return;

        const isActive = wishlistedIds.includes(Number(productId));
        setBtn(button, isActive);

        button.addEventListener('click', async (e) => {
            e.preventDefault();
            e.stopPropagation();
            if (button.disabled) return;
            button.disabled = true;

            try {
                const res = await fetch('/wishlist', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ product_id: productId }),
                });
                const data = await res.json();
                if (data.success) setBtn(button, data.wishlisted);
            } catch (err) {
                console.error('Wishlist error:', err);
            } finally {
                button.disabled = false;
            }
        });
    });

    function setBtn(button, isActive) {
        button.classList.toggle('active', isActive);
        const icon = button.querySelector('i');
        if (icon) icon.className = isActive ? 'bi bi-heart-fill' : 'bi bi-heart';
    }
});