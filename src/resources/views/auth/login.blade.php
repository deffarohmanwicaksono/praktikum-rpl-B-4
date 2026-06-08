@extends('layouts.auth')

@section('title', 'Login - SeMart')

@section('content')

<div class="login-wrapper">

    {{-- Left Section --}}
    <div class="left-panel d-flex flex-column justify-content-between">

        <div class="brand-logo">
            <img
                src="{{ asset('images/New SeMart Logo.png') }}"
                alt="SeMart Logo"
                class="main-logo-img"
            >
        </div>

        <div class="brand-headline">
            <h1 class="headline-main">
                Marketplace Barang Bekas <br>
                Untuk <span class="headline-uns">Mahasiswa UNS</span>
            </h1>

            <p class="headline-sub">
                Jual beli aman, mudah, dan terpercaya
                untuk mahasiswa oleh mahasiswa.
            </p>
        </div>

        <div class="illustration-wrap">
            <img
                src="{{ asset('images/Elemen-1.png') }}"
                alt="Ilustrasi Mahasiswa SeMart"
                class="brand-illustration"
            >
        </div>

        <div class="feature-badges d-flex gap-4">

            <div class="badge-item">
                <i class="bi bi-check-circle-fill"></i>
                <span>Aman & Terpercaya</span>
            </div>

            <div class="badge-item">
                <i class="bi bi-mortarboard-fill"></i>
                <span>Khusus Mahasiswa UNS</span>
            </div>

        </div>

    </div>

    {{-- Right Section --}}
    <div class="right-panel d-flex align-items-center justify-content-center">

        <div class="login-card">

            <div class="card-header-section">

                <h2 class="card-title">
                    Login ke <span class="title-accent">SeMart</span>
                </h2>

                <p class="card-subtitle">
                    Masuk untuk mulai jual beli sekarang
                </p>

            </div>

            <form
                action="{{ route('login.process') }}"
                method="POST"
                class="login-form"
                id="loginForm"
            >
                @csrf

                {{-- Global Login Error --}}
                @if ($errors->has('login'))
                    <div class="alert-login-error">
                        {{ $errors->first('login') }}
                    </div>
                @endif

                {{-- Email --}}
                <div class="form-group-custom">

                    <label for="email" class="form-label-custom">
                        Email SSO UNS
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            <i class="bi bi-envelope"></i>
                        </span>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control-custom @error('email') is-invalid @enderror"
                            placeholder="email@student.uns.ac.id"
                            autocomplete="email"
                            value="{{ old('email') }}"
                            autofocus
                        >

                    </div>

                    @error('email')
                        <small class="error-text">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                {{-- Password --}}
                <div class="form-group-custom">

                    <label for="password" class="form-label-custom">
                        Password
                    </label>

                    <div class="input-wrapper">

                        <span class="input-icon">
                            <i class="bi bi-lock"></i>
                        </span>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control-custom @error('password') is-invalid @enderror"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                        >

                        <button
                            type="button"
                            class="input-icon-right"
                            id="togglePasswordButton"
                            aria-label="Toggle Password Visibility"
                        >
                            <i class="bi bi-eye" id="passwordIcon"></i>
                        </button>

                    </div>

                    @error('password')
                        <small class="error-text">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                <div class="forgot-password-row">
                    <a href="#" class="forgot-link" id="forgotPasswordLink">
                        Lupa Password?
                    </a>
                </div>

                <button
                    type="submit"
                    class="btn-login"
                    id="loginButton"
                >
                    <span id="loginButtonText">
                        Login
                    </span>
                </button>

            </form>

            <div class="card-footer-section">

                <p class="footer-text">
                    Belum punya akun?

                    <a href="#" class="footer-link" id="contactAdminLink">
                        Hubungi admin kampus
                    </a>
                </p>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forgotLink = document.getElementById('forgotPasswordLink');
        const emailInput = document.getElementById('email');

        if (forgotLink && emailInput) {
            forgotLink.addEventListener('click', function(event) {
                event.preventDefault();
                const emailValue = emailInput.value.trim();

                if (emailValue.endsWith('@student.uns.ac.id')) {
                    Swal.fire({
                        title: 'Simulasi Pemulihan Akun',
                        html: `Sistem mendeteksi komponen akun dummy mahasiswa UNS.<br><br>
                               <strong>Email:</strong> ${emailValue}<br>
                               <strong>Password Default:</strong> password123`,
                        icon: 'info',
                        confirmButtonText: 'Saya Mengerti',
                        confirmButtonColor: '#002855'
                    });
                }
            });
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forgotLink = document.getElementById('forgotPasswordLink');
        const emailInput = document.getElementById('email');
        // Ambil elemen baru untuk link admin
        const contactAdminLink = document.getElementById('contactAdminLink');

        // Logika Lupa Password (yang sudah dibuat sebelumnya)
        if (forgotLink && emailInput) {
            forgotLink.addEventListener('click', function(event) {
                event.preventDefault();
                const emailValue = emailInput.value.trim();

                if (emailValue.endsWith('@student.uns.ac.id')) {
                    Swal.fire({
                        title: 'Simulasi Pemulihan Akun',
                        html: `Sistem mendeteksi komponen akun dummy mahasiswa UNS.<br><br>
                               <strong>Email:</strong> ${emailValue}<br>
                               <strong>Password Default:</strong> password123`,
                        icon: 'info',
                        confirmButtonText: 'Saya Mengerti',
                        confirmButtonColor: '#002855'
                    });
                }
            });
        }

        if (contactAdminLink) {
            contactAdminLink.addEventListener('click', function(event) {
                event.preventDefault(); 

                Swal.fire({
                    title: 'Pendaftaran Akun Baru',
                    html: `Untuk mahasiswa UNS yang belum memiliki akun di SeMart, <br>
                           silakan daftarkan diri Anda melalui Unit Pelayanan TI Kampus atau hubungi:<br><br>
                           <strong>Email Admin:</strong> admin.semart@uns.ac.id<br>
                           <strong>Lokasi:</strong> Gedung UPT Teknologi Informasi dan Komunikasi UNS`,
                    icon: 'question',
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#002855'
                });
            });
        }
    });
</script>
@endsection
