document.addEventListener('DOMContentLoaded', () => {

    // =============================================
    // INITIAL RECENT SEARCH LOGIC
    // =============================================
    let recentSearches = JSON.parse(
        localStorage.getItem('semart_recent')
    );

    // =============================================
    // ELEMENTS
    // =============================================
    const topbarInput = document.getElementById('topbarSearchInput');
    const searchClearBtn = document.getElementById('searchClearBtn');
    const searchSubmitBtn = document.getElementById('searchSubmitBtn');
    const suggestions = document.getElementById('searchSuggestions');
    const recentList = document.getElementById('recentSearchList');
    const resetFilterBtn = document.getElementById('resetFilterBtn');

    // =============================================
    // CORE FUNCTION
    // =============================================
    function applySearchFilters(keyword, category, sort) {
        const url = new URL(window.location.origin + '/search');
        const currentParams = new URLSearchParams(window.location.search);

        // Ambil data aktif dari URL jika argumen bernilai undefined
        const finalKeyword = keyword !== undefined ? keyword : (currentParams.get('q') || '');
        const finalCategory = category !== undefined ? category : (currentParams.get('category') || 'semua');
        const finalSort = sort !== undefined ? sort : (currentParams.get('sort') || 'terbaru');

        // Daftarkan ke parameter URL baru jika tidak kosong
        if (finalKeyword.trim() !== '') {
            url.searchParams.set('q', finalKeyword.trim());
        }

        if (finalCategory) {
            url.searchParams.set('category', finalCategory);
        }

        if (finalSort && finalSort !== 'terbaru') {
            url.searchParams.set('sort', finalSort);
        }

        window.location.href = url.toString();
    }

    // Helper Riwayat Pencarian
    function addRecentSearch(q) {
        if (!q || !q.trim()) return;
        recentSearches = [
            q.trim(),
            ...recentSearches.filter(r => r.toLowerCase() !== q.trim().toLowerCase())
        ].slice(0, 8);

        localStorage.setItem('semart_recent', JSON.stringify(recentSearches));
    }

    function renderRecentSearches() {
        if (!recentList) return;
        recentList.innerHTML = '';

        if (!recentSearches.length) {
            recentList.innerHTML = `<span class="suggestion-empty">Belum ada riwayat pencarian.</span>`;
            return;
        }

        recentSearches.slice(0, 5).forEach(q => {
            const btn = document.createElement('button');
            btn.className = 'suggestion-item';
            btn.innerHTML = `<i class="bi bi-clock-history"></i><span>${q}</span>`;
            btn.addEventListener('click', () => {
                addRecentSearch(q);
                applySearchFilters(q, 'semua', undefined);
            });
            recentList.appendChild(btn);
        });
    }

    // =============================================
    // SEARCH INPUT & SUBMIT EVENTS
    // =============================================
    if (topbarInput) {
        if (searchClearBtn) {
            searchClearBtn.style.display = topbarInput.value ? '' : 'none';
        }

        topbarInput.addEventListener('input', () => {
            if (searchClearBtn) {
                searchClearBtn.style.display = topbarInput.value ? '' : 'none';
            }
        });

        topbarInput.addEventListener('focus', () => {
            renderRecentSearches();
            if (suggestions) suggestions.classList.add('open');
        });

        topbarInput.addEventListener('keydown', e => {
            if (e.key === 'Enter') {
                addRecentSearch(topbarInput.value);
                applySearchFilters(topbarInput.value, 'semua', undefined);
            }
        });
    }

    if (searchSubmitBtn) {
        searchSubmitBtn.addEventListener('click', () => {
            addRecentSearch(topbarInput.value);
            applySearchFilters(topbarInput.value, 'semua', undefined);
        });
    }

    if (searchClearBtn) {
        searchClearBtn.addEventListener('click', () => {
            if (topbarInput) topbarInput.value = '';
            searchClearBtn.style.display = 'none';
            applySearchFilters('', undefined, undefined); 
        });
    }

    document.addEventListener('click', e => {
        if (suggestions && !e.target.closest('#topbarSearchWrapper')) {
            suggestions.classList.remove('open');
        }
    });

    // =============================================
    // CATEGORY PILLS FILTER
    // =============================================
    const categoryPills = document.querySelectorAll('.category-pills .pill, .filter-bar .pill');
    categoryPills.forEach(pill => {
        pill.addEventListener('click', () => {
            const selectedCategory = pill.getAttribute('data-cat');
            
            if (selectedCategory === 'semua') {
                applySearchFilters(topbarInput.value, 'semua', undefined);
            } else {
                applySearchFilters('', selectedCategory, undefined);
            }
        });
    });

    // =============================================
    // SORT DROPDOWN OPTIONS
    // =============================================
    const sortTrigger = document.getElementById('sortTrigger');
    const sortMenu = document.getElementById('sortMenu');
    const sortOptions = document.querySelectorAll('.sort-option');
    const sortChevron = document.getElementById('sortChevron');

    if (sortTrigger && sortMenu) {
        sortTrigger.addEventListener('click', e => {
            e.stopPropagation();
            const isOpen = sortMenu.classList.toggle('open');
            if (sortChevron) {
                sortChevron.style.transform = isOpen ? 'rotate(180deg)' : '';
            }
        });

        document.addEventListener('click', e => {
            if (!sortTrigger.contains(e.target) && !sortMenu.contains(e.target)) {
                sortMenu.classList.remove('open');
                if (sortChevron) sortChevron.style.transform = '';
            }
        });
    }

    sortOptions.forEach(option => {
        option.addEventListener('click', () => {
            const selectedSort = option.getAttribute('data-sort');
            applySearchFilters(undefined, undefined, selectedSort);
        });
    });

    // =============================================
    // PERBAIKAN TOMBOL RESET FILTER BAR
    // =============================================
    if (resetFilterBtn) {
        resetFilterBtn.addEventListener('click', () => {
            applySearchFilters(topbarInput.value, 'semua', 'terbaru');
        });
    }

    // =============================================
    // QUICK TAGS EVENTS
    // =============================================
    document.querySelectorAll('.quick-tag').forEach(tag => {
        tag.addEventListener('click', () => {
            const tagValue = tag.getAttribute('data-q');
            addRecentSearch(tagValue);
            applySearchFilters(tagValue, 'semua', undefined);
        });
    });

    // =============================================
    // AUTO FOCUS SYNC
    // =============================================
    const urlParams = new URLSearchParams(window.location.search);
    const queryParam = urlParams.get('q') || '';
    
    if (topbarInput) {
        topbarInput.value = queryParam; 
    }

    if (window.location.pathname === '/search' && !urlParams.has('q') && !urlParams.has('category')) {
        setTimeout(() => {
            if (topbarInput) topbarInput.focus();
        }, 50);
    }
});