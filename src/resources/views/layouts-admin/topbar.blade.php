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

        {{-- RIGHT --}}
        <div class="topbar-actions">

            {{-- USER --}}
            <div class="user-profile-direct">
                <div class="user-btn-link" style="cursor: default;" aria-label="Profil Admin">
                    <i class="bi bi-person-circle user-profile-icon"></i>

                    <span class="user-name">
                        Hai, {{ auth()->user()->name ?? 'Admin' }}
                    </span>
                </div>

            </div>

        </div>
        
    </div>

</header>