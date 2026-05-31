@extends('layouts.app')

@section('title', 'Kirim Link Pembelian - SeMart')

@push('styles')
    @vite(['resources/css/pages/purchase-link.css'])
@endpush

@push('scripts')
    @vite(['resources/js/checkout/purchase-link.js'])
@endpush

@section('content')

@php

$purchase = [
    'product_name' => 'Laptop MacBook Air M1 2020',
    'product_price' => 7500000,
    'agreed_price' => 7200000,
    'product_condition' => 'Bekas Seperti Baru',
    'buyer_name' => 'Andi Pratama',
    'image' => asset('images/Elemen-1.png'),
    'payments' => [
        [
            'id' => 'pm_1',
            'type' => 'bank',
            'provider' => 'BCA',
            'label' => 'Transfer Bank – BCA',
            'key_label' => 'No. Rekening',
            'number' => '1234567890',
            'owner' => 'Andi Pratama',
            'icon' => 'bank2'
        ],
        [
            'id' => 'pm_2',
            'type' => 'ewallet',
            'provider' => 'DANA',
            'label' => 'E-Wallet – DANA',
            'key_label' => 'No. HP',
            'number' => '081234567890',
            'owner' => 'Andi Pratama',
            'icon' => 'phone'
        ]
    ]
];
@endphp

<script>
window.purchaseData = {
    listingPrice: {{ $purchase['product_price'] }}
};
</script>

