@extends('layouts.app')

@section('title', 'Dashboard Seller - SeMart')

{{-- PAGE CSS --}}
@push('styles')
    @vite('resources/css/pages/dashboard-seller.css')
@endpush

{{-- PAGE JS --}}
@push('scripts')
    @vite('resources/js/seller/dashboard-seller.js')
@endpush

@section('content')

@php
// Data dummy produk seller
$sellerProducts = [
    [
        'id' => 1,
        'name' => 'Laptop Asus VivoBook X515',
        'price' => 'Rp 6.000.000',
        'status' => 'Menunggu',
        'status_class' => 'menunggu',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 2,
        'name' => 'Kamera Canon EOS M50',
        'price' => 'Rp 4.500.000',
        'status' => 'Menunggu',
        'status_class' => 'menunggu',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 3,
        'name' => 'Headphone Sony WH-1000XM4',
        'price' => 'Rp 3.200.000',
        'status' => 'Dijual',
        'status_class' => 'dijual',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 4,
        'name' => 'Smartwatch Xiaomi Mi Band 7',
        'price' => 'Rp 500.000',
        'status' => 'Dijual',
        'status_class' => 'dijual',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 5,
        'name' => 'Keyboard Mechanical RGB',
        'price' => 'Rp 850.000',
        'status' => 'Dijual',
        'status_class' => 'dijual',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 6,
        'name' => 'Mouse Logitech G102',
        'price' => 'Rp 250.000',
        'status' => 'Dijual',
        'status_class' => 'dijual',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 7,
        'name' => 'Monitor LG 24MP400',
        'price' => 'Rp 1.650.000',
        'status' => 'Sold Out',
        'status_class' => 'sold-out',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 8,
        'name' => 'Lampu Meja LED',
        'price' => 'Rp 120.000',
        'status' => 'Sold Out',
        'status_class' => 'sold-out',
        'image' => asset('images/Elemen-1.png'),
    ],
    [
        'id' => 9,
        'name' => 'Buku Atomic Habits',
        'price' => 'Rp 150.000',
        'status' => 'Ditolak',
        'status_class' => 'ditolak',
        'image' => asset('images/Elemen-1.png'),
    ],
];
@endphp

{{-- PAGE HEADER --}}
<section class="page-header">
    <div>
        <h1 class="page-title">Dashboard Seller</h1>
        <p class="page-subtitle">Kelola toko dan produk Anda dengan mudah.</p>
    </div>
</section>

{{-- BUTTON TAMBAH BARANG --}}
<section class="tambah-section">
    <a href="{{ route('seller.product.upload') }}" class="btn-tambah-barang" style="text-decoration: none;">
        <i class="bi bi-plus-lg"></i>
        Tambah Barang
    </a>
</section>

{{-- DAFTAR BARANG TABLE --}}
<section class="daftar-section">
    <div class="table-wrapper">
        <table class="barang-table">
            <thead>
                <tr>
                    <th class="col-nama">Nama</th>
                    <th class="col-harga">Harga</th>
                    <th class="col-status">Status</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sellerProducts as $product)
                    <tr class="table-row" data-row="{{ $product['id'] }}">
                        <td class="col-nama">
                            <div class="product-cell">
                                <div class="product-thumb">
                                    <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}">
                                </div>
                                <span class="product-cell-name">{{ $product['name'] }}</span>
                            </div>
                        </td>
                        <td class="col-harga">
                            <span class="price-text">{{ $product['price'] }}</span>
                        </td>
                        <td class="col-status">
                            <span class="status-badge {{ $product['status_class'] }}">
                                {{ $product['status'] }}
                            </span>
                        </td>
                        <td class="col-aksi">
                            <div class="aksi-group">
                                <a href="{{ route('seller.product.edit') }}" class="btn-aksi btn-edit">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <button class="btn-aksi btn-hapus">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                                @if($product['status_class'] === 'dijual')
                                    <button class="btn-aksi btn-tutup">
                                        <i class="bi bi-lock"></i> Tutup
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
            @empty
                    {{-- TAMPILAN JIKA DAFTAR BARANG KOSONG --}}
                    <tr>
                        <td colspan="4" class="empty-state-row">
                            <div class="no-results-inner">
                                
                                <svg viewBox="0 0 120 110" fill="none" xmlns="http://www.w3.org/2000/svg" class="no-results-svg">
                                    <circle cx="60" cy="50" r="40" fill="#DCEEFF" opacity="0.6"/>
                                    <rect x="32" y="42" width="56" height="44" rx="8" fill="#F3F9FF" stroke="#DCEEFF" stroke-width="2"/>
                                    <path d="M56 64H64M60 60V68" stroke="#3B9DF8" stroke-width="2" stroke-linecap="round"/>
                                </svg>

                                <h3 class="no-results-title">Belum ada produk nih</h3>
                                <p class="no-results-desc">Yuk, mulai tambah barang pertama kamu di SeMart!</p>

                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- STATUS LEGEND --}}
    <div class="status-legend">
        <div class="legend-item">
            <span class="legend-dot menunggu-dot"></span>
            <span class="legend-label menunggu-label">Menunggu</span>
            <span class="legend-desc">: barang yang sudah diajukan menunggu persetujuan admin</span>
        </div>
        <div class="legend-item">
            <span class="legend-dot dijual-dot"></span>
            <span class="legend-label dijual-label">Dijual</span>
            <span class="legend-desc">: barang telah disetujui oleh admin, menunggu pembeli</span>
        </div>
        <div class="legend-item">
            <span class="legend-dot sold-out-dot"></span>
            <span class="legend-label sold-out-label">Sold Out</span>
            <span class="legend-desc">: barang telah terjual, pembayaran berhasil, pembeli menerima barang</span>
        </div>
        <div class="legend-item">
            <span class="legend-dot ditolak-dot"></span>
            <span class="legend-label ditolak-label">Ditolak</span>
            <span class="legend-desc">: barang yang diajukan tidak disetujui oleh admin untuk dijual</span>
        </div>
    </div>
</section>

@endsection