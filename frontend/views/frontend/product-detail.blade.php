@extends('frontend.layouts.tech')

@section('title', $product->name.' | Đồ Công Nghệ')
@section('meta_description', $product->teaser)

@section('content')
    @php
        $mainImage = $productImages->first() ?: ($product->thumbnail ?: 'template/images/loading.gif');
    @endphp

    <section class="page-hero page-hero--compact" style="background: linear-gradient(90deg, rgba(15, 23, 42, 0.96), rgba(15, 23, 42, 0.72)), url('{{ asset($mainImage) }}') right center / contain no-repeat, #111827;">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend.home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('frontend.shop') }}">Sản phẩm</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('frontend.shop', ['category' => $product->category_slug]) }}">{{ $product->category_name }}</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $product->name }}</span>
            </div>
            <h1>{{ $product->name }}</h1>
            <p>{{ $product->teaser }}</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container detail-grid">
            <div class="gallery-card">
                <div class="gallery-main">
                    <img src="{{ asset($mainImage) }}" alt="{{ $product->name }}">
                </div>
                <div class="thumb-row">
                    @foreach($productImages as $image)
                        <img src="{{ asset($image) }}" alt="{{ $product->name }}">
                    @endforeach
                </div>
            </div>

            <aside class="purchase-card">
                <div class="rating-row">
                    <span><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></span>
                    <span class="muted">{{ number_format($product->view_count) }} lượt xem</span>
                </div>
                <h2>{{ $product->name }}</h2>
                <p class="muted">{{ $product->teaser }}</p>
                <div class="price-row">
                    <strong>{{ $product->display_price }}</strong>
                    @if($product->display_original_price)
                        <del>{{ $product->display_original_price }}</del>
                    @endif
                </div>

                <strong>Thông tin nhanh</strong>
                <div class="choice-row">
                    @forelse($specifications->take(4) as $spec)
                        <span>{{ $spec->spec_name }}: {{ $spec->spec_value }}</span>
                    @empty
                        <span>{{ $product->brand_name }}</span>
                        <span>{{ $product->category_name }}</span>
                        <span>{{ $product->sku }}</span>
                    @endforelse
                </div>

                <div class="hero__actions">
                    <a class="primary-action" href="{{ route('frontend.cart') }}"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ</a>
                    <a class="secondary-action" href="{{ route('frontend.checkout') }}">Mua ngay</a>
                </div>

                <div class="spec-grid u-m-t-18">
                    <div><span>Thương hiệu</span><strong>{{ $product->brand_name }}</strong></div>
                    <div><span>Danh mục</span><strong>{{ $product->category_name }}</strong></div>
                    <div><span>Bảo hành</span><strong>{{ $product->warranty_months }} tháng</strong></div>
                    <div><span>Tình trạng</span><strong>{{ $product->stock_label }}</strong></div>
                    <div><span>Mã sản phẩm</span><strong>{{ $product->sku }}</strong></div>
                    <div><span>Giao hàng</span><strong>{{ $product->is_free_shipping ? 'Miễn phí' : 'Trong ngày' }}</strong></div>
                </div>
            </aside>
        </div>
    </section>

    <section class="inner-section inner-section--soft">
        <div class="site-container content-grid">
            <div class="info-card">
                <h2 class="panel-title">Mô tả sản phẩm</h2>
                <p class="muted">{{ $product->description ?: $product->teaser }}</p>
                <ul class="feature-list">
                    <li><i class="fas fa-check"></i> Tư vấn cấu hình theo nhu cầu học tập, làm việc hoặc giải trí.</li>
                    <li><i class="fas fa-check"></i> Hỗ trợ kiểm tra máy, phụ kiện và tình trạng bảo hành trước khi nhận hàng.</li>
                    <li><i class="fas fa-check"></i> Đổi trả trong 7 ngày nếu phát sinh lỗi phần cứng từ nhà sản xuất.</li>
                </ul>
            </div>
            <aside class="summary-card">
                <h2 class="panel-title">Thông số kỹ thuật</h2>
                <div class="summary-list">
                    @forelse($specifications as $spec)
                        <div><span>{{ $spec->spec_name }}</span><strong>{{ $spec->spec_value }}</strong></div>
                    @empty
                        <div><span>SKU</span><strong>{{ $product->sku }}</strong></div>
                        <div><span>Tồn kho</span><strong>{{ $product->quantity }}</strong></div>
                    @endforelse
                </div>
            </aside>
        </div>
    </section>

    @if($relatedProducts->isNotEmpty())
        <section class="product-section" aria-labelledby="related-title">
            <div class="site-container">
                <div class="section-heading">
                    <span>Gợi ý thêm</span>
                    <h2 id="related-title">Sản phẩm liên quan</h2>
                    <a href="{{ route('frontend.shop', ['category' => $product->category_slug]) }}">Xem danh mục <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="product-grid">
                    @foreach($relatedProducts as $relatedProduct)
                        @include('frontend.partials.product-card', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
