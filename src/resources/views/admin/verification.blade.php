@extends('layouts-admin.app')

@section('title', 'Verifikasi Barang - SeMart')

@push('styles')
    @vite('resources/css/pages/verification.css')
@endpush

@push('scripts')
    @vite('resources/js/admin/verification.js')
@endpush

@section('content')

<script>
    const productData = @json($productData);
</script>

@php
$firstProduct = $products->first();
$firstProductData = $firstProduct ? $productData[$firstProduct->id] : null;
@endphp

{{-- =============================================
     PAGE HEADER
     ============================================= --}}
<section class="page-header-section">
    <div class="page-header-left">
        <h1 class="page-title">Verifikasi Barang</h1>
        <p class="page-subtitle">Pengajuan produk dari seller yang menunggu verifikasi</p>
    </div>
</section>

{{-- =============================================
     TWO-PANEL: Table + Detail
     ============================================= --}}
<div class="verif-layout">

    {{-- =========================================
         LEFT PANEL: Tabel Barang
         ========================================= --}}
    <div class="panel-left">

        {{-- Table Wrapper --}}
        <div class="table-wrapper">
            <table class="verif-table">
                <thead>
                    <tr>
                        <th class="col-nama">Nama Barang</th>
                        <th class="col-seller">Seller</th>
                        <th class="col-harga">Harga</th>
                        <th class="col-tanggal">Tanggal Pengajuan</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody id="verifTableBody">

                    @forelse($products as $index => $product)
                    @php
                        $imageUrl = $product->productImages->first()->image_url ?? 'images/default-product.jpg';
                        if (!str_starts_with($imageUrl, 'http')) {
                            $imageUrl = asset($imageUrl);
                        }
                    @endphp
                    <tr class="verif-row {{ $index === 0 ? 'active-row' : '' }}" data-id="{{ $product->id }}">
                        <td class="col-nama">
                            <div class="product-cell">
                                <div class="product-thumb">
                                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}">
                                </div>
                                <div class="product-cell-info">
                                    <span class="product-cell-name">{{ $product->name }}</span>
                                    <span class="product-cat-badge">{{ $product->category->name ?? 'Umum' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="col-seller">
                            <span class="seller-name">{{ $product->user->name }}</span>
                            <span class="seller-handle">{{ '@' . explode('@', $product->user->email)[0] }}</span>
                        </td>
                        <td class="col-harga">
                            <span class="price-text">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                        </td>
                        <td class="col-tanggal">
                            <span class="date-text">{{ $product->created_at->format('d M Y') }}</span>
                            <span class="time-text">{{ $product->created_at->format('H:i') }} WIB</span>
                        </td>
                        <td class="col-aksi">
                            <button class="btn-detail {{ $index === 0 ? 'active' : '' }}" data-id="{{ $product->id }}">
                                <i class="bi bi-eye"></i> Detail
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--gray-text);">
                            Belum ada pengajuan produk yang perlu diverifikasi.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination Info + Controls --}}
        <div class="table-footer">
            <span class="table-info">Menampilkan 1–{{ count($products) }} dari {{ count($products) }} pengajuan</span>
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

        @if($firstProduct)
        {{-- =========================================
             ALASAN PENOLAKAN
             ========================================= --}}
        <div class="alasan-section" id="alasanSection">
            <div class="alasan-header">
                <h3 class="alasan-title">Alasan Penolakan</h3>
                <p class="alasan-subtitle">Berikan alasan yang jelas (wajib diisi sebelum menolak)</p>
            </div>
            <textarea
                class="alasan-textarea"
                id="alasanInput"
                placeholder="Contoh: Foto kurang jelas, deskripsi tidak sesuai, dll."
                rows="4"
            ></textarea>
        </div>
        @endif

    </div>

    {{-- =========================================
         RIGHT PANEL: Detail Produk
         ========================================= --}}
    <div class="panel-right" id="panelRight">
        @if($firstProductData)
        <div class="detail-card" id="detailCard">

            <h3 class="detail-section-title">Detail Produk</h3>

            {{-- Image Gallery --}}
            <div class="detail-gallery">
                <div class="detail-main-img-wrap">
                    <img
                        src="{{ $firstProductData['images'][0] ?? asset('images/default-product.jpg') }}"
                        alt="{{ $firstProductData['name'] }}"
                        class="detail-main-img"
                        id="detailMainImg"
                    >
                    <span class="detail-img-counter" id="imgCounter">1 / {{ count($firstProductData['images']) }}</span>
                </div>

                {{-- Thumbnail Strip --}}
                <div class="detail-thumbnails" id="detailThumbnails">
                    @foreach($firstProductData['images'] as $idx => $imgUrl)
                    <button class="thumb-btn {{ $idx === 0 ? 'active' : '' }}" data-src="{{ $imgUrl }}">
                        <img src="{{ $imgUrl }}" alt="">
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- Product Info --}}
            <div class="detail-info">

                <h2 class="detail-product-name" id="detailName">{{ $firstProductData['name'] }}</h2>
                <p class="detail-product-price" id="detailPrice">{{ $firstProductData['price'] }}</p>

                {{-- Meta Rows --}}
                <div class="detail-meta-list">
                    <div class="detail-meta-row">
                        <i class="bi bi-person detail-meta-icon"></i>
                        <span class="detail-meta-label">Seller</span>
                        <div class="detail-meta-value">
                            <span class="dv-name" id="detailSellerName">{{ $firstProductData['seller'] }}</span>
                            <span class="dv-handle" id="detailSellerHandle">{{ $firstProductData['handle'] }}</span>
                        </div>
                    </div>
                    <div class="detail-meta-row">
                        <i class="bi bi-tag detail-meta-icon"></i>
                        <span class="detail-meta-label">Kategori</span>
                        <span class="detail-meta-value" id="detailKategori">{{ $firstProductData['kategori'] }}</span>
                    </div>
                    <div class="detail-meta-row">
                        <i class="bi bi-stars detail-meta-icon"></i>
                        <span class="detail-meta-label">Kondisi</span>
                        <span class="detail-meta-value" id="detailKondisi">{{ $firstProductData['kondisi'] }}</span>
                    </div>
                    <div class="detail-meta-row">
                        <i class="bi bi-clock detail-meta-icon"></i>
                        <span class="detail-meta-label">Diajukan</span>
                        <span class="detail-meta-value" id="detailDiajukan">{{ $firstProductData['diajukan'] }}</span>
                    </div>
                </div>

                {{-- Description --}}
                <div class="detail-desc-block">
                    <p class="detail-desc-label">Deskripsi</p>
                    <p class="detail-desc-text" id="detailDeskripsi">
                        {{ $firstProductData['deskripsi'] }}
                    </p>
                </div>

                {{-- Action Buttons: Setujui / Tolak --}}
                <div class="detail-actions">
                    <button class="btn-setujui" id="btnSetujui">
                        <i class="bi bi-check-circle"></i> Setujui
                    </button>
                    <button class="btn-tolak" id="btnTolak">
                        <i class="bi bi-x-circle"></i> Tolak
                    </button>
                </div>

            </div>

        </div>
        @else
        <div class="detail-card" style="display: flex; align-items: center; justify-content: center; height: 100%; color: var(--gray-text);">
            Tidak ada detail produk untuk ditampilkan.
        </div>
        @endif

    </div>

