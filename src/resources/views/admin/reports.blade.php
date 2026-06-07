@extends('layouts-admin.app')

@section('title', 'Daftar Laporan - SeMart')

@push('styles')
    @vite('resources/css/pages/reports.css')
@endpush

@push('scripts')
    @vite('resources/js/admin/reports.js')
@endpush

@section('content')

@php
$reports = [
    [
        'id'             => 1,
        'product_name'   => 'Jaket Denim Pria',
        'category'       => 'Pakaian',
        'image'          => 'https://images.unsplash.com/photo-1551537482-f2075a1d41f2?w=80&q=80',
        'detail_image'   => 'https://images.unsplash.com/photo-1551537482-f2075a1d41f2?w=600&q=80',
        'seller_name'    => 'Andi Pratama',
        'seller_handle'  => '@andi.pratama',
        'price'          => 'Rp120.000',
        'condition'      => 'Bekas Seperti Baru',
        'pelapor_name'   => 'Budi Santoso',
        'pelapor_handle' => '@budi.santoso',
        'date'           => '05 Juni 2026',
        'time'           => '09:14 WIB',
        'status'         => 'menunggu',
        'alasan'         => 'Foto produk tidak sesuai dengan kondisi asli barang. Barang yang saya terima jauh berbeda dari foto yang dipasang.',
        'peringatan'     => null,
    ],
    [
        'id'             => 2,
        'product_name'   => 'Tas Ransel Eiger Original',
        'category'       => 'Sepatu & Tas',
        'image'          => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=80&q=80',
        'detail_image'   => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=600&q=80',
        'seller_name'    => 'Siti Aisyah',
        'seller_handle'  => '@siti.aisyah',
        'price'          => 'Rp175.000',
        'condition'      => 'Bekas Baik',
        'pelapor_name'   => 'Dewi Lestari',
        'pelapor_handle' => '@dewi.lestari',
        'date'           => '03 Juni 2026',
        'time'           => '14:30 WIB',
        'status'         => 'ditindaklanjuti',
        'alasan'         => 'Seller tidak merespons pesan selama lebih dari 5 hari setelah pembayaran dilakukan.',
        'peringatan'     => 'Anda mendapatkan peringatan dari admin SeMart karena tidak merespons pembeli dalam waktu yang wajar. Harap segera konfirmasi setiap transaksi dalam 1x24 jam. Pelanggaran berulang dapat mengakibatkan pembekuan akun.',
    ],
    [
        'id'             => 3,
        'product_name'   => 'Kalkulator Casio fx-991EX',
        'category'       => 'Elektronik',
        'image'          => 'https://images.unsplash.com/photo-1564466809058-bf4114d55352?w=80&q=80',
        'detail_image'   => 'https://images.unsplash.com/photo-1564466809058-bf4114d55352?w=600&q=80',
        'seller_name'    => 'Budi Santoso',
        'seller_handle'  => '@budi.santoso',
        'price'          => 'Rp85.000',
        'condition'      => 'Bekas Seperti Baru',
        'pelapor_name'   => 'Nabila Putri',
        'pelapor_handle' => '@nabila.putri',
        'date'           => '01 Juni 2026',
        'time'           => '11:05 WIB',
        'status'         => 'ditolak',
        'alasan'         => 'Laporan dianggap tidak valid karena tidak disertai bukti pendukung yang cukup.',
        'peringatan'     => null,
    ],
    [
        'id'             => 4,
        'product_name'   => 'Buku Atomic Habits',
        'category'       => 'Buku',
        'image'          => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=80&q=80',
        'detail_image'   => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=600&q=80',
        'seller_name'    => 'Dewi Lestari',
        'seller_handle'  => '@dewi.lestari',
        'price'          => 'Rp90.000',
        'condition'      => 'Bekas Layak Pakai',
        'pelapor_name'   => 'Clara Renata',
        'pelapor_handle' => '@clara.renata',
        'date'           => '28 Mei 2026',
        'time'           => '16:22 WIB',
        'status'         => 'menunggu',
        'alasan'         => 'Harga yang diminta lebih tinggi dari yang tertera di listing setelah pembeli menghubungi seller.',
        'peringatan'     => null,
    ],
];

$statusLabels = [
    'menunggu'         => 'Menunggu',
    'ditindaklanjuti'  => 'Ditindaklanjuti',
    'ditolak'          => 'Ditolak',
];

$defaultReport = $reports[0];
@endphp

{{-- PAGE HEADER --}}
<section class="page-header-section">
    <h1 class="page-title">Daftar Laporan</h1>
    <p class="page-subtitle">Kelola laporan pelanggaran dari pengguna SeMart</p>
</section>

