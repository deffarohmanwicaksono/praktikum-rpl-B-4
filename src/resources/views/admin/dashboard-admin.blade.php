@extends('layouts-admin.app')

@section('title', 'Dashboard Admin - SeMart')

@push('styles')
    @vite('resources/css/pages/dashboard-admin.css')
@endpush

@push('scripts')
    @vite('resources/js/admin/dashboard-admin.js')
@endpush

@section('content')

@php
$stats = [
    [
        'label' => 'Total User',
        'value' => 128,
        'desc'  => 'jumlah akun terdaftar',
        'icon'  => 'bi-people-fill',
        'growth'=> '12.5%'
    ],
    [
        'label' => 'Total Produk',
        'value' => 74,
        'desc'  => 'per status barang',
        'icon'  => 'bi-box-seam-fill',
        'growth'=> '8.3%'
    ],
    [
        'label' => 'Total Transaksi',
        'value' => 39,
        'desc'  => 'semua transaksi',
        'icon'  => 'bi-cart-check-fill',
        'growth'=> '15.6%'
    ]
];
@endphp

<section class="page-header">
    <div>
        <h1 class="page-title">Dashboard Admin</h1>
        <p class="page-subtitle">
            Ringkasan informasi dan statistik platform SeMart
        </p>
    </div>
</section>

<section class="stat-cards-section">

    <div class="stat-cards-grid">

        @foreach($stats as $stat)
        <div class="stat-card">

            <div class="stat-card-inner">

                <div class="stat-icon-wrap">
                    <i class="bi {{ $stat['icon'] }}"></i>
                </div>

                <div class="stat-body">
                    <p class="stat-label">{{ $stat['label'] }}</p>

                    <p class="stat-value counter"
                       data-target="{{ $stat['value'] }}">
                        0
                    </p>

                    <p class="stat-desc">{{ $stat['desc'] }}</p>
                </div>

            </div>

            <div class="stat-card-footer">
                <span class="stat-growth positive">
                    <i class="bi bi-arrow-up-short"></i>
                    {{ $stat['growth'] }}
                </span>

                <span class="stat-growth-label">
                    dari bulan lalu
                </span>
            </div>

        </div>
        @endforeach

    </div>

</section>

<section class="chart-section">

    <div class="chart-card">

        <div class="chart-header">

            <div>
                <h2 class="chart-title">
                    Grafik Ringkasan
                </h2>

                <p class="chart-subtitle">
                    Tren Pertumbuhan Data
                </p>
            </div>

            <div class="period-dropdown-wrap">

                <button
                    class="period-trigger"
                    id="periodTrigger"
                >
                    <i class="bi bi-calendar3"></i>

                    <span id="periodLabel">
                        6 Bulan Terakhir
                    </span>

                    <i class="bi bi-chevron-down"></i>
                </button>

                <div
                    class="period-menu"
                    id="periodMenu"
                >
                    <button
                        class="period-option active"
                        data-period="6">
                        6 Bulan Terakhir
                    </button>

                    <button
                        class="period-option"
                        data-period="3">
                        3 Bulan Terakhir
                    </button>

                    <button
                        class="period-option"
                        data-period="12">
                        12 Bulan Terakhir
                    </button>
                </div>

            </div>

        </div>

        <div class="chart-legend">
            <span class="legend-dot-chart legend-user"></span>
            <span class="legend-text-chart">User</span>

            <span class="legend-dot-chart legend-produk"></span>
            <span class="legend-text-chart">Produk</span>
        </div>

        <div class="chart-canvas-wrap">
            <canvas id="growthChart"></canvas>
        </div>

    </div>

</section>

@endsection