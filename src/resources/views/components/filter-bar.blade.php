<div class="category-group">
    <span class="filter-label">Kategori</span>
        <div class="category-pills" id="categoryPills">
            <button class="pill active" data-cat="semua">Semua</button>
            <button class="pill" data-cat="elektronik">Elektronik</button>
            <button class="pill" data-cat="buku">Buku</button>
            <button class="pill" data-cat="pakaian">Pakaian</button>
            <button class="pill" data-cat="perabot">Peralatan Kost</button>
            <button class="pill" data-cat="alat-tulis">Alat Tulis</button>
            <button class="pill" data-cat="sepatu">Sepatu & Tas</button>
            <button class="pill" data-cat="olahraga">Olahraga</button>
            <button class="pill" data-cat="kecantikan">Kecantikan</button>
            <button class="pill" data-cat="lainnya">Lainnya</button>
        </div>
    </div>

    <div class="filter-right">
        <div class="sort-group">
            <span class="filter-label">Urutkan:</span>
            <div class="sort-dropdown-wrap" id="sortDropdownWrap">
                <button class="sort-trigger" id="sortTrigger" aria-haspopup="true" aria-expanded="false">
                    <span id="sortLabel">Terbaru</span>
                    <i class="bi bi-chevron-down sort-chevron" id="sortChevron"></i>
                </button>
                <div class="sort-menu" id="sortMenu">
                    <button class="sort-option active" data-sort="terbaru"><i class="bi bi-clock-history"></i> Terbaru</button>
                    <button class="sort-option" data-sort="terlama"><i class="bi bi-clock"></i> Terlama</button>
                    <button class="sort-option" data-sort="termurah"><i class="bi bi-sort-numeric-down"></i> Termurah</button>
                    <button class="sort-option" data-sort="termahal"><i class="bi bi-sort-numeric-up"></i> Termahal</button>
                </div>
            </div>
        </div>

        <button class="reset-filter-btn" id="resetFilterBtn">
            <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
        </button>
    </div>