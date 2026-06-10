@extends('layouts-admin.app')

@section('title', 'Daftar Laporan - SeMart')

@push('styles')
    @vite('resources/css/pages/reports.css')
@endpush

@push('scripts')
    @vite('resources/js/admin/reports.js')
@endpush

@section('content')

<script>
    const reportData = @json($reportData);
</script>

@php
$statusLabels = [
    'menunggu'         => 'Menunggu',
    'ditindaklanjuti'  => 'Ditindaklanjuti',
    'ditolak'          => 'Ditolak',
];

$firstReport = $reports->first();
$firstReportData = $firstReport ? $reportData[$firstReport->id] : null;
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
                    @forelse($reports as $index => $report)
                    @php
                        $imageUrl = $report->product->productImages->first()->image_url ?? 'images/default-product.jpg';
                        if (!str_starts_with($imageUrl, 'http')) {
                            $imageUrl = str_starts_with($imageUrl, 'products/') ? asset('storage/' . $imageUrl) : asset($imageUrl);
                        }
                    @endphp
                    <tr class="report-row {{ $index === 0 ? 'active-row' : '' }}"
                        data-id="{{ $report->id }}">

                        {{-- Nama Barang --}}
                        <td class="col-barang">
                            <div class="product-cell">
                                <div class="product-thumb">
                                    <img src="{{ $imageUrl }}" alt="{{ $report->product->name ?? 'Produk' }}">
                                </div>
                                <div class="product-cell-info">
                                    <span class="product-cell-name">{{ $report->product->name ?? 'Produk dihapus' }}</span>
                                    <span class="product-cat-badge">{{ $report->product->category->name ?? 'Lainnya' }}</span>
                                </div>
                            </div>
                        </td>

                        {{-- Pelapor --}}
                        <td class="col-pelapor">
                            <span class="pelapor-name">{{ $report->user->name }}</span>
                            <span class="pelapor-handle">{{ '@' . explode('@', $report->user->email)[0] }}</span>
                        </td>

                        {{-- Status --}}
                        <td class="col-status">
                            <span class="status-badge status-{{ $report->status }}">
                                {{ $statusLabels[$report->status] ?? $report->status }}
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td class="col-tanggal">
                            <span class="date-text">{{ $report->created_at ? $report->created_at->format('d M Y') : '-' }}</span>
                            <span class="time-text">{{ $report->created_at ? $report->created_at->format('H:i') . ' WIB' : '' }}</span>
                        </td>

                        {{-- Aksi --}}
                        <td class="col-aksi">
                            <button class="btn-detail {{ $index === 0 ? 'active' : '' }}"
                                    data-id="{{ $report->id }}">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--gray-text);">
                            Belum ada laporan masuk dari pengguna.
                        </td>
                    </tr>
                    @endforelse
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
        @if($firstReportData)
        <div class="detail-card" id="detailCard">

            <h3 class="detail-section-title">Detail Laporan</h3>

            {{-- Gallery --}}
            <div class="detail-gallery">
                <div class="detail-main-img-wrap">
                    <img src="{{ $firstReportData['images'][0] ?? asset('images/default-product.jpg') }}"
                         alt="{{ $firstReportData['productName'] }}"
                         class="detail-main-img"
                         id="detailMainImg">
                </div>
                <div class="detail-thumbnails" id="detailThumbnails">
                    @foreach($firstReportData['images'] as $idx => $imgUrl)
                    <button class="thumb-btn {{ $idx === 0 ? 'active' : '' }}" data-src="{{ $imgUrl }}">
                        <img src="{{ $imgUrl }}" alt="">
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- Product Info --}}
            <div class="detail-info">
                <h2 class="detail-product-name" id="detailName">{{ $firstReportData['productName'] }}</h2>
                <p class="detail-product-price" id="detailPrice">{{ $firstReportData['price'] }}</p>

                <div class="detail-meta-list">
                    <div class="detail-meta-row">
                        <i class="bi bi-shop detail-meta-icon"></i>
                        <span class="detail-meta-label">Seller</span>
                        <div class="detail-meta-value">
                            <span class="dv-name" id="detailSellerName">{{ $firstReportData['sellerName'] }}</span>
                            <span class="dv-handle" id="detailSellerHandle">{{ $firstReportData['sellerHandle'] }}</span>
                        </div>
                    </div>
                    <div class="detail-meta-row">
                        <i class="bi bi-tag detail-meta-icon"></i>
                        <span class="detail-meta-label">Kategori</span>
                        <span class="detail-meta-value" id="detailKategori">{{ $firstReportData['category'] }}</span>
                    </div>
                    <div class="detail-meta-row">
                        <i class="bi bi-stars detail-meta-icon"></i>
                        <span class="detail-meta-label">Kondisi</span>
                        <span class="detail-meta-value" id="detailKondisi">{{ $firstReportData['condition'] }}</span>
                    </div>
                    <div class="detail-meta-row">
                        <i class="bi bi-person detail-meta-icon"></i>
                        <span class="detail-meta-label">Dilaporkan</span>
                        <span class="detail-meta-value" id="detailDilaporkan">{{ $firstReportData['dilaporkan'] }}</span>
                    </div>
                </div>

                {{-- Alasan Laporan --}}
                <div class="detail-alasan-block">
                    <p class="detail-alasan-label">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        Alasan Laporan
                    </p>
                    <p class="detail-alasan-text" id="detailAlasan">{{ $firstReportData['alasan'] }}</p>
                </div>

                {{-- Action Area (status-aware, dirender oleh JS) --}}
                <div class="detail-action-area" id="detailActionArea"></div>
            </div>

        </div>
        @else
        <div class="detail-card" style="display: flex; align-items: center; justify-content: center; height: 100%; color: var(--gray-text);">
            Tidak ada detail laporan untuk ditampilkan.
        </div>
        @endif
    </div>

</div>

@if($firstReport)
{{-- Hidden action forms --}}
<form id="formTindak" action="#" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="peringatan" id="tindakPeringatanInput">
</form>

<form id="formTolak" action="#" method="POST" style="display: none;">
    @csrf
</form>

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
@endif

@endsection