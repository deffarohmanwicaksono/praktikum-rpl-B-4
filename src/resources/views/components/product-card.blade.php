@php
    $firstImage = $product->productImages->sortBy('order')->first();
    $imageUrl = $firstImage ? $firstImage->image_url : null;
    $isExternal = $imageUrl && str_starts_with($imageUrl, 'http');
    $src = $imageUrl
        ? ($isExternal ? $imageUrl : asset($imageUrl))
        : asset('images/placeholder.png');
@endphp

<a href="{{ route('products.detail-product', $product->id) }}" class="product-card-link">

<div class="product-card">

    <div class="card-img-wrap">
                <img src="{{ $src }}" alt="{{ $product->name }}" class="card-img">
    </div>

    <div class="card-body-custom">

        <h3 class="product-name">{{ $product->name }}</h3>

        <p class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

        <span class="condition-badge">
            {{ $product->status }}
        </span>

    <button class="wishlist-btn"
        data-name="{{ $product->name }}"
        data-price="{{ $product->price }}"
        data-condition="{{ $product->status }}"
        data-image="{{ $src }}">
        <i class="bi bi-heart"></i>
    </button>

    </div>

</div>

</a>
