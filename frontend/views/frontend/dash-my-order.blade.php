@extends('frontend.layouts.tech')

@section('title', 'Đơn hàng của tôi | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <h1>Đơn hàng của tôi</h1>
            <p>Kiểm tra trạng thái xử lý, giao hàng và thanh toán.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container account-layout">
            @include('frontend.partials.account-nav', ['active' => 'orders'])

            <div class="account-panel">
                <h2 class="panel-title">Danh sách đơn hàng</h2>
                @if($orders->isNotEmpty())
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Sản phẩm</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thanh toán</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <td>
                                        <strong>#{{ $order->order_code }}</strong><br>
                                        <span class="muted">{{ $order->display_date }}</span>
                                    </td>
                                    <td>{{ $order->item_summary }}</td>
                                    <td>{{ $order->display_total }}</td>
                                    <td><span class="{{ $order->status_badge_class }}">{{ ucfirst($order->status_label) }}</span></td>
                                    <td><span class="{{ $order->payment_badge_class }}">{{ $order->payment_label }}</span></td>
                                    <td><a href="{{ $order->track_url }}">Theo dõi</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state empty-state--small">
                        <strong>Chưa có đơn hàng</strong>
                        <span>Các đơn hàng của bạn sẽ được hiển thị tại đây sau khi đặt mua.</span>
                        <a class="primary-action" href="{{ route('frontend.shop') }}">Mua sắm ngay</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
