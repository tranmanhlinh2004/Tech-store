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
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Sản phẩm</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#TS20260518</td>
                            <td>ROG Strix G16</td>
                            <td>32.990.000đ</td>
                            <td><span class="status-badge">Đang giao</span></td>
                            <td><a href="{{ url('/dash-track-order.html') }}">Theo dõi</a></td>
                        </tr>
                        <tr>
                            <td>#TS20260510</td>
                            <td>AirPods Pro 2</td>
                            <td>5.890.000đ</td>
                            <td><span class="status-badge--muted status-badge">Hoàn tất</span></td>
                            <td><a href="{{ route('frontend.product') }}">Mua lại</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
