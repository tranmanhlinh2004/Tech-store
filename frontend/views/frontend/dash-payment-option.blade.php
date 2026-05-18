@extends('frontend.layouts.tech')

@section('title', 'Thanh toán của tôi | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <h1>Phương thức thanh toán</h1>
            <p>Quản lý thẻ, ví và lựa chọn thanh toán nhanh khi đặt hàng.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container account-layout">
            @include('frontend.partials.account-nav', ['active' => 'payment'])

            <div class="account-panel">
                <div class="payment-grid">
                    <div class="info-card">
                        <span class="status-badge">Mặc định</span>
                        <h3>Visa ·•••• 4242</h3>
                        <p class="muted">Nguyễn Minh Anh · hết hạn 12/2028</p>
                    </div>
                    <div class="info-card">
                        <span class="status-badge--muted status-badge">Ví điện tử</span>
                        <h3>Momo</h3>
                        <p class="muted">Liên kết với số 0901 000 004</p>
                    </div>
                </div>
                <div class="hero__actions u-m-t-20">
                    <a class="primary-action" href="{{ route('frontend.checkout') }}">Dùng khi thanh toán</a>
                    <a class="secondary-action" href="{{ route('frontend.contact') }}">Cần hỗ trợ</a>
                </div>
            </div>
        </div>
    </section>
@endsection