<div class="form-layout">

    {{-- Info Produk --}}
    <div class="section-card" id="sectionProductInfo">
        <h2 class="section-title">Kirim Link Pembelian</h2>

        <div class="order-product-row">
            <div class="order-img-wrap">
                <img src="{{ $purchase['image'] }}"
                    alt="{{ $purchase['product_name'] }}" class="order-img">
            </div>
            <div class="order-product-info">
                <h3 class="order-product-name">{{ $purchase['product_name'] }}</h3>
                <p class="order-product-price">Rp {{ number_format($purchase['product_price'], 0, ',', '.') }}</p>
                <div class="condition-row">
                    <span class="cond-pill">{{ $purchase['product_condition'] }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Harga Sepakat --}}
    <div class="section-card">
        <div class="form-section-header">
            <div class="form-section-num">1</div>
            <div>
                <h2 class="section-title mb-0">Harga Hasil Kesepakatan</h2>
                <p class="section-desc">Harga yang akan dibayarkan buyer dari hasil negosiasi di chat.</p>
            </div>
        </div>

        <div class="price-input-wrap">
            <span class="price-prefix">Rp</span>
            <input type="text" id="agreedPrice" class="price-input"
                   value="{{ number_format($purchase['agreed_price'], 0, ',', '.') }}" placeholder="0"
                   inputmode="numeric" autocomplete="off">
        </div>

        <div class="price-note" id="priceNote">
            <i class="bi bi-info-circle-fill"></i>
            <span>Harga listing: <strong>Rp {{ number_format($purchase['product_price'], 0, ',', '.') }}</strong> · Selisih:
                @php
                    $diff = $purchase['agreed_price'] - $purchase['product_price'];
                @endphp
                @if($diff < 0)
                    <span class="price-diff negative" id="priceDiff">–Rp {{ number_format(abs($diff), 0, ',', '.') }}</span>
                @elseif($diff > 0)
                    <span class="price-diff positive" id="priceDiff">+Rp {{ number_format($diff, 0, ',', '.') }}</span>
                @else
                    <span class="price-diff neutral" id="priceDiff">Sama dengan harga listing</span>
                @endif
            </span>
        </div>
    </div>

    {{-- Metode Pembayaran --}}
    <div class="section-card">
        <div class="form-section-header">
            <div class="form-section-num">2</div>
            <div>
                <h2 class="section-title mb-0">Metode Pembayaran</h2>
                <p class="section-desc">Tambahkan metode pembayaran yang dapat digunakan oleh buyer untuk melakukan pembayaran.</p>
            </div>
        </div>

        <div class="payment-method-list" id="paymentMethodList">
            @foreach($purchase['payments'] as $payment)
            <div class="pm-row" data-id="{{ $payment['id'] }}">
                <div class="pm-left">
                    <div class="pm-type-icon pm-icon--{{ $payment['type'] }}">
                        <i class="bi bi-{{ $payment['icon'] }}"></i>
                    </div>
                    <div class="pm-info">
                        <span class="pm-type-label">{{ $payment['label'] }}</span>
                        <div class="pm-detail-row">
                            <span class="pm-detail-key">{{ $payment['key_label'] }}</span>
                            <span class="pm-detail-val">{{ $payment['number'] }}</span>
                        </div>
                        <div class="pm-detail-row">
                            <span class="pm-detail-key">a/n</span>
                            <span class="pm-detail-val">{{ $payment['owner'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="pm-actions">
                    <button class="pm-btn pm-btn--edit" onclick="openEditModal('{{ $payment['id'] }}')">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                    <button class="pm-btn pm-btn--delete" onclick="deleteMethod('{{ $payment['id'] }}')">
                        <i class="bi bi-trash3"></i> Hapus
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        <div class="btn-add-pm-wrapper" style="margin-top: 16px;">
            <button class="add-method-btn" id="addMethodBtn" onclick="openAddModal()">
                <i class="bi bi-plus-circle"></i>
                Tambah Metode Pembayaran
            </button>
        </div>
    </div>

    {{-- Durasi Link --}}
    <div class="section-card">
        <div class="form-section-header">
            <div class="form-section-num">3</div>
            <div>
                <h2 class="section-title mb-0">Masa Berlaku Link</h2>
                <p class="section-desc">Pilih berapa waktu link aktif. Setelah waktu berakhir, link otomatis tidak valid.</p>
            </div>
        </div>

        <div class="duration-options" id="durationOptions">
            <label class="duration-option">
                <input type="radio" name="duration" value="15" hidden>
                <span class="duration-label">15 Menit</span>
            </label>
            <label class="duration-option">
                <input type="radio" name="duration" value="30" hidden>
                <span class="duration-label">30 Menit</span>
            </label>
            <label class="duration-option">
                <input type="radio" name="duration" value="60" hidden>
                <span class="duration-label">1 Jam</span>
            </label>
            <label class="duration-option selected">
                <input type="radio" name="duration" value="180" checked hidden>
                <span class="duration-label">3 Jam</span>
            </label>
            <label class="duration-option">
                <input type="radio" name="duration" value="360" hidden>
                <span class="duration-label">6 Jam</span>
            </label>
            <label class="duration-option">
                <input type="radio" name="duration" value="720" hidden>
                <span class="duration-label">12 Jam</span>
            </label>
            <label class="duration-option">
                <input type="radio" name="duration" value="1440" hidden>
                <span class="duration-label">24 Jam</span>
            </label>
        </div>

        <div class="deadline-preview">
            <i class="bi bi-clock"></i>
            <span>Link berlaku hingga: <strong id="deadlinePreview">—</strong></span>
        </div>
    </div>

    {{-- Catatan Seller --}}
    <div class="section-card">
        <div class="form-section-header">
            <div class="form-section-num">4</div>
            <div>
                <h2 class="section-title mb-0">Catatan untuk Buyer <span class="optional-chip">Opsional</span></h2>
                <p class="section-desc">Tambahkan catatan atau instruksi untuk buyer.</p>
            </div>
        </div>
        <textarea class="note-textarea" id="sellerNote"
                  placeholder="Contoh: Transfer ke BCA ya kak!"
                  maxlength="200"></textarea>
        <p class="note-char-counter">
            <span id="noteCharCount">0</span>/200
        </p>
    </div>

    {{-- Informasi Collapsible --}}
    <div class="info-collapsible" id="infoCollapsible">
        <button class="info-collapse-btn" id="infoToggleBtn" aria-expanded="true">
            <div class="info-btn-left">
                <i class="bi bi-info-circle-fill info-icon-blue"></i>
                <span>Informasi</span>
            </div>
            <i class="bi bi-chevron-up info-chevron" id="infoChevron"></i>
        </button>
        <div class="info-collapse-body" id="infoCollapseBody">
            <ul class="info-list">
                <li>Pastikan semua informasi sudah benar sebelum mengirim link.</li>
                <li>Buyer dapat melakukan pembayaran sesuai metode yang kamu isi.</li>
                <li>Setelah pembayaran berhasil, pesanan akan masuk ke menu Riwayat Penjualan.</li>
                <li>Link yang telah dikirim tidak dapat diedit, namun dapat dibatalkan.</li>
            </ul>
        </div>
    </div>

    <button class="submit-link-btn" id="submitLinkBtn">
        <i class="bi bi-send-fill"></i>
        Kirim Link ke Buyer
    </button>

</div>

{{-- MODALS --}}
{{-- Modal Tambah/Edit Metode Pembayaran --}}
<div class="modal-overlay" id="paymentMethodModal">
    <div class="modal-card">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom" id="modalMethodTitle">Tambah Metode Pembayaran</h3>
            <button class="modal-close-btn" id="closeMethodModal" aria-label="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-custom">

            <div class="form-group-custom">
                <label class="form-label-custom">Jenis Metode <span class="required-star">*</span></label>
                <select class="form-input-custom" id="methodType">
                    <option value="">Pilih jenis metode...</option>
                    <option value="bank">Transfer Bank</option>
                    <option value="ewallet">E-Wallet</option>
                </select>
            </div>

            <div class="form-group-custom" id="fieldProviderName">
                <label class="form-label-custom">Nama Bank / E-Wallet <span class="required-star">*</span></label>
                <input type="text" class="form-input-custom" id="methodProvider"
                       placeholder="Contoh: BCA, GoPay, DANA, OVO...">
            </div>

            <div class="form-group-custom" id="fieldAccountNum">
                <label class="form-label-custom" id="accountNumLabel">No. Rekening / No. HP <span class="required-star">*</span></label>
                <input type="text" class="form-input-custom" id="methodAccount"
                       placeholder="Masukkan nomor rekening atau nomor HP">
            </div>

            <div class="form-group-custom">
                <label class="form-label-custom">Atas Nama <span class="required-star">*</span></label>
                <input type="text" class="form-input-custom" id="methodOwner"
                       value="{{ Auth::user()->name ?? 'Andi Pratama' }}" placeholder="Nama pemilik rekening">
            </div>

        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" id="cancelMethodModal">Batal</button>
            <button class="btn-modal-submit" id="saveMethodBtn">
                <i class="bi bi-check-lg"></i> Simpan
            </button>
        </div>
    </div>
</div>

{{-- Modal Konfirmasi Kirim --}}
<div class="modal-overlay" id="confirmSendModal">
    <div class="modal-card modal-card--sm">
        <div class="modal-header-custom">
            <h3 class="modal-title-custom">Konfirmasi Kirim Link</h3>
            <button class="modal-close-btn" id="closeConfirmModal" aria-label="Tutup">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-custom">
            <div class="confirm-summary">
                <div class="cs-row">
                    <span class="cs-key">Produk</span>
                    <span class="cs-val">{{ $purchase['product_name'] }}</span>
                </div>
                <div class="cs-row">
                    <span class="cs-key">Buyer</span>
                    <span class="cs-val">{{ $purchase['buyer_name'] }}</span>
                </div>
                <div class="cs-row">
                    <span class="cs-key">Harga Disepakati</span>
                    <span class="cs-val cs-price" id="confirmPrice">Rp 7.200.000</span>
                </div>
                <div class="cs-row">
                    <span class="cs-key">Masa Berlaku</span>
                    <span class="cs-val" id="confirmDuration">3 Jam</span>
                </div>
            </div>
            <div class="info-alert alert--warn" style="margin-top:16px">
                <div class="al-icon al-icon--warn">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <div class="al-body">
                    <p class="al-text">Link yang sudah dikirim <strong>tidak dapat diedit</strong>. Pastikan semua data sudah benar.</p>
                </div>
            </div>
        </div>
        <div class="modal-footer-custom">
            <button class="btn-modal-cancel" id="cancelSendBtn">Periksa Lagi</button>
            <button class="btn-modal-submit" id="confirmSendBtn">
                <i class="bi bi-send-fill"></i> Ya, Kirim Sekarang
            </button>
        </div>
    </div>
</div>

{{-- Modal Sukses --}}
<div class="modal-overlay" id="successModal">
    <div class="modal-card modal-card--sm">
        <div class="modal-body-custom" style="text-align:center; padding: 36px 28px">
            <div class="success-icon-wrap">
                <div class="success-icon-circle">
                    <i class="bi bi-check-lg"></i>
                </div>
            </div>
            <h3 class="success-title">Link Berhasil Dikirim!</h3>
            <p class="success-desc">
                Link pembelian telah dikirim ke <strong>{{ $purchase['buyer_name'] }}</strong> melalui chat.
                Buyer akan segera melakukan pembayaran.
            </p>
        </div>
        <div class="modal-footer-custom" style="justify-content:center; padding-top:0; padding-bottom:24px">
            <a href="{{ route('chat.session') }}?pov=seller&link_sent=true" class="btn-modal-submit" id="backToChatBtn">
                <i class="bi bi-chat-dots"></i> Kembali ke Chat
            </a>
        </div>
    </div>
</div>

{{-- Toast Notifikasi --}}
<div class="toast-container-custom" id="toastContainer">
    <div class="toast-item-custom">
        <i class="bi bi-check-circle-fill toast-icon-green"></i>
        <span id="toastMsg">Berhasil</span>
    </div>
</div>

@endsection