{{-- TWO-PANEL LAYOUT --}}
<div class="report-layout">

    {{-- LEFT PANEL --}}
    <div class="panel-left">

        <div class="table-wrapper">
            <table class="report-table">
                <thead>
                    <tr>
                        <th class="col-barang">Nama Barang</th>
                        <th class="col-pelapor">Pelapor</th>
                        <th class="col-status">Status</th>
                        <th class="col-tanggal">Tanggal Laporan</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody id="reportTableBody">
                    @foreach($reports as $index => $report)
                    <tr class="report-row {{ $index === 0 ? 'active-row' : '' }}"
                        data-id="{{ $report['id'] }}"
                        data-report="{{ json_encode($report) }}">

                        {{-- Nama Barang --}}
                        <td class="col-barang">
                            <div class="product-cell">
                                <div class="product-thumb">
                                    <img src="{{ $report['image'] }}" alt="{{ $report['product_name'] }}">
                                </div>
                                <div class="product-cell-info">
                                    <span class="product-cell-name">{{ $report['product_name'] }}</span>
                                    <span class="product-cat-badge">{{ $report['category'] }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Pelapor --}}
                        <td class="col-pelapor">
                            <span class="pelapor-name">{{ $report['pelapor_name'] }}</span>
                            <span class="pelapor-handle">{{ $report['pelapor_handle'] }}</span>
                        </td>

                        {{-- Status --}}
                        <td class="col-status">
                            <span class="status-badge status-{{ $report['status'] }}">
                                {{ $statusLabels[$report['status']] }}
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td class="col-tanggal">
                            <span class="date-text">{{ $report['date'] }}</span>
                            <span class="time-text">{{ $report['time'] }}</span>
                        </td>

                        {{-- Aksi --}}
                        <td class="col-aksi">
                            <button class="btn-detail {{ $index === 0 ? 'active' : '' }}"
                                    data-id="{{ $report['id'] }}">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="table-footer">
            <span class="table-info">Menampilkan 1–{{ count($reports) }} dari {{ count($reports) }} laporan</span>
            <div class="pagination-wrap">
                <button class="page-btn" disabled aria-label="Previous">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="page-btn active">1</button>
                <button class="page-btn" aria-label="Next">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </div>

    </div>

    {{-- RIGHT PANEL --}}
    <div class="panel-right" id="panelRight">
        <div class="detail-card" id="detailCard">

            <h3 class="detail-section-title">Detail Laporan</h3>

            {{-- Gallery --}}
            <div class="detail-gallery">
                <div class="detail-main-img-wrap">
                    <img src="{{ $defaultReport['detail_image'] }}"
                         alt="{{ $defaultReport['product_name'] }}"
                         class="detail-main-img"
                         id="detailMainImg">
                </div>
                <div class="detail-thumbnails" id="detailThumbnails">
                    <button class="thumb-btn active" data-src="{{ $defaultReport['detail_image'] }}">
                        <img src="{{ $defaultReport['image'] }}" alt="">
                    </button>
                </div>
            </div>

            {{-- Product Info --}}
            <div class="detail-info">
                <h2 class="detail-product-name" id="detailName">{{ $defaultReport['product_name'] }}</h2>
                <p class="detail-product-price" id="detailPrice">{{ $defaultReport['price'] }}</p>

                <div class="detail-meta-list">
                    <div class="detail-meta-row">
                        <i class="bi bi-shop detail-meta-icon"></i>
                        <span class="detail-meta-label">Seller</span>
                        <div class="detail-meta-value">
                            <span class="dv-name" id="detailSellerName">{{ $defaultReport['seller_name'] }}</span>
                            <span class="dv-handle" id="detailSellerHandle">{{ $defaultReport['seller_handle'] }}</span>
                        </div>
                    </div>
                    <div class="detail-meta-row">
                        <i class="bi bi-tag detail-meta-icon"></i>
                        <span class="detail-meta-label">Kategori</span>
                        <span class="detail-meta-value" id="detailKategori">{{ $defaultReport['category'] }}</span>
                    </div>
                    <div class="detail-meta-row">
                        <i class="bi bi-stars detail-meta-icon"></i>
                        <span class="detail-meta-label">Kondisi</span>
                        <span class="detail-meta-value" id="detailKondisi">{{ $defaultReport['condition'] }}</span>
                    </div>
                    <div class="detail-meta-row">
                        <i class="bi bi-person detail-meta-icon"></i>
                        <span class="detail-meta-label">Dilaporkan</span>
                        <span class="detail-meta-value" id="detailDilaporkan">{{ $defaultReport['date'] }}, {{ $defaultReport['time'] }}</span>
                    </div>
                </div>

                {{-- Alasan Laporan --}}
                <div class="detail-alasan-block">
                    <p class="detail-alasan-label">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        Alasan Laporan
                    </p>
                    <p class="detail-alasan-text" id="detailAlasan">{{ $defaultReport['alasan'] }}</p>
                </div>

                {{-- Action Area (status-aware, dirender oleh JS) --}}
                <div class="detail-action-area" id="detailActionArea"></div>
            </div>

        </div>
    </div>

</div>

{{-- MODAL: KONFIRMASI TINDAKLANJUTI --}}
<div class="modal-overlay" id="modalTindaklanjuti">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Konfirmasi Tindak Lanjut</h3>
            <button class="modal-close-btn" data-modal="modalTindaklanjuti">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-simple">
            <div class="modal-icon-success">
                <i class="bi bi-send-check-fill"></i>
            </div>
            <p class="modal-confirm-text">
                Kirim peringatan ke seller <strong id="modalTindakSellerName"></strong> terkait laporan barang <strong id="modalTindakProductName"></strong>?
            </p>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" data-modal="modalTindaklanjuti">Batal</button>
            <button class="btn-modal-confirm-tindak" id="btnConfirmTindak">
                <i class="bi bi-send"></i> Ya, Kirim Peringatan
            </button>
        </div>
    </div>
</div>

{{-- MODAL: KONFIRMASI TOLAK LAPORAN --}}
<div class="modal-overlay" id="modalTolakLaporan">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Konfirmasi Tolak Laporan</h3>
            <button class="modal-close-btn" data-modal="modalTolakLaporan">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-simple">
            <div class="modal-icon-danger">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <p class="modal-confirm-text">
                Tolak laporan untuk barang <strong id="modalTolakProductName"></strong>?
                Laporan ini akan ditandai sebagai tidak valid.
            </p>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" data-modal="modalTolakLaporan">Batal</button>
            <button class="btn-modal-confirm-tolak" id="btnConfirmTolak">
                <i class="bi bi-x-circle"></i> Ya, Tolak Laporan
            </button>
        </div>
    </div>
</div>

@endsection