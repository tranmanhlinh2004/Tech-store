@extends('frontend.layouts.tech')

@section('title', 'Tài khoản | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend.home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Tài khoản</span>
            </div>
            <h1>Trang tài khoản</h1>
            <p>Theo dõi đơn hàng, bảo hành, địa chỉ và phương thức thanh toán.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container account-layout">
            @include('frontend.partials.account-nav', ['active' => 'dashboard'])

            <div class="account-panel">
                <h2 class="panel-title">Xin chào, {{ auth()->user()->name }}</h2>
                <div class="stat-grid">
                    <div class="mini-stat"><span>Đơn đang xử lý</span><strong>2</strong></div>
                    <div class="mini-stat"><span>Sản phẩm yêu thích</span><strong>8</strong></div>
                    <div class="mini-stat"><span>Bảo hành còn hiệu lực</span><strong>5</strong></div>
                </div>
                <h3 class="panel-title">Hoạt động gần đây</h3>
                <div class="timeline">
                    <div class="timeline-item">
                        <i class="fas fa-truck"></i>
                        <div><strong>Đơn #TS20260518 đang giao</strong><p class="muted">ROG Strix G16 dự kiến giao trong hôm nay.</p></div>
                    </div>
                    <div class="timeline-item">
                        <i class="fas fa-heart"></i>
                        <div><strong>Đã thêm UltraGear 27GP850 vào yêu thích</strong><p class="muted">Sản phẩm đang có ưu đãi màn hình gaming.</p></div>
                    </div>
                    <div class="timeline-item">
                        <i class="fas fa-shield-alt"></i>
                        <div><strong>Bảo hành AirPods Pro 2 còn 10 tháng</strong><p class="muted">Bạn có thể xem chi tiết trong hồ sơ thiết bị.</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
