@extends('admin.layouts.app')

@php
    $money = fn ($value) => number_format((float) $value, 0, ',', '.').'đ';
@endphp

@section('title', 'Dashboard')
@section('page_title', 'Thống kê doanh thu')

@section('content')
    <section class="admin-stats">
        <div class="admin-stat admin-stat--blue">
            <span><i class="fas fa-calendar-day"></i> Doanh thu hôm nay</span>
            <strong>{{ $money($stats['todayRevenue']) }}</strong>
        </div>
        <div class="admin-stat admin-stat--green">
            <span><i class="fas fa-calendar-alt"></i> Doanh thu tháng này</span>
            <strong>{{ $money($stats['monthRevenue']) }}</strong>
        </div>
        <div class="admin-stat admin-stat--purple">
            <span><i class="fas fa-coins"></i> Tổng doanh thu</span>
            <strong>{{ $money($stats['totalRevenue']) }}</strong>
        </div>
        <div class="admin-stat admin-stat--amber">
            <span><i class="fas fa-receipt"></i> Tổng đơn hàng</span>
            <strong>{{ $stats['orders'] }}</strong>
        </div>
        <div class="admin-stat admin-stat--cyan">
            <span><i class="fas fa-shipping-fast"></i> Đơn đang xử lý</span>
            <strong>{{ $stats['pendingOrders'] }}</strong>
        </div>
        <div class="admin-stat admin-stat--slate">
            <span><i class="fas fa-chart-pie"></i> Giá trị đơn trung bình</span>
            <strong>{{ $money($stats['averageOrder']) }}</strong>
        </div>
        <div class="admin-stat admin-stat--red">
            <span><i class="fas fa-exclamation-triangle"></i> Sắp hết hàng</span>
            <strong>{{ $stats['lowStock'] }}</strong>
        </div>
        <div class="admin-stat admin-stat--green">
            <span><i class="fas fa-ticket-alt"></i> Mã giảm giá đang bật</span>
            <strong>{{ $stats['activeCoupons'] }}</strong>
        </div>
    </section>

    <section class="admin-dashboard-grid">
        <div class="admin-panel">
            <div class="admin-panel__head">
                <h2>Doanh thu 6 tháng gần đây</h2>
                <span class="admin-muted">{{ $stats['paidOrders'] }} đơn đã thanh toán</span>
            </div>

            <div class="admin-chart">
                @forelse($monthlySales as $month)
                    <div class="admin-chart-row">
                        <span>{{ $month['label'] }}</span>
                        <div class="admin-chart-track">
                            <div class="admin-chart-bar" style="width: {{ max(4, round($month['revenue'] / $maxMonthlyRevenue * 100)) }}%"></div>
                        </div>
                        <strong>{{ $money($month['revenue']) }}</strong>
                    </div>
                @empty
                    <p class="admin-muted">Chưa có dữ liệu doanh thu.</p>
                @endforelse
            </div>
        </div>

        <div class="admin-panel">
            <div class="admin-panel__head">
                <h2>Hoạt động mới</h2>
            </div>

            <div class="admin-activity-list">
                @forelse($recentActivities as $activity)
                    <div class="admin-activity-item">
                        <span class="admin-activity-icon"><i class="fas {{ $activity['icon'] }}"></i></span>
                        <div>
                            <strong>{{ $activity['title'] }}</strong>
                            <span>{{ $activity['meta'] }}</span>
                            <span>{{ $activity['time'] }}</span>
                        </div>
                    </div>
                @empty
                    <p class="admin-muted">Chưa có hoạt động mới.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="admin-dashboard-grid admin-dashboard-grid--spaced">
        <div class="admin-panel">
            <div class="admin-panel__head">
                <h2>Đơn hàng mới nhất</h2>
                <a class="admin-link-button" href="{{ route('admin.orders.index') }}">Xem tất cả</a>
            </div>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Đơn hàng</th>
                            <th>Thanh toán</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td><strong>{{ $order->order_code }}</strong></td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $money($order->total_amount) }}</td>
                                <td><span class="admin-badge">{{ $order->order_status }}</span></td>
                                <td><span class="admin-badge {{ $order->payment_status === 'paid' ? '' : 'admin-badge--off' }}">{{ $order->payment_status }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="5">Chưa có đơn hàng.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="admin-panel">
            <div class="admin-panel__head">
                <h2>Sản phẩm bán chạy</h2>
            </div>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Đã bán</th>
                            <th>Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $product)
                            <tr>
                                <td>
                                    <strong>{{ $product->product_name }}</strong>
                                </td>
                                <td>{{ (int) $product->sold_quantity }}</td>
                                <td>{{ $money($product->revenue) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3">Chưa có dữ liệu bán hàng.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
