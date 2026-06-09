@extends('layouts-admin.app')

@section('title', 'Daftar User - SeMart')

@push('styles')
    @vite('resources/css/pages/users.css')
@endpush

@push('scripts')
    @vite('resources/js/admin/users.js')
@endpush

@section('content')

@php
$users = [
    [
        'id' => 1,
        'name' => 'Andi Pratama',
        'email' => 'andi.pratama@student.uns.ac.id',
        'roles' => ['Seller', 'Buyer'],
        'status' => 'Aktif',
        'status_class' => 'status-aktif',
        'joined' => '12 Jan 2024',
        'phone' => '081234567890',
        'products_sold' => 24,
        'transactions' => 156,
        'rating' => 4.2,
        'reviews' => 12
    ],
    [
        'id' => 2,
        'name' => 'Siti Aisyah',
        'email' => 'siti.aisyah@student.uns.ac.id',
        'roles' => ['Buyer'],
        'status' => 'Aktif',
        'status_class' => 'status-aktif',
        'joined' => '15 Feb 2024',
        'phone' => '085712345678',
        'products_sold' => 0,
        'transactions' => 45,
        'rating' => 0,
        'reviews' => 0
    ],
    [
        'id' => 3,
        'name' => 'Budi Santoso',
        'email' => 'budi.santoso@student.uns.ac.id',
        'roles' => ['Seller'],
        'status' => 'Diblokir',
        'status_class' => 'status-diblokir',
        'joined' => '03 Mar 2024',
        'phone' => '089987654321',
        'products_sold' => 89,
        'transactions' => 310,
        'rating' => 4.8,
        'reviews' => 215
    ],
    [
        'id' => 4,
        'name' => 'Dewi Lestari',
        'email' => 'dewi.lestari@student.uns.ac.id',
        'roles' => ['Buyer', 'Seller'],
        'status' => 'Aktif',
        'status_class' => 'status-aktif',
        'joined' => '20 Mar 2024',
        'phone' => '082134567891',
        'products_sold' => 5,
        'transactions' => 22,
        'rating' => 5.0,
        'reviews' => 8
    ],
    [
        'id' => 5,
        'name' => 'Fajar Ramadhan',
        'email' => 'fajar.ramadhan@student.uns.ac.id',
        'roles' => ['Seller'],
        'status' => 'Aktif',
        'status_class' => 'status-aktif',
        'joined' => '28 Mar 2024',
        'phone' => '081398765432',
        'products_sold' => 112,
        'transactions' => 540,
        'rating' => 4.9,
        'reviews' => 320
    ],
    [
        'id' => 6,
        'name' => 'Nabila Putri',
        'email' => 'nabila.putri@student.uns.ac.id',
        'roles' => ['Buyer'],
        'status' => 'Aktif',
        'status_class' => 'status-aktif',
        'joined' => '05 Apr 2024',
        'phone' => '087812345678',
        'products_sold' => 0,
        'transactions' => 15,
        'rating' => 0,
        'reviews' => 0
    ],
    [
        'id' => 7,
        'name' => 'Rizky Maulana',
        'email' => 'rizky.maulana@student.uns.ac.id',
        'roles' => ['Seller'],
        'status' => 'Diblokir',
        'status_class' => 'status-diblokir',
        'joined' => '18 Apr 2024',
        'phone' => '085212345678',
        'products_sold' => 12,
        'transactions' => 40,
        'rating' => 3.5,
        'reviews' => 10
    ]
];

$activeUser = $users[0];
@endphp

{{-- =============================================
     PAGE HEADER
     ============================================= --}}
<section class="page-header-section">
    <div class="page-header-left">
        <h1 class="page-title">Daftar User</h1>
        <p class="page-subtitle">Kelola semua pengguna yang terdaftar di SeMart</p>
    </div>
</section>

{{-- =============================================
     TOOLBAR: SEARCH & FILTER
     ============================================= --}}
