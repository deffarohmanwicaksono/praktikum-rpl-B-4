@extends('layouts.app')

@section('title', 'Upload Bukti Pembayaran - SeMart')

@section('content')
<div style="max-width: 500px; margin: 2rem auto; padding: 0 1rem;">

    <div class="section-card" style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 2px 12px rgba(0,0,0,0.06);">
        <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">
            Upload Bukti Pembayaran
        </h2>
        <p style="color: #6c757d; font-size: 0.875rem; margin-bottom: 1.5rem;">
            Upload bukti transfer atau screenshot pembayaran yang telah dilakukan.
        </p>

        <div style="background: #f8f9ff; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem;">
            <p style="font-size: 0.85rem; margin: 0;">
                <strong>{{ $transaction->product->name }}</strong><br>
                Total: <strong>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</strong>
            </p>
            <p style="font-size: 0.85rem; margin: 0; margin-top: 5px;">
                Metode Pembayaran: <strong>{{ strtoupper(str_replace('_', ' ', $transaction->payment_method)) }}</strong>
            </p>
        </div>

        <form action="{{ route('checkout.uploadProof', $transaction->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 1.5rem;">
                <label style="font-weight: 600; font-size: 0.875rem; display: block; margin-bottom: 0.5rem;">
                    Bukti Pembayaran <span style="color: #e74c3c;">*</span>
                </label>
                <input type="file" name="payment_proof" accept="image/*" required
                       style="width: 100%; padding: 0.75rem; border: 2px dashed #dee2e6; border-radius: 12px; background: #fafafa;">
                @error('payment_proof')
                    <p style="color: #e74c3c; font-size: 0.8rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" style="width: 100%; padding: 0.875rem; border: none; border-radius: 12px; background: var(--primary-blue); color: white; font-weight: 600; font-size: 0.95rem; cursor: pointer;">
                <i class="bi bi-upload"></i> Kirim Bukti Pembayaran
            </button>
        </form>
    </div>

</div>
@endsection
