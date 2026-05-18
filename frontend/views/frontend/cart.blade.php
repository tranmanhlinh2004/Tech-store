@extends('frontend.layouts.tech')

@section('title', 'Giỏ hàng | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend.home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Giỏ hàng</span>
            </div>
            <h1>Giỏ hàng của bạn</h1>
            <p>Kiểm tra lại sản phẩm, số lượng và ưu đãi trước khi thanh toán.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container cart-layout">
            <div class="cart-lines">
                <article class="cart-line">
                    <img src="{{ asset('template/images/product/gaming-laptop/asus-rog-strix-g16.jpg') }}" alt="ROG Strix G16">
                    <div>
                        <h3>ROG Strix G16</h3>
                        <p class="muted">Core i7 · RTX 4060 · 16GB RAM</p>
                        <span class="quantity-pill"><i class="fas fa-minus"></i> 1 <i class="fas fa-plus"></i></span>
                    </div>
                    <strong>32.990.000đ</strong>
                </article>

                <article class="cart-line">
                    <img src="{{ asset('template/images/product/bluetooth-headphone/airpods-pro-2-usb-c.jpg') }}" alt="AirPods Pro 2">
                    <div>
                        <h3>AirPods Pro 2 USB-C</h3>
                        <p class="muted">Chống ồn chủ động · Bảo hành 12 tháng</p>
                        <span class="quantity-pill"><i class="fas fa-minus"></i> 1 <i class="fas fa-plus"></i></span>
                    </div>
                    <strong>5.890.000đ</strong>
                </article>

                <a class="secondary-action" href="{{ route('frontend.shop') }}"><i class="fas fa-arrow-left"></i> Tiếp tục mua sắm</a>
            </div>

            <aside class="summary-card">
                <h2 class="panel-title">Tóm tắt đơn hàng</h2>
                <div class="summary-list">
                    <div><span>Tạm tính</span><strong>38.880.000đ</strong></div>
                    <div><span>Giảm giá</span><strong>-1.000.000đ</strong></div>
                    <div><span>Vận chuyển</span><strong>Miễn phí</strong></div>
                    <div class="summary-total"><span>Tổng cộng</span><strong>37.880.000đ</strong></div>
                </div>
                <a class="primary-action" href="{{ route('frontend.checkout') }}">Thanh toán</a>
            </aside>
        </div>
    </section>
@endsection
