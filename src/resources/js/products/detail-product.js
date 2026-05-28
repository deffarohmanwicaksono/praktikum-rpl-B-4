// =============================================
// DETAIL PAGE
// =============================================
document.addEventListener('DOMContentLoaded', () => {

    const mainImg = document.getElementById('mainImage');

    // Pastikan halaman detail
    if (!mainImg) return;

    // =============================================
    // SIDEBAR TOGGLE
    // =============================================
    const sidebar = document.getElementById('sidebar');
    const mainLayout = document.getElementById('mainLayout');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const overlay = document.getElementById('sidebarOverlay');

    if (sidebarToggle && sidebar && mainLayout) {
        sidebarToggle.addEventListener('click', () => {

            const isCollapsed =
                sidebar.classList.toggle('collapsed');

            mainLayout.classList.toggle(
                'sidebar-collapsed',
                isCollapsed
            );

            sidebarToggle.setAttribute(
                'aria-expanded',
                String(!isCollapsed)
            );
        });
    }

    if (overlay && sidebar && mainLayout && sidebarToggle) {
        overlay.addEventListener('click', () => {

            sidebar.classList.add('collapsed');

            mainLayout.classList.add(
                'sidebar-collapsed'
            );

            sidebarToggle.setAttribute(
                'aria-expanded',
                'false'
            );
        });
    }

    // =============================================
    // THUMBNAIL GALLERY
    // =============================================
    const thumbBtns =
        document.querySelectorAll('.thumb');

    const imageUrls = [...thumbBtns].map(
        thumb => thumb.dataset.img
    );

    let currentThumbIndex = 0;

    function setMainImage(url, activeThumb) {

        if (!mainImg) return;

        mainImg.style.opacity = '0';
        mainImg.style.transform = 'scale(0.98)';

        setTimeout(() => {

            mainImg.src = url;

            mainImg.style.opacity = '1';
            mainImg.style.transform = 'scale(1)';

        }, 180);

        thumbBtns.forEach(thumb => {
            thumb.classList.remove('active');
        });

        if (activeThumb) {
            activeThumb.classList.add('active');
        }
    }

    thumbBtns.forEach((thumb, index) => {

        thumb.addEventListener('click', () => {

            setMainImage(
                thumb.dataset.img,
                thumb
            );

            currentThumbIndex = index;
        });
    });

    // =============================================
    // THUMBNAIL SCROLL + ACTIVE NEXT
    // =============================================
    const thumbArrow =
        document.getElementById('thumbArrow');

    const thumbnailsWrap =
        document.getElementById('thumbnailsWrap');

    if (
        thumbArrow &&
        thumbnailsWrap &&
        thumbBtns.length > 0
    ) {
        thumbArrow.addEventListener('click', () => {

            currentThumbIndex++;

            // balik ke awal kalau sudah habis
            if (currentThumbIndex >= thumbBtns.length) {
                currentThumbIndex = 0;
            }

            const activeThumb =
                thumbBtns[currentThumbIndex];

            setMainImage(
                activeThumb.dataset.img,
                activeThumb
            );

            activeThumb.scrollIntoView({
                behavior: 'smooth',
                inline: 'center',
                block: 'nearest'
            });
        });
    }

    // =============================================
    // LIGHTBOX
    // =============================================
    const lightbox =
        document.getElementById('lightbox');

    const lbImg =
        document.getElementById('lbImg');

    const lbCounter =
        document.getElementById('lbCounter');

    const mainImageWrap =
        document.getElementById('mainImageWrap');

    let lbIdx = 0;

    function openLightbox(idx) {

        if (!lightbox || !lbImg || !lbCounter) {
            return;
        }

        lbIdx = idx;

        lbImg.src = imageUrls[idx] || '';

        lbCounter.textContent =
            `${idx + 1} / ${imageUrls.length}`;

        lightbox.classList.add('open');

        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {

        if (!lightbox) return;

        lightbox.classList.remove('open');

        document.body.style.overflow = '';
    }

    function lbGo(dir) {

        if (
            !lbImg ||
            !lbCounter ||
            imageUrls.length === 0
        ) {
            return;
        }

        lbIdx =
            (
                lbIdx +
                dir +
                imageUrls.length
            ) % imageUrls.length;

        lbImg.style.opacity = '0';

        setTimeout(() => {

            lbImg.src = imageUrls[lbIdx];

            lbImg.style.opacity = '1';

            lbCounter.textContent =
                `${lbIdx + 1} / ${imageUrls.length}`;

        }, 150);
    }

    if (mainImageWrap) {
        mainImageWrap.addEventListener('click', () => {

            const activeIndex =
                [...thumbBtns].findIndex(
                    thumb =>
                        thumb.classList.contains(
                            'active'
                        )
                );

            openLightbox(
                activeIndex >= 0
                    ? activeIndex
                    : 0
            );
        });
    }

    document
        .getElementById('lbClose')
        ?.addEventListener(
            'click',
            closeLightbox
        );

    lightbox?.addEventListener('click', e => {

        if (e.target === lightbox) {
            closeLightbox();
        }
    });

    document
        .getElementById('lbPrev')
        ?.addEventListener('click', e => {

            e.stopPropagation();

            lbGo(-1);
        });

    document
        .getElementById('lbNext')
        ?.addEventListener('click', e => {

            e.stopPropagation();

            lbGo(1);
        });

    document.addEventListener('keydown', e => {

        if (
            !lightbox ||
            !lightbox.classList.contains('open')
        ) {
            return;
        }

        if (e.key === 'Escape') {
            closeLightbox();
        }

        if (e.key === 'ArrowLeft') {
            lbGo(-1);
        }

        if (e.key === 'ArrowRight') {
            lbGo(1);
        }
    });

    // =============================================
    // WISHLIST TOGGLE
    // =============================================
    let wishlisted = false;

    function setWishlist(val) {

        wishlisted = val;

        // image button
        const imgIcon =
            document.getElementById(
                'imgWishlistIcon'
            );

        const imgBtn =
            document.getElementById(
                'imgWishlistBtn'
            );

        if (imgIcon) {
            imgIcon.className = val
                ? 'bi bi-heart-fill'
                : 'bi bi-heart';
        }

        if (imgBtn) {
            imgBtn.classList.toggle(
                'active',
                val
            );
        }

        // action card
        const cardIcon =
            document.getElementById(
                'wishlistCardIcon'
            );

        const cardTitle =
            document.getElementById(
                'wishlistCardTitle'
            );

        const cardBtn =
            document.getElementById(
                'wishlistCardBtn'
            );

        if (cardIcon) {
            cardIcon.className = val
                ? 'bi bi-heart-fill'
                : 'bi bi-heart';
        }

        if (cardTitle) {
            cardTitle.textContent = val
                ? 'Tersimpan di Wishlist'
                : 'Simpan ke Wishlist';
        }

        if (cardBtn) {
            cardBtn.classList.toggle(
                'wishlisted',
                val
            );
        }
    }

    document
        .getElementById('imgWishlistBtn')
        ?.addEventListener('click', e => {

            e.stopPropagation();

            setWishlist(!wishlisted);
        });

    document
        .getElementById('wishlistCardBtn')
        ?.addEventListener('click', () => {

            setWishlist(!wishlisted);
        });

    // =============================================
    // DESCRIPTION EXPAND
    // =============================================
    let descOpen = false;

    const descExtra =
        document.getElementById('descExtra');

    const descToggle =
        document.getElementById('descToggle');

    if (descToggle && descExtra) {
        descToggle.addEventListener('click', () => {

            descOpen = !descOpen;

            descExtra.style.display =
                descOpen
                    ? 'block'
                    : 'none';

            descToggle.innerHTML = descOpen
                ? `
                    Sembunyikan
                    <i class="bi bi-chevron-up"></i>
                  `
                : `
                    Lihat selengkapnya
                    <i class="bi bi-chevron-down"></i>
                  `;
        });
    }
});