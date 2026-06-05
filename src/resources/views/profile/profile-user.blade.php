@extends('layouts.app')

@section('title', 'Profil User - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite('resources/css/pages/profile-user.css')
@endpush

{{-- PAGE JS --}}
@push('scripts')
    @vite('resources/js/profile/profile-user.js')
@endpush

@section('content')

@php
    $user = [
        'name'      => 'Andi Pratama',
        'email'     => 'andi.pratama@student.uns.ac.id',
        'phone'     => '081234567890',
        'role'      => ['Seller', 'Buyer'],
        'status'    => 'Aktif',
        'joined'    => '12 Jan 2024',
        'avatar'    => asset('images/default-avatar.jpg'),

        'products'  => 24,
        'transactions' => 156,
        'rating'    => 4.2,
        'reviews'   => 12
    ];

    $isSeller = in_array('Seller', $user['role']);
@endphp

{{-- HEADER --}}
<section class="page-header-section">
    <div>
        <h1 class="page-title">Profil Anda</h1>
        <p class="page-subtitle">
            Informasi lengkap mengenai pengguna.
        </p>
    </div>
</section>

{{-- PROFILE CARD --}}
<section class="profile-card">

    <div class="profile-header">

        <div class="profile-avatar">
            <img src="{{ $user['avatar'] }}"
                 alt="{{ $user['name'] }}">
        </div>

        <div class="profile-info">

            <h2>{{ $user['name'] }}</h2>

            <div class="profile-role-list">

                @foreach($user['role'] as $role)
                    <span class="role-badge">
                        {{ $role }}
                    </span>
                @endforeach

            </div>

            <p class="profile-email">
                <i class="bi bi-envelope"></i>
                {{ $user['email'] }}
            </p>

            <p class="profile-joined">
                <i class="bi bi-calendar-event"></i>
                Bergabung sejak {{ $user['joined'] }}
            </p>

        </div>

    </div>

    {{-- STATS --}}
    <div class="profile-stats">

        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-bag"></i>
            </div>

            <div>
                <h3>{{ $user['products'] }}</h3>
                <p>Produk Dijual</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <i class="bi bi-graph-up"></i>
            </div>

            <div>
                <h3>{{ $user['transactions'] }}</h3>
                <p>Transaksi Selesai</p>
            </div>
        </div>

        @if($isSeller)
        <div class="stat-card">
            <div class="stat-icon yellow">
                <i class="bi bi-star"></i>
            </div>

            <div>
                <h3>{{ $user['rating'] }}</h3>
                <p>{{ $user['reviews'] }} Ulasan</p>
            </div>
        </div>
        @endif

    </div>

</section>

{{-- DETAIL CARD --}}
<section class="detail-card">

    <div class="detail-row">
        <div class="detail-label">
            <i class="bi bi-person-badge"></i>
            Role
        </div>

        <div class="detail-value">

            @foreach($user['role'] as $role)
                <span class="role-pill">
                    {{ $role }}
                </span>
            @endforeach

        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">
            <i class="bi bi-info-circle"></i>
            Status
        </div>

        <div class="detail-value">
            <span class="status-pill">
                {{ $user['status'] }}
            </span>
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">
            <i class="bi bi-telephone"></i>
            No. HP
        </div>

        <div class="detail-value">
            {{ $user['phone'] }}
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">
            <i class="bi bi-calendar-check"></i>
            Bergabung
        </div>

        <div class="detail-value">
            {{ $user['joined'] }}
        </div>
    </div>

</section>

@endsection