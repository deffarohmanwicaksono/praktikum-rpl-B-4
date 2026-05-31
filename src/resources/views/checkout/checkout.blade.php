@extends('layouts.app')

@section('title', 'Checkout - SeMart')

@push('styles')
@vite([
    'resources/css/pages/checkout.css'
])
@endpush

{{-- PAGE JS --}}
@push('scripts')
    @vite('resources/js/checkout/checkout.js')
@endpush

@section('content')

@php

$currentYear = date('Y');
$randomNumber = rand(10000, 99999);
$generatedOrderId = '#SM-' . $currentYear . '-' . $randomNumber;

$checkout = [

    'order_id' => $generatedOrderId,

    'product_name' => 'Laptop MacBook Air M1 2020',

    'product_price' => 7500000,

    'product_condition' => 'Bekas Seperti Baru',

    'seller_name' => 'Andi Pratama',

    'seller_note' =>
        'Harga telah disepakati sebesar Rp 7.500.000. Silakan lakukan pembayaran sebelum batas waktu berakhir dan upload bukti pembayaran untuk diverifikasi.',

    'image' => asset('images/Elemen-1.png'),

    'expired_at' =>
        now()->addDay()->timestamp * 1000,

    'payments' => [
        [
            'code' => 'bca',
            'type' => 'bank',
            'label' => 'Transfer Bank – BCA',
            'key' => 'No. Rekening',
            'number' => '1234567890',
            'owner' => 'Andi Pratama',
            'icon' => 'bank2'
        ],
        [
            'code' => 'shopeepay',
            'type' => 'ewallet',
            'label' => 'E-Wallet – ShopeePay',
            'key' => 'No. HP',
            'number' => '081234567890',
            'owner' => 'Andi Pratama',
            'icon' => 'phone'
        ],
        [
            'code' => 'gopay',
            'type' => 'ewallet',
            'label' => 'E-Wallet – GoPay',
            'key' => 'No. HP',
            'number' => '081234567890',
            'owner' => 'Andi Pratama',
            'icon' => 'phone'
        ],
        [
            'code' => 'ovo',
            'type' => 'ewallet',
            'label' => 'E-Wallet – OVO',
            'key' => 'No. HP',
            'number' => '081234567890',
            'owner' => 'Andi Pratama',
            'icon' => 'phone'
        ],
        [
            'code' => 'dana',
            'type' => 'ewallet',
            'label' => 'E-Wallet – DANA',
            'key' => 'No. HP',
            'number' => '081234567890',
            'owner' => 'Andi Pratama',
            'icon' => 'phone'
        ]
    ]
];
@endphp

<script>
window.checkoutData = {
    expiredAt: {{ $checkout['expired_at'] }}
};
</script>

