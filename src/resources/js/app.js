    /* ==============================================
       SIDEBAR
       ============================================== */

    const sidebarElement = document.getElementById('sidebar');
    const mainLayoutElement = document.getElementById('mainLayout');
    const sidebarToggleButton = document.getElementById('sidebarToggle');
    const sidebarOverlayElement = document.getElementById('sidebarOverlay');

    const closeSidebar = () => {
        if (!sidebarElement || !mainLayoutElement) return;

        sidebarElement.classList.add('collapsed');
        mainLayoutElement.classList.add('sidebar-collapsed');

        if (sidebarToggleButton) {
            sidebarToggleButton.setAttribute('aria-expanded', 'false');
        }
    };

    const toggleSidebar = () => {
        if (!sidebarElement || !mainLayoutElement) return;

        const isSidebarCollapsed = sidebarElement.classList.toggle('collapsed');

        mainLayoutElement.classList.toggle(
            'sidebar-collapsed',
            isSidebarCollapsed
        );

        if (sidebarToggleButton) {
            sidebarToggleButton.setAttribute(
                'aria-expanded',
                String(!isSidebarCollapsed)
            );
        }
    };

    if (sidebarToggleButton) {
        sidebarToggleButton.addEventListener(
            'click',
            toggleSidebar
        );
    }

    if (sidebarOverlayElement) {
        sidebarOverlayElement.addEventListener(
            'click',
            closeSidebar
        );
    }