@extends('frontend.layouts.tech')

@section('title', 'Theo dõi đơn hàng | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <h1>Theo dõi đơn hàng</h1>
            <p>Cập nhật từng bước xử lý cho đơn #TS20260518.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container account-layout">
            @include('frontend.partials.account-nav', ['active' => 'track'])

            <div class="account-panel">
                <h2 class="panel-title">ROG Strix G16</h2>
                <div class="timeline">
                    <div class="timeline-item">
                        <i class="fas fa-check"></i>
                        <div><strong>Đã xác nhận</strong><p class="muted">09:10 · 18/05/2026</p></div>
                    </div>
                    <div class="timeline-item">
                        <i class="fas fa-box"></i>
                        <div><strong>Đang đóng gói</strong><p class="muted">Kiểm tra máy, phụ kiện và phiếu bảo hành.</p></div>
                    </div>
                    <div class="timeline-item">
                        <i class="fas fa-truck"></i>
                        <div><strong>Đang giao</strong><p class="muted">Dự kiến giao trước 18:00 hôm nay.</p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