</div>

@if($firstProduct)
{{-- Hidden forms for verification --}}
<form id="formApprove" action="#" method="POST" style="display: none;">
    @csrf
</form>

<form id="formReject" action="#" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="alasan" id="rejectAlasanInput">
</form>

{{-- =============================================
     MODAL: KONFIRMASI SETUJUI
     ============================================= --}}
<div class="modal-overlay" id="modalSetujui">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Konfirmasi Persetujuan</h3>
            <button class="modal-close-btn" data-modal="modalSetujui">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-simple">
            <div class="modal-icon-success">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <p class="modal-confirm-text">
                Setujui barang <strong id="modalSetujuiName">{{ $firstProductData['name'] ?? '' }}</strong>
                untuk dipublikasikan di platform SeMart?
            </p>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" data-modal="modalSetujui">Batal</button>
            <button class="btn-modal-setujui">
                <i class="bi bi-check-circle"></i> Ya, Setujui
            </button>
        </div>
    </div>
</div>

{{-- =============================================
     MODAL: KONFIRMASI TOLAK
     ============================================= --}}
<div class="modal-overlay" id="modalTolak">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Konfirmasi Penolakan</h3>
            <button class="modal-close-btn" data-modal="modalTolak">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-simple">
            <div class="modal-icon-danger">
                <i class="bi bi-x-circle-fill"></i>
            </div>
            <p class="modal-confirm-text">
                Tolak pengajuan barang <strong id="modalTolakName">{{ $firstProductData['name'] ?? '' }}</strong>?
                Alasan akan dikirimkan ke seller.
            </p>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" data-modal="modalTolak">Batal</button>
            <button class="btn-modal-tolak">
                <i class="bi bi-x-circle"></i> Ya, Tolak
            </button>
        </div>
    </div>
</div>
@endif

@endsection