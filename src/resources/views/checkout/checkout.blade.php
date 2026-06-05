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
    $productImage = $product->productImages->first();
    $imageUrl = $productImage
        ? asset('storage/' . $productImage->image_path)
        : asset('images/Elemen-1.png');

    $currentYear = date('Y');
    $randomNumber = rand(10000, 99999);
    $generatedOrderId = '#SM-' . $currentYear . '-' . $randomNumber;
@endphp

<script>
window.checkoutData = {
    expiredAt: {{ $purchaseLink->expired_at->timestamp * 1000 }}
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
                        src="{{ $imageUrl }}"
                        alt="{{ $product->name }}"
                        class="order-img"
                    >
                </div>

                <div class="order-product-info">

                    <h3 class="order-product-name">
                        {{ $product->name }}
                    </h3>

                    <p class="order-product-price">
                        Rp {{ number_format($purchaseLink->deal_price,0,',','.') }}
                    </p>

                    <div class="condition-row">
                        <span class="cond-pill">
                            Bekas
                        </span>
                    </div>

                </div>

            </div>

            <div class="payment-total-card">

                <span>Total Pembayaran</span>

                <strong>
                    Rp {{ number_format($purchaseLink->deal_price,0,',','.') }}
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
                        {{ $purchaseLink->expired_at->format('d M Y • H:i') }} WIB
                    </span>
                </div>

                <div class="om-row">

                    <span class="om-key">
                        Seller
                    </span>

                    <span class="om-val seller-link">
                        {{ $seller->name }}
                    </span>

                </div>

                <div class="om-row om-note-row">

                    <span class="om-key">
                        Pesan Seller
                    </span>

                    <span class="om-val">
                        Harga telah disepakati. Silakan lakukan pembayaran sebelum batas waktu berakhir.
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
                        <div class="cd-block" id="cdHour">00</div>
                        <span class="cd-sep">:</span>
                        <div class="cd-block" id="cdMin">00</div>
                        <span class="cd-sep">:</span>
                        <div class="cd-block" id="cdSec">00</div>
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
                <label class="pay-option selected" data-method="transfer_bca">
                    <input type="radio" name="payment" value="transfer_bca" checked hidden>
                    <div class="pay-left">
                        <div class="pm-type-icon pm-icon--bank"><i class="bi bi-bank2"></i></div>
                        <div class="pm-info">
                            <span class="pm-type-label">Transfer Bank - BCA</span>
                        </div>
                    </div>
                    <i class="bi bi-check-circle-fill po-check-icon"></i>
                </label>

                <label class="pay-option" data-method="transfer_mandiri">
                    <input type="radio" name="payment" value="transfer_mandiri" hidden>
                    <div class="pay-left">
                        <div class="pm-type-icon pm-icon--bank"><i class="bi bi-bank2"></i></div>
                        <div class="pm-info">
                            <span class="pm-type-label">Transfer Bank - Mandiri</span>
                        </div>
                    </div>
                    <i class="bi bi-check-circle-fill po-check-icon"></i>
                </label>

                <label class="pay-option" data-method="gopay">
                    <input type="radio" name="payment" value="gopay" hidden>
                    <div class="pay-left">
                        <div class="pm-type-icon pm-icon--ewallet"><i class="bi bi-phone"></i></div>
                        <div class="pm-info">
                            <span class="pm-type-label">E-Wallet - GoPay</span>
                        </div>
                    </div>
                    <i class="bi bi-check-circle-fill po-check-icon"></i>
                </label>
                
                <label class="pay-option" data-method="ovo">
                    <input type="radio" name="payment" value="ovo" hidden>
                    <div class="pay-left">
                        <div class="pm-type-icon pm-icon--ewallet"><i class="bi bi-phone"></i></div>
                        <div class="pm-info">
                            <span class="pm-type-label">E-Wallet - OVO</span>
                        </div>
                    </div>
                    <i class="bi bi-check-circle-fill po-check-icon"></i>
                </label>
            </div>

            <div class="pay-info-note">

                <i class="bi bi-info-circle-fill"></i>

                <span>
                    Metode pembayaran ditentukan oleh seller.
                    Pastikan kamu memilih metode yang tersedia agar pesananmu diproses dengan cepat.
                </span>

            </div>

            <form action="{{ route('checkout.store', $purchaseLink->token) }}" method="POST">
                @csrf
                <input type="hidden" name="payment_method" id="selectedPaymentMethod" value="transfer_bca">
                <button type="submit" class="pay-now-btn" id="payBtn">
                    <i class="bi bi-lock-fill"></i>
                    Bayar Sekarang
                </button>
            </form>

        </div>

    </div>

</div>

@endsection
