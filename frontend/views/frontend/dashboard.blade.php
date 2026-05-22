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
                    <div class="mini-stat"><span>Đơn đang xử lý</span><strong>{{ $accountStats['processing_orders'] ?? 0 }}</strong></div>
                    <div class="mini-stat"><span>Sản phẩm yêu thích</span><strong>{{ $accountStats['wishlist_products'] ?? 0 }}</strong></div>
                    <div class="mini-stat"><span>Bảo hành còn hiệu lực</span><strong>{{ $accountStats['active_warranties'] ?? 0 }}</strong></div>
                    <div class="mini-stat"><span>Tổng đơn hàng</span><strong>{{ $accountStats['total_orders'] ?? 0 }}</strong></div>
                    <div class="mini-stat"><span>Thiết bị đã mua</span><strong>{{ $accountStats['purchased_items'] ?? 0 }}</strong></div>
                    <div class="mini-stat"><span>Địa chỉ đã lưu</span><strong>{{ $accountStats['address_count'] ?? 0 }}</strong></div>
                </div>
                <h3 class="panel-title">Hoạt động gần đây</h3>
                <div class="timeline">
                    @forelse($recentActivities as $activity)
                        <a class="timeline-item timeline-item--link" href="{{ $activity->url }}">
                            <i class="{{ $activity->icon }}"></i>
                            <div>
                                <strong>{{ $activity->title }}</strong>
                                <p class="muted">{{ $activity->meta }}</p>
                                @if($activity->display_time)
                                    <span class="muted">{{ $activity->display_time }}</span>
                                @endif
                            </div>
                        </a>
                    @empty
                        <div class="empty-state empty-state--small">
                            <strong>Chưa có hoạt động nào</strong>
                            <span>Đơn hàng, sản phẩm yêu thích và bảo hành sẽ xuất hiện tại đây.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
