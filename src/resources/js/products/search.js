// =============================================
// DATA MOCK
// =============================================
const dummyImage = window.SeMartConfig.dummyImage;
const appUrl = window.SeMartConfig.appUrl;
const rawDatabaseProducts = window.SeMartConfig.dbProducts || [];
const PRODUCTS = rawDatabaseProducts.map(dbItem => {
    
    let imageUrl = dummyImage;
    
    if (dbItem.product_images && dbItem.product_images.length > 0) {
        const firstImg = dbItem.product_images[0].image_url;
        
        if (firstImg.startsWith('http')) {
            imageUrl = firstImg; 
        } else if (firstImg.startsWith('images/')) {
            imageUrl = `${appUrl}/${firstImg}`; 
        } else {
            imageUrl = `${appUrl}/storage/${firstImg}`; 
        }
    }

    return {
        id: dbItem.id,
        name: dbItem.name,
        price: dbItem.price,
        cat: dbItem.category ? dbItem.category.name.toLowerCase() : 'elektronik',
        
        cond: dbItem.kondisi || 'bekas-baik', 
        
        img: imageUrl,
        tags: [dbItem.name.toLowerCase()] 
    };
});

let recentSearches = JSON.parse(
    localStorage.getItem('semart_recent') ||
    '["laptop","buku kuliah","jaket","headset"]'
);

// =============================================
// ELEMENTS
// =============================================
const topbarInput =
    document.getElementById('topbarSearchInput');

const searchClearBtn =
    document.getElementById('searchClearBtn');

const searchSubmitBtn =
    document.getElementById('searchSubmitBtn');

const suggestions =
    document.getElementById('searchSuggestions');

const recentList =
    document.getElementById('recentSearchList');

const suggLiveSection =
    document.getElementById('suggestionLiveSection');

const liveList =
    document.getElementById('liveSuggestionList');

const stateEmpty =
    document.getElementById('stateEmpty');

const stateLoading =
    document.getElementById('stateLoading');

const stateResults =
    document.getElementById('stateResults');

const stateNoResults =
    document.getElementById('stateNoResults');

const productGrid =
    document.getElementById('productGrid');

const resultKeyword =
    document.getElementById('resultKeyword');

const resultCount =
    document.getElementById('resultCount');

// =============================================
// STATE
// =============================================
let currentKeyword = '';
let currentCat = 'semua';
let currentSort = 'terbaru';
let allResults = [];

// =============================================
// HELPERS
// =============================================
const condLabel = {
    'like-new': 'Bekas Seperti Baru',
    'bekas-baik': 'Bekas Baik',
    'bekas-layak': 'Bekas Layak Pakai'
};

const fmtPrice = n => {
    const num = parseInt(n); 
    return 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
};

function showState(name) {

    if (stateEmpty) {
        stateEmpty.style.display =
            name === 'empty'
                ? ''
                : 'none';
    }

    if (stateLoading) {
        stateLoading.style.display =
            name === 'loading'
                ? ''
                : 'none';
    }

    if (stateResults) {
        stateResults.style.display =
            name === 'results'
                ? ''
                : 'none';
    }
}

function renderRecentSearches() {

    if (!recentList) return;

    recentList.innerHTML = '';

    if (!recentSearches.length) {
        recentList.innerHTML = `
            <span class="suggestion-empty">
                Belum ada riwayat pencarian.
            </span>
        `;
        return;
    }

    recentSearches
        .slice(0, 5)
        .forEach(q => {

            const btn =
                document.createElement('button');

            btn.className = 'suggestion-item';

            btn.innerHTML = `
                <i class="bi bi-clock-history"></i>
                <span>${q}</span>
            `;

            btn.addEventListener('click', () => {

                doSearch(q);

                suggestions.classList.remove('open');
            });

            recentList.appendChild(btn);
        });
}

function addRecentSearch(q) {

    recentSearches = [
        q,
        ...recentSearches.filter(
            r => r.toLowerCase() !== q.toLowerCase()
        )
    ].slice(0, 8);

    localStorage.setItem(
        'semart_recent',
        JSON.stringify(recentSearches)
    );

    renderRecentSearches();
}

function renderLiveSuggestions(q) {

    if (!suggLiveSection || !liveList) {
        return;
    }

    if (!q.trim()) {
        suggLiveSection.style.display = 'none';
        return;
    }

    const matches = [
        ...new Set(
            PRODUCTS
                .filter(
                    p =>
                        p.name
                            .toLowerCase()
                            .includes(q.toLowerCase()) ||
                        p.tags.some(
                            t =>
                                t.includes(
                                    q.toLowerCase()
                                )
                        )
                )
                .map(p => p.name)
        )
    ].slice(0, 5);

    if (!matches.length) {
        suggLiveSection.style.display = 'none';
        return;
    }

    suggLiveSection.style.display = '';

    liveList.innerHTML = '';

    matches.forEach(name => {

        const btn =
            document.createElement('button');

        btn.className = 'suggestion-item';

        btn.innerHTML = `
            <i class="bi bi-search"></i>
            <span>${name}</span>
        `;

        btn.addEventListener('click', () => {

            doSearch(name);

            suggestions.classList.remove('open');
        });

        liveList.appendChild(btn);
    });
}

