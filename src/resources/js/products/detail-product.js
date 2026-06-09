// =============================================
// DETAIL PAGE
// =============================================
document.addEventListener('DOMContentLoaded', () => {

    const mainImg = document.getElementById('mainImage');
    if (!mainImg) return;

    // =============================================
    // THUMBNAIL GALLERY
    // =============================================
    const thumbBtns = document.querySelectorAll('.thumb');
    const imageUrls = [...thumbBtns].map(thumb => thumb.dataset.img);
    let currentThumbIndex = 0;

    function setMainImage(url, activeThumb) {
        if (!mainImg) return;
        mainImg.style.opacity   = '0';
        mainImg.style.transform = 'scale(0.98)';

        setTimeout(() => {
            mainImg.src             = url;
            mainImg.style.opacity   = '1';
            mainImg.style.transform = 'scale(1)';
        }, 180);

        thumbBtns.forEach(thumb => thumb.classList.remove('active'));
        if (activeThumb) activeThumb.classList.add('active');
    }

    thumbBtns.forEach((thumb, index) => {
        thumb.addEventListener('click', () => {
            setMainImage(thumb.dataset.img, thumb);
            currentThumbIndex = index;
        });
    });

    // =============================================
    // THUMBNAIL SCROLL + ACTIVE NEXT
    // =============================================
    const thumbArrow    = document.getElementById('thumbArrow');
    const thumbnailsWrap = document.getElementById('thumbnailsWrap');

    if (thumbArrow && thumbnailsWrap && thumbBtns.length > 0) {
        thumbArrow.addEventListener('click', () => {
            currentThumbIndex++;
            if (currentThumbIndex >= thumbBtns.length) currentThumbIndex = 0;

            const activeThumb = thumbBtns[currentThumbIndex];
            setMainImage(activeThumb.dataset.img, activeThumb);
            activeThumb.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
        });
    }

    // =============================================
    // LIGHTBOX
    // =============================================
    const lightbox      = document.getElementById('lightbox');
    const lbImg         = document.getElementById('lbImg');
    const lbCounter     = document.getElementById('lbCounter');
    const mainImageWrap = document.getElementById('mainImageWrap');
    let lbIdx = 0;

    function openLightbox(idx) {
        if (!lightbox || !lbImg || !lbCounter) return;
        lbIdx         = idx;
        lbImg.src     = imageUrls[idx] || '';
        lbCounter.textContent = `${idx + 1} / ${imageUrls.length}`;
        lightbox.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        if (!lightbox) return;
        lightbox.classList.remove('open');
        document.body.style.overflow = '';
    }

    function lbGo(dir) {
        if (!lbImg || !lbCounter || imageUrls.length === 0) return;
        lbIdx = (lbIdx + dir + imageUrls.length) % imageUrls.length;
        lbImg.style.opacity = '0';
        setTimeout(() => {
            lbImg.src = imageUrls[lbIdx];
            lbImg.style.opacity   = '1';
            lbCounter.textContent = `${lbIdx + 1} / ${imageUrls.length}`;
        }, 150);
    }

    mainImageWrap?.addEventListener('click', () => {
        const activeIndex = [...thumbBtns].findIndex(t => t.classList.contains('active'));
        openLightbox(activeIndex >= 0 ? activeIndex : 0);
    });

    document.getElementById('lbClose')?.addEventListener('click', closeLightbox);
    lightbox?.addEventListener('click', e => { if (e.target === lightbox) closeLightbox(); });
    document.getElementById('lbPrev')?.addEventListener('click', e => { e.stopPropagation(); lbGo(-1); });
    document.getElementById('lbNext')?.addEventListener('click', e => { e.stopPropagation(); lbGo(1); });

    document.addEventListener('keydown', e => {
        if (!lightbox?.classList.contains('open')) return;
        if (e.key === 'Escape')     closeLightbox();
        if (e.key === 'ArrowLeft')  lbGo(-1);
        if (e.key === 'ArrowRight') lbGo(1);
    });

    // =============================================
    // WISHLIST
    // =============================================
    const csrfToken     = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const wishlistCardBtn   = document.getElementById('wishlistCardBtn');
    const wishlistCardIcon  = document.getElementById('wishlistCardIcon');
    const wishlistCardTitle = document.getElementById('wishlistCardTitle');

    if (wishlistCardBtn) {
        const productId = wishlistCardBtn.getAttribute('data-product-id');
        const wishlistedIds = window.wishlistedProductIds || [];

        let isWishlisted = productId && wishlistedIds.includes(Number(productId));
        setWishlistCardState(isWishlisted);

        wishlistCardBtn.addEventListener('click', async () => {
            if (wishlistCardBtn.disabled) return;
            wishlistCardBtn.disabled = true;

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
                if (data.success) {
                    isWishlisted = data.wishlisted;
                    setWishlistCardState(isWishlisted);
                }
            } catch (err) {
                console.error('Wishlist error:', err);
            } finally {
                wishlistCardBtn.disabled = false;
            }
        });
    }

    function setWishlistCardState(active) {
        if (wishlistCardIcon)  wishlistCardIcon.className  = active ? 'bi bi-heart-fill' : 'bi bi-heart';
        if (wishlistCardTitle) wishlistCardTitle.textContent = active ? 'Tersimpan di Wishlist' : 'Simpan ke Wishlist';
        if (wishlistCardBtn)   wishlistCardBtn.classList.toggle('active', active);
    }

    // =============================================
    // DESCRIPTION EXPAND
    // =============================================
    let descOpen = false;
    const descExtra  = document.getElementById('descExtra');
    const descToggle = document.getElementById('descToggle');

    if (descToggle && descExtra) {
        descToggle.addEventListener('click', () => {
            descOpen = !descOpen;
            descExtra.style.display = descOpen ? 'block' : 'none';
            descToggle.innerHTML    = descOpen
                ? `Sembunyikan <i class="bi bi-chevron-up"></i>`
                : `Lihat selengkapnya <i class="bi bi-chevron-down"></i>`;
        });
    }

    // =============================================
    // REPORT MODAL LOGIC
    // =============================================
    const reportModal    = document.getElementById('reportModal');
    const openReportBtn  = document.getElementById('openReportModalBtn');
    const closeReportBtn = document.getElementById('closeReportModalBtn');
    const cancelReportBtn = document.getElementById('cancelReportBtn');

    const openReport  = () => { if (!reportModal) return; reportModal.classList.add('open');    document.body.style.overflow = 'hidden'; };
    const closeReport = () => { if (!reportModal) return; reportModal.classList.remove('open'); document.body.style.overflow = '';       };

    openReportBtn?.addEventListener('click', openReport);
    closeReportBtn?.addEventListener('click', closeReport);
    cancelReportBtn?.addEventListener('click', closeReport);
    reportModal?.addEventListener('click', e => { if (e.target === reportModal) closeReport(); });
});