@extends('frontend.layouts.tech')

@section('title', 'Quản lý đơn hàng | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <h1>Quản lý đơn hàng</h1>
            <p>Tổng hợp đơn chờ xác nhận, đang giao và đã hoàn tất.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container account-layout">
            @include('frontend.partials.account-nav', ['active' => 'orders'])

            <div class="account-panel">
                <div class="stat-grid">
                    <div class="mini-stat"><span>Chờ xác nhận</span><strong>1</strong></div>
                    <div class="mini-stat"><span>Đang giao</span><strong>2</strong></div>
                    <div class="mini-stat"><span>Hoàn tất</span><strong>12</strong></div>
                </div>
                <table class="data-table">
                    <thead><tr><th>Mã đơn</th><th>Khách hàng</th><th>Trạng thái</th><th>Tổng tiền</th></tr></thead>
                    <tbody>
                        <tr><td>#TS20260518</td><td>Nguyễn Minh Anh</td><td><span class="status-badge">Đang giao</span></td><td>32.990.000đ</td></tr>
                        <tr><td>#TS20260517</td><td>Trần Hoàng Nam</td><td><span class="status-badge--warn status-badge">Chờ xác nhận</span></td><td>5.890.000đ</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
