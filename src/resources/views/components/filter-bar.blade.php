@php
    $currentCat = request('category', 'semua');
    $currentSort = request('sort', 'terbaru');

    $sortLabels = [
        'terbaru' => '<i class="bi bi-clock-history"></i> Terbaru',
        'terlama' => '<i class="bi bi-clock"></i> Terlama',
        'termurah' => '<i class="bi bi-sort-numeric-down"></i> Termurah',
        'termahal' => '<i class="bi bi-sort-numeric-up"></i> Termahal',
    ];
@endphp

<div class="category-group">
    <span class="filter-label">Kategori</span>
    <div class="category-pills" id="categoryPills">
        <button class="pill {{ $currentCat == 'semua' ? 'active' : '' }}" data-cat="semua">Semua</button>
        <button class="pill {{ $currentCat == 'elektronik' ? 'active' : '' }}" data-cat="elektronik">Elektronik</button>
        <button class="pill {{ $currentCat == 'buku' ? 'active' : '' }}" data-cat="buku">Buku</button>
        <button class="pill {{ $currentCat == 'pakaian' ? 'active' : '' }}" data-cat="pakaian">Pakaian</button>
        <button class="pill {{ $currentCat == 'perabot' ? 'active' : '' }}" data-cat="perabot">Peralatan Kost</button>
        <button class="pill {{ $currentCat == 'olahraga' ? 'active' : '' }}" data-cat="olahraga">Olahraga</button>
        <button class="pill {{ $currentCat == 'hobi' ? 'active' : '' }}" data-cat="hobi">Hobi</button>
        <button class="pill {{ $currentCat == 'kecantikan' ? 'active' : '' }}" data-cat="kecantikan">Kecantikan</button>
        <button class="pill {{ $currentCat == 'lainnya' ? 'active' : '' }}" data-cat="lainnya">Lainnya</button>
    </div>
</div>

<div class="filter-right">
    <div class="sort-group">
        <span class="filter-label">Urutkan:</span>
        <div class="sort-dropdown-wrap" id="sortDropdownWrap">
            <button class="sort-trigger" id="sortTrigger" aria-haspopup="true" aria-expanded="false">
                <span id="sortLabel">{!! $sortLabels[$currentSort] ?? $sortLabels['terbaru'] !!}</span>
                <i class="bi bi-chevron-down sort-chevron" id="sortChevron"></i>
            </button>
            <div class="sort-menu" id="sortMenu">
                <button class="sort-option {{ $currentSort == 'terbaru' ? 'active' : '' }}" data-sort="terbaru"><i class="bi bi-clock-history"></i> Terbaru</button>
                <button class="sort-option {{ $currentSort == 'terlama' ? 'active' : '' }}" data-sort="terlama"><i class="bi bi-clock"></i> Terlama</button>
                <button class="sort-option {{ $currentSort == 'termurah' ? 'active' : '' }}" data-sort="termurah"><i class="bi bi-sort-numeric-down"></i> Termurah</button>
                <button class="sort-option {{ $currentSort == 'termahal' ? 'active' : '' }}" data-sort="termahal"><i class="bi bi-sort-numeric-up"></i> Termahal</button>
            </div>
        </div>
    </div>

    <a href="{{ route('home') }}" class="reset-filter-btn" id="resetFilterBtn">
        <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
    </a>
</div>