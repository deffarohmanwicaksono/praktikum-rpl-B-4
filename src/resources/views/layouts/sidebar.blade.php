<aside class="sidebar" id="sidebar">

    <nav class="sidebar-nav">

        <ul class="nav-list">

            {{-- BERANDA --}}
            <li class="nav-item {{ (request()->routeIs('home') || request('from') == 'home') ? 'active' : '' }}">
                <a href="{{ route('home') }}" class="nav-link-custom">
                    <i class="bi bi-house-door-fill"></i>
                    <span>Beranda</span>
                </a>
            </li>

            {{-- PENCARIAN --}}
            <li class="nav-item {{ (request()->routeIs('products.search') || request('from') == 'search' || (request()->routeIs('products.detail-product') && request('from') != 'home')) ? 'active' : '' }}">
                <a href="{{ route('products.search') }}" class="nav-link-custom">
                    <i class="bi bi-search"></i>
                    <span>Pencarian</span>
                </a>
            </li>

            {{-- WISHLIST --}}
            <li class="nav-item {{ request()->routeIs('wishlist') ? 'active' : '' }}">
                <a href="{{ route('wishlist') }}" class="nav-link-custom">
                    <i class="bi bi-heart"></i>
                    <span>Wishlist</span>
                </a>
            </li>

            {{-- CHAT --}}
            <li class="nav-item {{ request()->routeIs('chat') ? 'active' : '' }}">
                <a href="{{ route('chat') }}" class="nav-link-custom">
                    <i class="bi bi-chat-dots"></i>
                    <span>Chat</span>
                </a>
            </li>

            {{-- NOTIFIKASI --}}
            <li class="nav-item {{ request()->routeIs('notification') ? 'active' : '' }}">
                <a href="{{ route('notification') }}" class="nav-link-custom">
                    <i class="bi bi-bell"></i>
                    <span>Notifikasi</span>
                    <span class="nav-badge">3</span>
                </a>
            </li>

            {{-- RIWAYAT PEMBELIAN --}}
            <li class="nav-item {{ request()->routeIs('purchase.history') ? 'active' : '' }}">
                <a href="{{ route('purchase.history') }}" class="nav-link-custom">
                    <i class="bi bi-bag-check"></i>
                    <span>Riwayat Pembelian</span>
                </a>
            </li>

            {{-- RIWAYAT PENJUALAN --}}
            <li class="nav-item {{ request()->routeIs('sales.history') ? 'active' : '' }}">
                <a href="{{ route('sales.history') }}" class="nav-link-custom">
                    <i class="bi bi-receipt"></i>
                    <span>Riwayat Penjualan</span>
                </a>
            </li>

            {{-- DASHBOARD SELLER --}}
            <li class="nav-item {{ request()->routeIs('seller.*') ? 'active' : '' }}">
                <a href="{{ route('seller.dashboard-seller') }}" class="nav-link-custom">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard Seller</span>
                </a>
            </li>

            {{-- PROFIL --}}
            <li class="nav-item {{ request()->routeIs('profile.profileuser') ? 'active' : '' }}">
                <a href="{{ route('profile.profileuser') }}" class="nav-link-custom">
                    <i class="bi bi-person-circle"></i>
                    <span>Profil</span>
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