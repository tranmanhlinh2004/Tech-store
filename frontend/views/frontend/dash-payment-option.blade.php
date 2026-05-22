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
                @if($paymentMethods->isNotEmpty())
                    <div class="payment-grid">
                        @foreach($paymentMethods as $method)
                            <div class="info-card">
                                <span class="{{ $method->is_default ? 'status-badge' : 'status-badge status-badge--muted' }}">
                                    {{ $method->is_default ? 'Mặc định' : $method->type_label }}
                                </span>
                                <h3>{{ $method->title }}</h3>
                                <p class="muted">{{ $method->detail }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state empty-state--small">
                        <strong>Chưa có phương thức thanh toán</strong>
                        <span>Các phương thức thanh toán đã lưu sẽ hiển thị tại đây.</span>
                    </div>
                @endif
                <div class="hero__actions u-m-t-20">
                    <a class="primary-action" href="{{ route('frontend.checkout') }}">Thêm phương thức thanh toán</a>
                    <a class="secondary-action" href="{{ route('frontend.contact') }}">Cần hỗ trợ</a>
                </div>
            </div>
        </div>
    </section>
@endsection
