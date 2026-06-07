<aside class="sidebar" id="sidebar">

    <nav class="sidebar-nav">

        <ul class="nav-list">

            {{-- DASHBOARD ADMIN --}}
            <li class="nav-item {{ request()->routeIs('admin.dashboard-admin') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard-admin') }}" class="nav-link-custom">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Dashboard Admin</span>
                </a>
            </li>

            {{-- VERIFIKASI BARANG --}}
            <li class="nav-item {{ request()->routeIs('admin.verification') ? 'active' : '' }}">
                <a href="{{ route('admin.verification') }}" class="nav-link-custom">
                    <i class="bi bi-patch-check"></i>
                    <span>Verifikasi Barang</span>
                </a>
            </li>

            {{-- DAFTAR LAPORAN --}}
            <li class="nav-item {{ request()->routeIs('admin.reports') ? 'active' : '' }}">
                <a href="{{ route('admin.reports') }}" class="nav-link-custom">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                    <span>Daftar Laporan</span>
                </a>
            </li>

            {{-- DAFTAR USER --}}
            <li class="nav-item {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <a href="{{ route('admin.users') }}" class="nav-link-custom">
                    <i class="bi bi-people"></i>
                    <span>Daftar User</span>
                </a>
            </li>

            {{-- DAFTAR PRODUK --}}
            <li class="nav-item {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                <a href="{{ route('admin.products') }}" class="nav-link-custom">
                    <i class="bi bi-box-seam"></i>
                    <span>Daftar Produk</span>
                </a>
            </li>

            {{-- DAFTAR TRANSAKSI --}}
            <li class="nav-item {{ request()->routeIs('admin.transactions') ? 'active' : '' }}">
                <a href="{{ route('admin.transactions') }}" class="nav-link-custom">
                    <i class="bi bi-receipt-cutoff"></i>
                    <span>Daftar Transaksi</span>
                </a>
            </li>

        </ul>

        <div class="sidebar-divider"></div>

        {{-- LOGOUT --}}
        <ul class="nav-list">
            <li class="nav-item">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link-custom nav-logout border-0 bg-transparent w-100 text-start">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>

    </nav>

</aside>

<div class="sidebar-overlay" id="sidebarOverlay"></div>