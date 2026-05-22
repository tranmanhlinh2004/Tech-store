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
            <form class="cart-add-form" action="{{ route('frontend.cart.store') }}" method="post" @guest data-cart-login-trigger @endguest>
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <button type="submit"><i class="fas fa-shopping-cart"></i> Thêm</button>
            </form>
            <form class="wishlist-toggle-form" action="{{ ($product->is_wishlisted ?? false) ? route('frontend.wishlist.items.destroy', $product->id) : route('frontend.wishlist.items.store') }}" method="post" @guest data-cart-login-trigger @endguest>
                @csrf
                @if($product->is_wishlisted ?? false)
                    @method('DELETE')
                @else
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                @endif
                <button class="wishlist-action {{ ($product->is_wishlisted ?? false) ? 'is-active' : '' }}" type="submit" aria-label="{{ ($product->is_wishlisted ?? false) ? 'Xóa '.$product->name.' khỏi yêu thích' : 'Thêm '.$product->name.' vào yêu thích' }}">
                    <i class="{{ ($product->is_wishlisted ?? false) ? 'fas' : 'far' }} fa-heart"></i>
                </button>
            </form>
        </div>
    </div>
</article>
