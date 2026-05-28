<a href="/products/1" class="product-card-link">

<div class="product-card">

    <div class="card-img-wrap">
        <img src="{{ $image }}" alt="{{ $name }}" class="card-img">
    </div>

    <div class="card-body-custom">

        <h3 class="product-name">{{ $name }}</h3>

        <p class="product-price">{{ $price }}</p>

        <span class="condition-badge">
            {{ $condition }}
        </span>

    <button class="wishlist-btn" 
        data-name="{{ $product['name'] }}" 
        data-price="{{ $product['price'] }}" 
        data-condition="{{ $product['condition'] }}" 
        data-image="{{ $product['image'] }}">
        <i class="bi bi-heart"></i>
    </button>

    </div>

</div>

</a>