function doSearch(q) {

    q = q.trim();

    if (!q) return;

    window.location.replace(
        `/search?q=${encodeURIComponent(q)}`
    );
}

function renderResults() {

    let filtered = [...allResults];

    if (currentCat !== 'semua') {
        filtered = filtered.filter(
            p => p.cat === currentCat
        );
    }

    if (currentSort === 'termurah') {
        filtered.sort((a, b) => a.price - b.price);
    }

    if (currentSort === 'termahal') {
        filtered.sort((a, b) => b.price - a.price);
    }

    if (currentSort === 'terlama') {
        filtered.sort((a, b) => a.id - b.id);
    }

    if (currentSort === 'terbaru') {
        filtered.sort((a, b) => b.id - a.id);
    }

    if (resultKeyword) {
        resultKeyword.textContent =
            currentKeyword;
    }

    if (resultCount) {
        resultCount.textContent =
            filtered.length;
    }

    showState('results');

    if (!filtered.length) {

        if (productGrid) {
            productGrid.innerHTML = '';
        }

        if (stateNoResults) {
            stateNoResults.style.display = '';
        }

        return;
    }

    if (stateNoResults) {
        stateNoResults.style.display = 'none';
    }

    if (!productGrid) return;

    productGrid.innerHTML = filtered
        .map((p, i) => `
            <a
                href="/products/1"
                class="product-card"
                style="text-decoration: none; color: inherit; animation-delay:${i * 0.05}s"
            >
                <div class="card-img-wrap">
                    <img
                        src="${p.img}"
                        alt="${p.name}"
                        class="card-img"
                        loading="lazy"
                    >
                </div>

                <div class="card-body-custom">
                    <h3 class="product-name">
                        ${p.name}
                    </h3>

                    <p class="product-price">
                        ${fmtPrice(p.price)}
                    </p>

                    <span class="condition-badge ${p.cond}">
                        ${condLabel[p.cond]}
                    </span>

                    <button
                        class="wishlist-btn"
                        aria-label="Wishlist"
                    >
                        <i class="bi bi-heart"></i>
                    </button>
                </div>
            </a>
        `)
        .join('');

    productGrid
        .querySelectorAll('.wishlist-btn')
        .forEach(btn => {

            btn.addEventListener('click', e => {

                e.preventDefault();
                e.stopPropagation();

                btn.classList.toggle('active');

                const icon =
                    btn.querySelector('i');

                if (!icon) return;

                icon.className =
                    btn.classList.contains('active')
                        ? 'bi bi-heart-fill'
                        : 'bi bi-heart';
            });
        });
}

// =============================================
// SEARCH INPUT EVENTS
// =============================================
if (topbarInput) {

    topbarInput.addEventListener('input', () => {

        const value = topbarInput.value;

        if (searchClearBtn) {
            searchClearBtn.style.display =
                value
                    ? ''
                    : 'none';
        }

        renderLiveSuggestions(value);

        if (suggestions) {
            suggestions.classList.add('open');
        }
    });

    topbarInput.addEventListener('focus', () => {

        renderRecentSearches();

        if (suggestions) {
            suggestions.classList.add('open');
        }
    });

    topbarInput.addEventListener(
        'keydown',
        e => {

            if (e.key === 'Enter') {
                doSearch(topbarInput.value);
            }
        }
    );
}

if (searchSubmitBtn) {
    searchSubmitBtn.addEventListener(
        'click',
        () => doSearch(topbarInput.value)
    );
}

if (searchClearBtn) {

    searchClearBtn.addEventListener('click', () => {

        if (topbarInput) {
            topbarInput.value = '';
            topbarInput.focus();
        }

        searchClearBtn.style.display = 'none';

        showState('empty');

        if (suggestions) {
            suggestions.classList.add('open');
        }

        renderRecentSearches();

        renderLiveSuggestions('');
    });
}

document.addEventListener('click', e => {

    if (
        suggestions &&
        !e.target.closest('#topbarSearchWrapper')
    ) {
        suggestions.classList.remove('open');
    }
});

// =============================================
// CATEGORY FILTER
// =============================================
const categoryPills =
    document.getElementById('categoryPills');

