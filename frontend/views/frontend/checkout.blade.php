@extends('frontend.layouts.tech')

@section('title', 'Thanh toán | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend.home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Thanh toán</span>
            </div>
            <h1>Hoàn tất đơn hàng</h1>
            <p>Nhập thông tin giao hàng và chọn phương thức thanh toán phù hợp.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container checkout-layout">
            <form class="auth-card stack" action="{{ route('frontend.checkout') }}" method="get">
                <h2 class="panel-title">Thông tin nhận hàng</h2>
                <div class="form-grid">
                    <div class="field">
                        <label for="checkout-name">Họ tên</label>
                        <input id="checkout-name" type="text" placeholder="Nguyễn Văn A">
                    </div>
                    <div class="field">
                        <label for="checkout-phone">Số điện thoại</label>
                        <input id="checkout-phone" type="tel" placeholder="0900 000 000">
                    </div>
                    <div class="field field--full">
                        <label for="checkout-email">Email</label>
                        <input id="checkout-email" type="email" placeholder="ban@example.com">
                    </div>
                    <div class="field field--full">
                        <label for="checkout-address">Địa chỉ</label>
                        <input id="checkout-address" type="text" placeholder="Số nhà, đường, phường/xã, quận/huyện">
                    </div>
                    <div class="field">
                        <label for="checkout-shipping">Giao hàng</label>
                        <select id="checkout-shipping">
                            <option>Giao nhanh trong ngày</option>
                            <option>Giao tiêu chuẩn</option>
                            <option>Nhận tại cửa hàng</option>
                        </select>
                    </div>
                    <div class="field">
                        <label for="checkout-payment">Thanh toán</label>
                        <select id="checkout-payment">
                            <option>Chuyển khoản</option>
                            <option>COD</option>
                            <option>Trả góp</option>
                        </select>
                    </div>
                </div>
                <button class="primary-action" type="submit">Đặt hàng</button>
            </form>

            <aside class="summary-card">
                <h2 class="panel-title">Đơn hàng</h2>
                <div class="summary-list">
                    <div><span>ROG Strix G16</span><strong>32.990.000đ</strong></div>
                    <div><span>AirPods Pro 2</span><strong>5.890.000đ</strong></div>
                    <div><span>Giảm giá</span><strong>-1.000.000đ</strong></div>
                    <div class="summary-total"><span>Tổng cộng</span><strong>37.880.000đ</strong></div>
                </div>
                <p class="muted">Nhân viên sẽ xác nhận đơn hàng qua điện thoại trước khi giao.</p>
            </aside>
        </div>
    </section>
@endsection