<div class="toolbar-section">
    <div class="search-box">
        <i class="bi bi-search search-icon"></i>
        <input type="text" id="searchInput" class="search-input" placeholder="Cari nama atau email...">
    </div>
    
    <div class="filter-box">
        <div class="filter-dropdown">
            <i class="bi bi-funnel filter-icon"></i>
            <select id="filterStatus" class="filter-select">
                <option value="">Status: Semua Status</option>
                <option value="aktif">Aktif</option>
                <option value="diblokir">Diblokir</option>
            </select>
        </div>
        <div class="filter-dropdown">
            <i class="bi bi-person filter-icon"></i>
            <select id="filterRole" class="filter-select">
                <option value="">Role: Semua Role</option>
                <option value="seller">Seller</option>
                <option value="buyer">Buyer</option>
            </select>
        </div>
    </div>
</div>

{{-- =============================================
     TWO-PANEL LAYOUT
     ============================================= --}}
<div class="user-layout">
    
    {{-- LEFT PANEL: TABEL DAFTAR USER --}}
    <div class="panel-left">
        <div class="table-wrapper">
            <table class="users-table">
                <thead>
                    <tr>
                        <th class="col-nama">User</th>
                        <th class="col-role">Role</th>
                        <th class="col-status">Status</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody id="usersTableBody">
                    @foreach($users as $index => $user)
                    <tr class="user-row {{ $index === 0 ? 'active-row' : '' }}" 
                        data-id="{{ $user['id'] }}"
                        data-user="{{ json_encode($user) }}">
                        
                        <td class="col-nama">
                            <div class="user-profile-cell">
                                <div class="user-icon-avatar">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <div class="user-info">
                                    <span class="user-name">{{ $user['name'] }}</span>
                                    <span class="user-email">{{ $user['email'] }}</span>
                                </div>
                            </div>
                        </td>
                        
                        <td class="col-role">
                            <div class="role-badges-wrap text-center">
                                @foreach($user['roles'] as $role)
                                    <span class="role-badge role-{{ strtolower($role) }}">{{ $role }}</span>
                                @endforeach
                            </div>
                        </td>
                        
                        <td class="col-status">
                            <span class="status-badge {{ $user['status_class'] }}">{{ $user['status'] }}</span>
                        </td>
                        
                        <td class="col-aksi">
                            <div class="action-buttons">
                                <button class="btn-action btn-detail {{ $index === 0 ? 'active' : '' }}" title="Detail User" data-id="{{ $user['id'] }}">
                                    <i class="bi bi-eye"></i> <span>Detail</span>
                                </button>
                                
                                @if($user['status'] === 'Aktif')
                                    <button class="btn-action btn-status-toggle btn-blokir" data-id="{{ $user['id'] }}" data-name="{{ $user['name'] }}" data-action="blokir" title="Blokir User">
                                        <i class="bi bi-lock"></i>
                                    </button>
                                @else
                                    <button class="btn-action btn-status-toggle btn-aktifkan" data-id="{{ $user['id'] }}" data-name="{{ $user['name'] }}" data-action="aktifkan" title="Aktifkan User">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination Info --}}
            <div class="table-footer">
                <span class="table-info" id="tableInfoText">Menampilkan 1–{{ count($users) }} dari {{ count($users) }} user</span>
                <div class="pagination-wrap">
                    <button class="page-btn" disabled aria-label="Previous">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn" disabled aria-label="Next">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- RIGHT PANEL: DETAIL PROFIL USER --}}
    <div class="panel-right" id="userDetailPanel">
        <div class="detail-card" id="detailCard">
            <h3 class="detail-section-title">Detail Profil User</h3>
            
            <div class="detail-profile-header">
                <div class="detail-avatar-wrap">
                    <i class="bi bi-person-fill detail-icon-avatar"></i>
                </div>
                <h4 class="detail-user-fullname" id="detailUserName">{{ $activeUser['name'] }}</h4>
                <p class="detail-user-sub" id="detailUserEmail">{{ $activeUser['email'] }}</p>
            </div>

            {{-- STATISTIK KOMPONEN (PRODUK, TRANSAKSI, ULASAN) --}}
            <div class="detail-stats-grid">
                @php
                    $isOnlyBuyer = count($activeUser['roles']) === 1 && in_array('Buyer', $activeUser['roles']);
                @endphp
                
                {{-- Komponen 1: Produk Dijual --}}
                <div class="stat-item">
                    <div class="stat-icon-wrap"><i class="bi bi-bag"></i></div>
                    <div class="stat-value" id="detailUserProducts">
                        {{ $isOnlyBuyer ? '0' : ($activeUser['products_sold'] ?? 0) }}
                    </div>
                    <div class="stat-label">Produk Dijual</div>
                </div>

                {{-- Komponen 2: Transaksi Selesai --}}
                <div class="stat-item">
                    <div class="stat-icon-wrap"><i class="bi bi-graph-up"></i></div>
                    <div class="stat-value" id="detailUserTransactions">
                        {{ $activeUser['transactions'] ?? 0 }}
                    </div>
                    <div class="stat-label">Transaksi Selesai</div>
                </div>

                {{-- Komponen 3: Ulasan --}}
                <div class="stat-item">
                    <div class="stat-icon-wrap"><i class="bi bi-star"></i></div>
                    <div class="stat-value" id="detailUserRating">
                        {{ $isOnlyBuyer ? '-' : ($activeUser['rating'] ?? '0.0') }}
                    </div>
                    <div class="stat-label" id="detailUserReviews">
                        {{ $isOnlyBuyer ? 'Tidak ada ulasan' : ($activeUser['reviews'] ?? 0) . ' Ulasan' }}
                    </div>
                </div>
            </div>

            <div class="detail-meta-list">
                <div class="detail-meta-row">
                    <i class="bi bi-person-badge detail-meta-icon"></i>
                    <span class="detail-meta-label">Role</span>
                    <div class="detail-meta-value" id="detailUserRole">
                        <div class="role-badges-wrap text-left">
                            @foreach($activeUser['roles'] as $role)
                                <span class="role-badge role-{{ strtolower($role) }}">{{ $role }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="detail-meta-row">
                    <i class="bi bi-info-circle detail-meta-icon"></i>
                    <span class="detail-meta-label">Status</span>
                    <div class="detail-meta-value" id="detailUserStatus">
                        <span class="status-badge {{ $activeUser['status_class'] }}">{{ $activeUser['status'] }}</span>
                    </div>
                </div>

                <div class="detail-meta-row">
                    <i class="bi bi-telephone detail-meta-icon"></i>
                    <span class="detail-meta-label">No. HP</span>
                    <span class="detail-meta-value" id="detailUserPhone">{{ $activeUser['phone'] }}</span>
                </div>

                <div class="detail-meta-row">
                    <i class="bi bi-calendar-check detail-meta-icon"></i>
                    <span class="detail-meta-label">Bergabung</span>
                    <span class="detail-meta-value" id="detailUserJoined">{{ $activeUser['joined'] }}</span>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- MODAL KONFIRMASI --}}
<div class="modal-overlay" id="modalStatusUser">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom" id="modalStatusTitle">Konfirmasi Perubahan</h3>
            <button class="modal-close-btn" data-modal="modalStatusUser">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-simple">
            <div id="modalStatusIcon" class="modal-icon-wrap">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <p class="modal-confirm-text">
                Apakah Anda yakin ingin <span id="modalActionText"></span> user <br><strong id="modalUserName"></strong>?
            </p>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" data-modal="modalStatusUser">Batal</button>
            <button class="btn-modal-submit" id="confirmStatusBtn">Ya, Proses</button>
        </div>
    </div>
</div>

@endsection