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
                    <a href="#" class="forgot-link">
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

                    <a href="#" class="footer-link">
                        Hubungi admin kampus
                    </a>
                </p>

            </div>

        </div>

    </div>

</div>

@endsection