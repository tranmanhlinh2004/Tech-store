@php
    $detailUrl = route('frontend.product', $product->slug);
    $thumbnail = $product->thumbnail ?: 'template/images/loading.gif';
@endphp

<article class="product-card">
    <a class="product-card__media" href="{{ $detailUrl }}">
        <img src="{{ asset($thumbnail) }}" alt="{{ $product->name }}">
        <span>{{ $product->discount_label }}</span>
    </a>
    <div class="product-card__body">
        <small>{{ $product->brand_name }}</small>
        <h3><a href="{{ $detailUrl }}">{{ $product->name }}</a></h3>
        <p>{{ $product->teaser }}</p>
        <div class="product-card__price">
            <strong>{{ $product->display_price }}</strong>
            @if($product->display_original_price)
                <del>{{ $product->display_original_price }}</del>
            @endif
        </div>
        <div class="product-card__actions">
            <a href="{{ route('frontend.cart') }}"><i class="fas fa-shopping-cart"></i> Thêm</a>
            <a href="{{ route('frontend.wishlist') }}" aria-label="Thêm {{ $product->name }} vào yêu thích"><i class="far fa-heart"></i></a>
        </div>
    </div>
</article>
