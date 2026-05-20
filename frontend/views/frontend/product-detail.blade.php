@extends('frontend.layouts.tech')

@section('title', $product->name.' | Đồ Công Nghệ')
@section('meta_description', $product->short_description ?: 'Chi tiết sản phẩm '.$product->name.' tại Đồ Công Nghệ.')

@php
    $formatPrice = fn ($value) => number_format((float) $value, 0, ',', '.').'đ';
    $fallbackImage = 'template/images/product/electronic/product1.jpg';
    $displayPrice = $product->sale_price ?: $product->price;
    $hasDiscount = $product->sale_price !== null && (float) $product->sale_price < (float) $product->price;
    $mainImage = $images->firstWhere('is_main', 1)?->image_path ?? $images->first()?->image_path ?? $product->thumbnail ?? $fallbackImage;
@endphp

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend.home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('frontend.shop') }}">Sản phẩm</a>
                @if ($product->category_name)
                    <i class="fas fa-chevron-right"></i>
                    <a href="{{ route('frontend.shop', ['category' => $product->category_id]) }}">{{ $product->category_name }}</a>
                @endif
                <i class="fas fa-chevron-right"></i>
                <span>{{ $product->name }}</span>
            </div>
            <h1>{{ $product->name }}</h1>
            <p>{{ $product->short_description ?: 'Thông tin chi tiết, giá bán, bảo hành và cấu hình sản phẩm.' }}</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container detail-grid">
            <div class="gallery-card">
                <div class="gallery-main">
                    <img src="{{ asset($mainImage) }}" alt="{{ $product->name }}">
                </div>

                <div class="thumb-row">
                    @forelse ($images as $image)
                        <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }}">
                    @empty
                        <img src="{{ asset($product->thumbnail ?: $fallbackImage) }}" alt="{{ $product->name }}">
                    @endforelse
                </div>
            </div>

            <aside class="purchase-card">
                <div class="rating-row">
                    <span><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></span>
                    <span class="muted">SKU: {{ $product->sku }}</span>
                </div>

                <h2>{{ $product->name }}</h2>
                <p class="muted">{{ $product->description ?: $product->short_description }}</p>

                <div class="price-row">
                    <strong>{{ $formatPrice($displayPrice) }}</strong>
                    @if ($hasDiscount)
                        <del>{{ $formatPrice($product->price) }}</del>
                    @endif
                </div>

                <div class="product-meta-list">
                    <div><span>Danh mục</span><strong>{{ $product->category_name ?? 'Chưa phân loại' }}</strong></div>
                    <div><span>Thương hiệu</span><strong>{{ $product->brand_name ?? 'Đồ Công Nghệ' }}</strong></div>
                    <div><span>Tồn kho</span><strong>{{ $product->quantity }} sản phẩm</strong></div>
                    <div><span>Bảo hành</span><strong>{{ $product->warranty_months }} tháng</strong></div>
                </div>

                <div class="hero__actions u-m-t-20">
                    <a class="primary-action" href="{{ route('frontend.cart') }}"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ</a>
                    <a class="secondary-action" href="{{ route('frontend.checkout') }}">Mua ngay</a>
                </div>
            </aside>
        </div>
    </section>

    <section class="inner-section inner-section--soft">
        <div class="site-container content-grid">
            <div class="info-card">
                <h2 class="panel-title">Mô tả sản phẩm</h2>
                <p class="muted">{{ $product->description ?: $product->short_description ?: 'Sản phẩm đang được cập nhật mô tả chi tiết.' }}</p>

                @if ($specifications->isNotEmpty())
                    <h3 class="panel-title u-m-t-20">Thông số kỹ thuật</h3>
                    <div class="spec-grid">
                        @foreach ($specifications as $specification)
                            <div>
                                <span>{{ $specification->spec_name }}</span>
                                <strong>{{ $specification->spec_value }}</strong>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <aside class="summary-card">
                <h2 class="panel-title">Dịch vụ đi kèm</h2>
                <div class="summary-list">
                    <div><span>Cài đặt cơ bản</span><strong>Miễn phí</strong></div>
                    <div><span>Đổi trả lỗi phần cứng</span><strong>7 ngày</strong></div>
                    <div><span>Giao nội thành</span><strong>Trong ngày</strong></div>
                </div>
            </aside>
        </div>
    </section>

    @if ($relatedProducts->isNotEmpty())
        <section class="inner-section">
            <div class="site-container">
                <div class="section-heading">
                    <span>Cùng danh mục</span>
                    <h2>Sản phẩm liên quan</h2>
                    <a href="{{ route('frontend.shop', ['category' => $product->category_id]) }}">Xem thêm <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="product-grid">
                    @foreach ($relatedProducts as $relatedProduct)
                        @php
                            $relatedPrice = $relatedProduct->sale_price ?: $relatedProduct->price;
                            $relatedDiscount = $relatedProduct->sale_price !== null && (float) $relatedProduct->sale_price < (float) $relatedProduct->price;
                        @endphp

                        <article class="product-card">
                            <a class="product-card__media" href="{{ route('frontend.product', $relatedProduct->id) }}">
                                <img src="{{ asset($relatedProduct->thumbnail ?: $fallbackImage) }}" alt="{{ $relatedProduct->name }}">
                                <span>{{ $relatedDiscount ? 'Sale' : 'Gợi ý' }}</span>
                            </a>
                            <div class="product-card__body">
                                <small>{{ $relatedProduct->brand_name ?? 'Tech Shop' }}</small>
                                <h3><a href="{{ route('frontend.product', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a></h3>
                                <p>{{ $relatedProduct->short_description }}</p>
                                <div class="product-card__price">
                                    <strong>{{ $formatPrice($relatedPrice) }}</strong>
                                    @if ($relatedDiscount)
                                        <del>{{ $formatPrice($relatedProduct->price) }}</del>
                                    @endif
                                </div>
                                <div class="product-card__actions">
                                    <a href="{{ route('frontend.cart') }}"><i class="fas fa-shopping-cart"></i> Thêm</a>
                                    <a href="{{ route('frontend.wishlist') }}" aria-label="Yêu thích {{ $relatedProduct->name }}"><i class="far fa-heart"></i></a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
