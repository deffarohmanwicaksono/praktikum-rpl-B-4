@php

    $rawKondisi = $product->condition ?? 'bekas_baik';
    
    $condLabel = [
        'bekas_seperti_baru' => 'Bekas Seperti Baru',
        'bekas_baik'         => 'Bekas Baik',
        'bekas_layak_pakai'  => 'Bekas Layak Pakai',
    ];
    
    $displayLabel = $condLabel[$rawKondisi] ?? ucfirst(str_replace('_', ' ', $rawKondisi));
    
    $firstImage = $product->productImages->sortBy('order')->first();
    $imageUrl = $firstImage ? $firstImage->image_url : null;
    
    $src = asset('images/placeholder.png'); 

    if ($imageUrl) {
        if (str_starts_with($imageUrl, 'http')) {
            $src = $imageUrl;
        } elseif (str_starts_with($imageUrl, 'images/')) {
            $src = asset($imageUrl);
        } else {
            $src = asset('storage/' . ltrim($imageUrl, '/'));
        }
    }
@endphp

<div class="product-card">
    <a href="{{ route('products.detail-product', $product->id) }}" class="product-card-link">
        <div class="card-img-wrap">
            <img src="{{ $src }}" alt="{{ $product->name }}" class="card-img">
        </div>
        <div class="card-body-custom">
            <h3 class="product-name">{{ $product->name }}</h3>
            <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
            <span class="condition-badge">{{ $displayLabel }}</span>
        </div>
    </a>

    <button class="wishlist-btn"
        data-name="{{ $product->name }}"
        data-price="{{ $product->price }}"
        data-condition="{{ $rawKondisi }}"
        data-image="{{ $src }}">
        <i class="bi bi-heart"></i>
    </button>
</div>