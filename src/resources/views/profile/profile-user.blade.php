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
    $currentUser = auth()->user();
    $roleLabels = array_map('ucfirst', $currentUser->roles ?? ['buyer']);

    // Hitung produk yang dijual
    $productsCount = \App\Models\Product::where('user_id', $currentUser->id)->count();

    // Hitung transaksi selesai (sebagai buyer maupun seller)
    $transactionsCount = \App\Models\Transaction::where(function($q) use ($currentUser) {
        $q->where('buyer_id', $currentUser->id)
          ->orWhereHas('product', function($q2) use ($currentUser) {
              $q2->where('user_id', $currentUser->id);
          });
    })->where('status', 'selesai')->count();

    // Hitung ulasan
    $rating = 0;
    $reviewsCount = 0;
    if (class_exists(\App\Models\Review::class)) {
        $sellerProductIds = \App\Models\Product::where('user_id', $currentUser->id)->pluck('id');
        $reviewsQuery = \App\Models\Review::whereHas('transaction', function($q) use ($sellerProductIds) {
            $q->whereIn('product_id', $sellerProductIds);
        });
        $reviewsCount = $reviewsQuery->count();
        $rating = $reviewsCount > 0 ? round($reviewsQuery->avg('rating'), 1) : 0;
    }

    $user = [
        'name'      => $currentUser->name ?? 'User SeMart',
        'email'     => $currentUser->email,
        'phone'     => $currentUser->phone ?? '081234567890',
        'role'      => $roleLabels,
        'status'    => 'Aktif',
        'joined'    => $currentUser->created_at ? $currentUser->created_at->format('d M Y') : '12 Jan 2024',
        'avatar'    => asset('images/default-avatar.jpg'),

        'products'  => $productsCount,
        'transactions' => $transactionsCount,
        'rating'    => $rating ?: 4.2,
        'reviews'   => $reviewsCount ?: 12,
    ];

    $isSeller = in_array('Seller', $user['role']);
@endphp

{{-- HEADER --}}
<section class="page-header-section">
    <div>
        <h1 class="page-title">Profil Saya</h1>
        <p class="page-subtitle">
            Informasi lengkap mengenai pengguna.
        </p>
    </div>
</section>

{{-- PROFILE CARD --}}
<section class="profile-card">

    <div class="profile-header">

        {{-- AVATAR ICON --}}
        <div class="profile-avatar-icon">
            <i class="bi bi-person-fill"></i>
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

            <div class="profile-meta">
                <span class="profile-email">
                    <i class="bi bi-envelope"></i>
                    {{ $user['email'] }}
                </span>
                <span class="meta-divider">•</span>
                <span class="profile-joined">
                    <i class="bi bi-calendar-event"></i>
                    Bergabung {{ $user['joined'] }}
                </span>
            </div>

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
            <div class="stat-icon blue">
                <i class="bi bi-graph-up"></i>
            </div>
            <div>
                <h3>{{ $user['transactions'] }}</h3>
                <p>Transaksi Selesai</p>
            </div>
        </div>

        @if($isSeller)
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="bi bi-star"></i>
            </div>
            <div>
                <h3 class="rating-wrapper">
                    {{ $user['rating'] }}
                    <span class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($user['rating'] >= $i)
                                <i class="bi bi-star-fill"></i>
                            @elseif($user['rating'] >= $i - 0.5)
                                <i class="bi bi-star-half"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </span>
                </h3>
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
            <span class="status-pill status-{{ strtolower($user['status']) }}">
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
            <i class="bi bi-calendar-event"></i>
            Bergabung
        </div>

        <div class="detail-value">
            {{ $user['joined'] }}
        </div>
    </div>

</section>

@if(!$isSeller)
<div class="profile-action-btn-wrap" style="margin-top: 24px; text-align: center;">
    <form action="{{ route('profile.become-seller') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-family: 'Poppins', sans-serif; font-weight: 500; border-radius: 8px; background-color: #0d6efd; border: none; color: #fff; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
            <i class="bi bi-shop"></i> Aktifkan Fitur Penjual (Seller)
        </button>
    </form>
</div>
@endif

@endsection