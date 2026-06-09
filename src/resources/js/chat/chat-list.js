// ==============================================
// CHAT SEARCH & FILTER
// ==============================================

const chatSearchInput = document.getElementById('chatSearchInput');
const chatSearchClear = document.getElementById('chatSearchClear');

const chatItems = document.querySelectorAll('.chat-item');
const chatEmpty = document.getElementById('chatEmpty');

const filterTabs = document.querySelectorAll('.chat-filter-tab');

// ==============================================
// SEARCH INPUT
// ==============================================

chatSearchInput.addEventListener('input', () => {

    const query = chatSearchInput.value.toLowerCase().trim();

    chatSearchClear.style.display =
        query ? 'flex' : 'none';

    applyFilters();
});

// ==============================================
// CLEAR SEARCH
// ==============================================

chatSearchClear.addEventListener('click', () => {

    chatSearchInput.value = '';

    chatSearchClear.style.display = 'none';

    chatSearchInput.focus();

    applyFilters();
});

// ==============================================
// FILTER TABS
// ==============================================

filterTabs.forEach(tab => {

    tab.addEventListener('click', () => {

        filterTabs.forEach(t => {

            t.classList.remove('active');

            t.setAttribute('aria-selected', 'false');
        });

        tab.classList.add('active');

        tab.setAttribute('aria-selected', 'true');

        applyFilters();
    });
});

// ==============================================
// APPLY FILTERS
// ==============================================

function applyFilters() {

    const query =
        chatSearchInput.value.toLowerCase().trim();

    const activeFilter =
        document.querySelector('.chat-filter-tab.active')
        .dataset.filter;

    let visibleCount = 0;

    chatItems.forEach(item => {

        const isUnread =
            item.dataset.unread === 'true';

        const nameMatch =
            item.dataset.name.includes(query);

        const barangMatch =
            item.dataset.barang.includes(query);

        const passFilter =
            activeFilter === 'semua'
            || (activeFilter === 'unread' && isUnread);

        const passSearch =
            !query || nameMatch || barangMatch;

        const show =
            passFilter && passSearch;

        item.style.display =
            show ? 'flex' : 'none';

        if (show) visibleCount++;
    });

    chatEmpty.style.display =
        visibleCount === 0
            ? 'flex'
            : 'none';
} 