<div class="checkout-layout">

    <div class="checkout-left">

        <div class="section-card">

            <h2 class="section-title">
                Ringkasan Pesanan
            </h2>

            <div class="order-product-row">

                <div class="order-img-wrap">
                    <img
                        src="{{ $checkout['image'] }}"
                        alt="{{ $checkout['product_name'] }}"
                        class="order-img"
                    >
                </div>

                <div class="order-product-info">

                    <h3 class="order-product-name">
                        {{ $checkout['product_name'] }}
                    </h3>

                    <p class="order-product-price">
                        Rp {{ number_format($checkout['product_price'],0,',','.') }}
                    </p>

                    <div class="condition-row">
                        <span class="cond-pill">
                            {{ $checkout['product_condition'] }}
                        </span>
                    </div>

                </div>

            </div>

            <div class="payment-total-card">

                <span>Total Pembayaran</span>

                <strong>
                    Rp {{ number_format($checkout['product_price'],0,',','.') }}
                </strong>

            </div>

            <div class="order-meta">

                <div class="om-row">
                    <span class="om-key">
                        Batas Pembayaran
                    </span>

                    <span
                        class="om-val om-deadline"
                        id="paymentDeadline"
                    >
                        30 Mei 2026 • 23:59 WIB
                    </span>
                </div>

                <div class="om-row">

                    <span class="om-key">
                        Seller
                    </span>

                    <span class="om-val seller-link">
                        {{ $checkout['seller_name'] }}
                    </span>

                </div>

                <div class="om-row om-note-row">

                    <span class="om-key">
                        Pesan Seller
                    </span>

                    <span class="om-val">
                        {{ $checkout['seller_note'] }}
                    </span>

                </div>

            </div>

        </div>

        {{-- ALERT --}}
                        <!-- Alert 1 — Countdown -->
                <div class="info-alert alert--warn">
                    <div class="al-icon al-icon--warn">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="al-body">
                        <p class="al-text">
                            <strong>Pembayaran harus diselesaikan sebelum waktu habis.</strong>
                            Setelah batas waktu berakhir, link pembelian akan otomatis dinonaktifkan dan transaksi dianggap batal.
                        </p>
                        <div class="countdown-wrap">
                            <span class="cd-label">Sisa waktu pembayaran:</span>
                            <div class="countdown">
                                <div class="cd-block" id="cdHour">23</div>
                                <span class="cd-sep">:</span>
                                <div class="cd-block" id="cdMin">59</div>
                                <span class="cd-sep">:</span>
                                <div class="cd-block" id="cdSec">45</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alert 2 — Payment Accuracy -->
                <div class="info-alert alert--danger">
                    <div class="al-icon al-icon--danger">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="al-body">
                        <p class="al-text">
                            <strong>Pesanan akan dibatalkan</strong> jika pembayaran gagal atau tidak sesuai.<br>
                            Pastikan bukti pembayaran sesuai dengan nominal yang tertera.
                        </p>
                    </div>
                </div>

                <!-- Alert 3 — After Success -->
                <div class="info-alert alert--success">
                    <div class="al-icon al-icon--success">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="al-body">
                        <p class="al-text">
                            <strong>Setelah pembayaran berhasil</strong>, seller akan menerima notifikasi dan segera memproses pesanan Anda.<br>
                            Status pesanan dapat dilihat di menu Riwayat Pembelian.
                        </p>
                    </div>
                </div>

            </div>


    <div class="checkout-right">

        <div class="section-card payment-card">

            <h2 class="section-title">
                Pilih Metode Pembayaran
            </h2>

            <div
                class="payment-options"
                id="paymentOptions"
            >

                @foreach($checkout['payments'] as $index => $payment)

                <label
                    class="pay-option {{ $index === 0 ? 'selected' : '' }}"
                    data-method="{{ $payment['code'] }}"
                >

                    <input
                        type="radio"
                        name="payment"
                        value="{{ $payment['code'] }}"
                        {{ $index === 0 ? 'checked' : '' }}
                        hidden
                    >

                    <div class="pay-left">

                        <div class="pm-type-icon pm-icon--{{ $payment['type'] }}">
                            <i class="bi bi-{{ $payment['icon'] }}"></i>
                        </div>

                        <div class="pm-info">

                            <span class="pm-type-label">
                                {{ $payment['label'] }}
                            </span>

                            <div class="pm-detail-row">
                                <span class="pm-detail-key">
                                    {{ $payment['key'] }}
                                </span>

                                <span class="pm-detail-val">
                                    {{ $payment['number'] }}
                                </span>
                            </div>

                            <div class="pm-detail-row">
                                <span class="pm-detail-key">
                                    a/n
                                </span>

                                <span class="pm-detail-val">
                                    {{ $payment['owner'] }}
                                </span>
                            </div>

                        </div>

                    </div>

                    <i class="bi bi-check-circle-fill po-check-icon"></i>

                </label>

                @endforeach

            </div>

            <div class="pay-info-note">

                <i class="bi bi-info-circle-fill"></i>

                <span>
                    Metode pembayaran ditentukan oleh seller.
                    Pastikan kamu memilih metode yang tersedia agar pesananmu diproses dengan cepat.
                </span>

            </div>

            <button
                class="pay-now-btn"
                id="payBtn"
            >
                <i class="bi bi-lock-fill"></i>
                Bayar Sekarang
            </button>

        </div>

    </div>

</div>

{{-- Modal Upload Bukti --}}
<div class="proof-modal" id="proofModal">

    <div class="proof-card">

        <h3 class="proof-title">
            Upload Bukti Pembayaran
        </h3>

        <p class="proof-desc">
            Upload bukti transfer atau pembayaran yang telah dilakukan.
        </p>

        <input
            type="file"
            id="paymentProof"
            accept="image/*"
            class="proof-input">

        <div id="proofPreview"></div>

        <div class="proof-actions">

            <button
                type="button"
                class="proof-cancel-btn"
                id="closeProofModal">

                Batal

            </button>

            <button
                type="button"
                class="proof-submit-btn"
                id="submitProof">

                Kirim Bukti

            </button>

        </div>

    </div>

</div>

{{-- Modal Success --}}
<div class="success-modal-overlay" id="successModal">
    <div class="success-modal-card">
        <div class="sm-icon-wrap">
            <div class="sm-icon-circle">
                <i class="bi bi-check-lg"></i>
            </div>
        </div>
        <h3 class="sm-title">
            Bukti Pembayaran Berhasil Dikirim
        </h3>
        <p class="sm-desc">
            Bukti pembayaran telah dikirim ke seller dan sedang menunggu proses verifikasi.
        </p>
        <div class="sm-info-table">
            <div class="sm-row">
                <span class="sm-key">No. Pesanan</span>
                <span class="sm-val">{{ $checkout['order_id'] }}</span>
            </div>
            <div class="sm-row">
                <span class="sm-key">Metode Bayar</span>
                <span class="sm-val" id="modalMethod">BCA Transfer</span>
            </div>
            <div class="sm-row">
                <span class="sm-key">Total Bayar</span>
                <span class="sm-val sm-total">Rp 7.500.000</span>
            </div>
        </div>
        <div class="sm-actions">
            <button class="sm-btn-sec" id="modalClose">Tutup</button>
            <a href="#" class="sm-btn-pri">Lihat Pesanan <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>
</div>

@endsection
