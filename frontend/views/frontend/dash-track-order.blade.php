@extends('frontend.layouts.tech')

@section('title', 'Theo dõi đơn hàng | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <h1>Theo dõi đơn hàng</h1>
            <p>
                @if($order)
                    Cập nhật từng bước xử lý cho đơn #{{ $order->order_code }}.
                @else
                    Chưa có đơn hàng để theo dõi.
                @endif
            </p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container account-layout">
            @include('frontend.partials.account-nav', ['active' => 'track'])

            <div class="account-panel">
                @if($order)
                    <div class="shop-toolbar">
                        <div>
                            <h2 class="panel-title u-m-0">Đơn #{{ $order->order_code }}</h2>
                            <p class="muted u-m-t-6">{{ $order->item_summary }} · {{ $order->display_total }}</p>
                        </div>
                        <span class="{{ $order->status_badge_class }}">{{ ucfirst($order->status_label) }}</span>
                    </div>

                    <div class="spec-grid u-m-t-18">
                        <div><span>Người nhận</span><strong>{{ $order->shipping_full_name ?: $order->customer_name }}</strong></div>
                        <div><span>Số điện thoại</span><strong>{{ $order->shipping_phone ?: $order->customer_phone }}</strong></div>
                        <div><span>Thanh toán</span><strong>{{ $order->payment_label }}</strong></div>
                        <div><span>Mã vận đơn</span><strong>{{ $order->tracking_number ?: 'Đang cập nhật' }}</strong></div>
                    </div>

                    <h3 class="panel-title u-m-t-20">Sản phẩm trong đơn</h3>
                    <div class="cart-lines">
                        @foreach($orderItems as $item)
                            <article class="cart-line">
                                <img src="{{ asset($item->image) }}" alt="{{ $item->product_name }}">
                                <div class="cart-line__content">
                                    <h3>{{ $item->product_name }}</h3>
                                    <p class="muted">Số lượng: {{ $item->quantity }} · Đơn giá: {{ $item->display_price }}</p>
                                </div>
                                <strong>{{ $item->display_total }}</strong>
                            </article>
                        @endforeach
                    </div>

                    <h3 class="panel-title u-m-t-20">Lịch sử trạng thái</h3>
                    <div class="timeline">
                        @foreach($orderHistory as $history)
                            <div class="timeline-item">
                                <i class="{{ $history->icon }}"></i>
                                <div>
                                    <strong>{{ ucfirst($history->status_label) }}</strong>
                                    <p class="muted">{{ $history->note ?: 'Đã cập nhật trạng thái đơn hàng.' }}</p>
                                    <span class="muted">{{ $history->display_date }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state empty-state--small">
                        <strong>Chưa có đơn hàng</strong>
                        <span>Khi có đơn hàng, tiến trình xử lý và vận chuyển sẽ hiển thị tại đây.</span>
                        <a class="primary-action" href="{{ route('frontend.shop') }}">Xem sản phẩm</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
