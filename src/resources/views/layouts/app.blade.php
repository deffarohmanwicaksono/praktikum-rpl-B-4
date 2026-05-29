<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SeMart')</title>

    <link rel="icon" type="image/png" href="{{ asset('images/SeMart Icon.png') }}">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- GLOBAL CSS --}}
    @vite([
        'resources/css/app.css'
    ])

    {{-- PAGE SPECIFIC CSS --}}
    @stack('styles')

</head>

<body>

    {{-- TOPBAR --}}
    @include('layouts.topbar')

    {{-- MAIN LAYOUT --}}
    <div class="main-layout" id="mainLayout">

        {{-- SIDEBAR --}}
        @include('layouts.sidebar')

        {{-- OVERLAY --}}
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        {{-- CONTENT --}}
        <main class="main-content" id="mainContent">
            @yield('content')
        </main>

    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- GLOBAL JS --}}
    @vite([
        'resources/js/app.js'
    ])

    {{-- PAGE SPECIFIC JS --}}
    @stack('scripts')

</body>
</html>