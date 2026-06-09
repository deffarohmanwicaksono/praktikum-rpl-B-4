document.addEventListener('DOMContentLoaded', () => {

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
    const categoryPills = document.querySelectorAll('.category-pills .pill');
    categoryPills.forEach((pill) => {
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
    const sortMenu = document.getElementById('sortMenu');
    const sortOptions = document.querySelectorAll('.sort-option');
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

    sortOptions.forEach((option) => {
        option.addEventListener('click', () => {
            const currentSort = option.getAttribute('data-sort');
            const selectedCategory = document.querySelector('.category-pills .pill.active')?.getAttribute('data-cat') || 'semua';
            
            applyFilters(selectedCategory, currentSort);
        });
    });

    /* ==============================================
       WISHLIST
       ============================================== */
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');

    let savedWishlist = JSON.parse(localStorage.getItem('seMartWishlist')) || [];

    const updateWishlistButton = (button, isActive) => {
        const icon = button.querySelector('i');
        button.classList.toggle('active', isActive);

        if (icon) {
            icon.className = isActive ? 'bi bi-heart-fill' : 'bi bi-heart';
        }
    };

    wishlistButtons.forEach((button) => {
        const productName = button.getAttribute('data-name');
        if (!productName) return;

        const isWishlisted = savedWishlist.some((item) => item.name === productName);
        updateWishlistButton(button, isWishlisted);

        button.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();

            const name = button.getAttribute('data-name');
            const price = button.getAttribute('data-price');
            const condition = button.getAttribute('data-condition');
            const image = button.getAttribute('data-image');
            const isActive = button.classList.contains('active');

            if (isActive) {
                savedWishlist = savedWishlist.filter((item) => item.name !== name);
            } else {
                savedWishlist.push({ name, price, condition, image });
            }

            updateWishlistButton(button, !isActive);
            localStorage.setItem('seMartWishlist', JSON.stringify(savedWishlist));
        });
    });
});