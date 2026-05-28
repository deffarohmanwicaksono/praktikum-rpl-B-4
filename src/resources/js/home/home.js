document.addEventListener('DOMContentLoaded', () => {

    /* ==============================================
       CATEGORY FILTER
       ============================================== */

    const categoryPills = document.querySelectorAll(
        '.category-pills .pill'
    );

    categoryPills.forEach((pill) => {
        pill.addEventListener('click', () => {

            document
                .querySelector('.category-pills .pill.active')
                ?.classList.remove('active');

            pill.classList.add('active');

            const selectedCategory = pill.getAttribute('data-cat');

            console.log(
                'Kategori dipilih:',
                selectedCategory
            );
        });
    });

    /* ==============================================
       SORT DROPDOWN
       ============================================== */

    const sortTrigger = document.getElementById('sortTrigger');
    const sortMenu = document.getElementById('sortMenu');
    const sortOptions = document.querySelectorAll('.sort-option');
    const sortLabel = document.getElementById('sortLabel');

    const closeSortMenu = () => {
        if (!sortMenu || !sortTrigger) return;

        sortMenu.classList.remove('open');

        sortTrigger.setAttribute(
            'aria-expanded',
            'false'
        );
    };

    if (sortTrigger && sortMenu) {

        sortTrigger.addEventListener('click', (event) => {
            event.stopPropagation();

            const isOpen = sortMenu.classList.toggle('open');

            sortTrigger.setAttribute(
                'aria-expanded',
                String(isOpen)
            );
        });

        sortOptions.forEach((option) => {

            option.addEventListener('click', () => {

                document
                    .querySelector('.sort-option.active')
                    ?.classList.remove('active');

                option.classList.add('active');

                if (sortLabel) {
                    sortLabel.textContent =
                        option.textContent.trim();
                }

                closeSortMenu();

                const currentSort =
                    option.getAttribute('data-sort');

                console.log(
                    'Urutan dipilih:',
                    currentSort
                );
            });
        });

        document.addEventListener('click', (event) => {

            const isOutsideTrigger =
                !sortTrigger.contains(event.target);

            const isOutsideMenu =
                !sortMenu.contains(event.target);

            if (isOutsideTrigger && isOutsideMenu) {
                closeSortMenu();
            }
        });
    }

    /* ==============================================
       WISHLIST
       ============================================== */

    const wishlistButtons = document.querySelectorAll(
        '.wishlist-btn'
    );

    let savedWishlist =
        JSON.parse(
            localStorage.getItem('seMartWishlist')
        ) || [];

    const updateWishlistButton = (button, isActive) => {

        const icon = button.querySelector('i');

        button.classList.toggle('active', isActive);

        if (icon) {
            icon.className = isActive
                ? 'bi bi-heart-fill'
                : 'bi bi-heart';
        }
    };

    wishlistButtons.forEach((button) => {

        const productName =
            button.getAttribute('data-name');

        if (!productName) return;

        const isWishlisted = savedWishlist.some(
            (item) => item.name === productName
        );

        updateWishlistButton(
            button,
            isWishlisted
        );

        button.addEventListener('click', (event) => {

            event.preventDefault();
            event.stopPropagation();

            const name =
                button.getAttribute('data-name');

            const price =
                button.getAttribute('data-price');

            const condition =
                button.getAttribute('data-condition');

            const image =
                button.getAttribute('data-image');

            const isActive =
                button.classList.contains('active');

            if (isActive) {

                savedWishlist = savedWishlist.filter(
                    (item) => item.name !== name
                );

            } else {

                savedWishlist.push({
                    name,
                    price,
                    condition,
                    image,
                });
            }

            updateWishlistButton(
                button,
                !isActive
            );

            localStorage.setItem(
                'seMartWishlist',
                JSON.stringify(savedWishlist)
            );
        });
    });

    /* ==============================================
       RESET FILTER
       ============================================== */

    const resetFilterBtn = document.getElementById(
        'resetFilterBtn'
    );

    const resetCategoryFilter = () => {

        document
            .querySelectorAll('.category-pills .pill')
            .forEach((pill) => {

                const isSemua =
                    pill.getAttribute('data-cat') === 'semua';

                pill.classList.toggle(
                    'active',
                    isSemua
                );
            });
    };

    const resetSortFilter = () => {

        document
            .querySelectorAll('.sort-option')
            .forEach((option) => {

                const isTerbaru =
                    option.getAttribute('data-sort') === 'terbaru';

                option.classList.toggle(
                    'active',
                    isTerbaru
                );
            });

        if (sortLabel) {
            sortLabel.textContent = 'Terbaru';
        }
    };

    if (resetFilterBtn) {

        resetFilterBtn.addEventListener('click', () => {

            resetCategoryFilter();
            resetSortFilter();

            window.location.href = '/home';
        });
    }
});