if (categoryPills) {

    categoryPills.addEventListener('click', e => {

        const btn =
            e.target.closest('.pill');

        if (!btn) return;

        document
            .querySelectorAll('.pill')
            .forEach(p => {
                p.classList.remove('active');
            });

        btn.classList.add('active');

        currentCat = btn.dataset.cat;

        renderResults();
    });
}

// =============================================
// SORT DROPDOWN
// =============================================
const sortTrigger =
    document.getElementById('sortTrigger');

const sortMenu =
    document.getElementById('sortMenu');

const sortChevron =
    document.getElementById('sortChevron');

const sortLabel =
    document.getElementById('sortLabel');

if (
    sortTrigger &&
    sortMenu &&
    sortChevron
) {
    sortTrigger.addEventListener('click', e => {

        e.stopPropagation();

        const open =
            sortMenu.classList.toggle('open');

        sortChevron.style.transform = open
            ? 'rotate(180deg)'
            : '';

        sortTrigger.setAttribute(
            'aria-expanded',
            String(open)
        );
    });

    sortMenu.addEventListener('click', e => {

        const opt =
            e.target.closest('.sort-option');

        if (!opt) return;

        document
            .querySelectorAll('.sort-option')
            .forEach(o => {
                o.classList.remove('active');
            });

        opt.classList.add('active');

        currentSort = opt.dataset.sort;

        if (sortLabel) {
            sortLabel.textContent =
                opt.textContent.trim();
        }

        sortMenu.classList.remove('open');

        sortChevron.style.transform = '';

        sortTrigger.setAttribute(
            'aria-expanded',
            'false'
        );

        renderResults();
    });
}

document.addEventListener('click', e => {

    if (
        sortMenu &&
        sortChevron &&
        !e.target.closest('#sortDropdownWrap')
    ) {
        sortMenu.classList.remove('open');

        sortChevron.style.transform = '';
    }
});

// =============================================
// RESET FILTER
// =============================================
const resetFilterBtn =
    document.getElementById('resetFilterBtn');

if (resetFilterBtn) {

    resetFilterBtn.addEventListener('click', () => {

        currentCat = 'semua';
        currentSort = 'terbaru';

        document
            .querySelectorAll('.pill')
            .forEach(p => {

                p.classList.toggle(
                    'active',
                    p.dataset.cat === 'semua'
                );
            });

        document
            .querySelectorAll('.sort-option')
            .forEach(o => {

                o.classList.toggle(
                    'active',
                    o.dataset.sort === 'terbaru'
                );
            });

        if (sortLabel) {
            sortLabel.textContent = 'Terbaru';
        }

        renderResults();
    });
}

// =============================================
// QUICK TAG
// =============================================
document
    .querySelectorAll('.quick-tag')
    .forEach(tag => {

        tag.addEventListener(
            'click',
            () => doSearch(tag.dataset.q)
        );
    });

// =============================================
// SIDEBAR TOGGLE
// =============================================
const sidebar =
    document.getElementById('sidebar');

const mainLayout =
    document.getElementById('mainLayout');

const sidebarToggle =
    document.getElementById('sidebarToggle');

const overlay =
    document.getElementById('sidebarOverlay');

if (
    sidebarToggle &&
    sidebar &&
    mainLayout
) {
    sidebarToggle.addEventListener('click', () => {

        const isCollapsed =
            sidebar.classList.toggle(
                'collapsed'
            );

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

if (
    overlay &&
    sidebar &&
    mainLayout &&
    sidebarToggle
) {
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
// INITIAL CALLS
// =============================================
renderRecentSearches();

const urlParams =
    new URLSearchParams(
        window.location.search
    );

const queryParam =
    urlParams.get('q');

if (queryParam) {

    currentKeyword = queryParam;

    if (topbarInput) {
        topbarInput.value = queryParam;
    }

    if (searchClearBtn) {
        searchClearBtn.style.display = '';
    }

    addRecentSearch(queryParam);

    showState('loading');

    setTimeout(() => {

        allResults = PRODUCTS.filter(
            p =>
                p.name
                    .toLowerCase()
                    .includes(
                        queryParam.toLowerCase()
                    ) ||
                p.tags.some(
                    t =>
                        t.includes(
                            queryParam.toLowerCase()
                        )
                )
        );

        renderResults();

    }, 300);

} else {

    showState('empty');
}

// =============================================
// AUTO FOCUS SEARCH
// =============================================
document.addEventListener(
    'DOMContentLoaded',
    () => {

        if (
            window.location.pathname === '/search'
        ) {
            const searchInput =
                document.querySelector(
                    '.search-input'
                ) || topbarInput;

            if (!searchInput) return;

            setTimeout(() => {

                searchInput.focus();

                const value =
                    searchInput.value;

                searchInput.value = '';
                searchInput.value = value;

            }, 50);
        }
    }
);