<header class="topbar">

    <div class="topbar-inner">

        {{-- LEFT --}}
        <div class="topbar-left">

            <button
                class="hamburger-btn"
                id="sidebarToggle"
                aria-label="Toggle Sidebar"
                aria-expanded="true"
            >
                <span class="ham-line"></span>
                <span class="ham-line"></span>
                <span class="ham-line"></span>
            </button>

            <a
                href="{{ route('home') }}"
                class="brand-logo"
            >
                <img
                    src="{{ asset('images/New SeMart Logo.png') }}"
                    alt="SeMart Logo"
                    class="main-logo-img"
                >
            </a>

        </div>

        {{-- CENTER --}}
        <div class="topbar-search">

            <form
                action="{{ route('products.search') }}"
                method="GET"
                class="search-wrapper"
            >

                <i class="bi bi-search search-icon"></i>

                <input
                    type="text"
                    name="q"
                    class="search-input"
                    placeholder="Cari barang, kategori, atau keyword..."
                    value="{{ request('q') }}"
                    autocomplete="off"

                    @if (!request()->routeIs('products.search'))
                        onclick="window.location.href='{{ route('products.search') }}'"
                    @endif
                >

                <button
                    type="submit"
                    class="search-btn"
                    aria-label="Cari"
                >
                    <i class="bi bi-search"></i>
                </button>

            </form>

        </div>

        {{-- RIGHT --}}
        <div class="topbar-actions">

            {{-- WISHLIST --}}
            <a
                href="{{ route('wishlist') }}"
                class="action-btn {{ request()->routeIs('wishlist') ? 'active' : '' }}"
            >
                <i class="bi bi-heart"></i>
                <span>Wishlist</span>
            </a>

            {{-- CHAT --}}
            <a
                href="{{ route('chat.list') }}"
                class="action-btn {{
                    request()->routeIs('chat.*')
                    && request('from') != 'search'
                        ? 'active'
                        : ''
                }}"
            >
                <i class="bi bi-chat-dots"></i>
                <span>Chat</span>
            </a>

            {{-- NOTIFICATION --}}
            <a
                href="{{ route('notification') }}"
                class="action-btn {{ request()->routeIs('notification') ? 'active' : '' }}"
            >

                <div class="notif-icon-wrapper">
                    <i class="bi bi-bell"></i>
                    <span class="notif-badge">3</span>
                </div>

                <span>Notifikasi</span>

            </a>

            {{-- USER --}}
            <div class="user-profile-direct">

                <a
                    href="{{ route('profile.profileuser') }}"
                    class="user-btn-link"
                    aria-label="Profil Saya"
                >
                    <i class="bi bi-person-circle user-profile-icon"></i>

                    <span class="user-name">
                        Hai, {{ auth()->user()->name ?? 'User' }}
                    </span>
                </a>

            </div>

        </div>

</header>