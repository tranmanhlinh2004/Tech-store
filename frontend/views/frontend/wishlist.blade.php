@extends('frontend.layouts.tech')

@section('title', 'Yêu thích | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend .home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Yêu thích</span>
            </div>
            <h1>Sản phẩm yêu thích</h1>
            <p>Lưu lại các thiết bị bạn đang cân nhắc để so sánh và mua sau.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container cart-lines">
            <article class="wishlist-line">
                <img src="{{ asset('template/images/product/iphone/iphone-15-pro-256gb.webp') }}" alt="iPhone 15 Pro">
                <div>
                    <h3>iPhone 15 Pro 256GB</h3>
                    <p class="muted">Apple · còn hàng · bảo hành 12 tháng</p>
                </div>
                <a class="primary-action" href="{{ route('frontend.cart') }}">Thêm vào giỏ</a>
            </article>
            <article class="wishlist-line">
                <img src="{{ asset('template/images/product/monitor/lg-ultragear-27gp850.jpg') }}" alt="LG UltraGear">
                <div>
                    <h3>LG UltraGear 27GP850</h3>
                    <p class="muted">Màn QHD 165Hz · phù hợp gaming và làm việc</p>
                </div>
                <a class="primary-action" href="{{ route('frontend.cart') }}">Thêm vào giỏ</a>
            </article>
            <a class="secondary-action" href="{{ route('frontend.shop') }}">Xem thêm sản phẩm</a>
        </div>
    </section>
@endsection
