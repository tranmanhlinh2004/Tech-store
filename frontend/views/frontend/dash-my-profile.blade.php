@extends('frontend.layouts.tech')

@section('title', 'Hồ sơ cá nhân | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <h1>Hồ sơ cá nhân</h1>
            <p>Thông tin dùng cho đơn hàng, bảo hành và hỗ trợ kỹ thuật.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container account-layout">
            @include('frontend.partials.account-nav', ['active' => 'profile'])

            <div class="account-panel">
                <h2 class="panel-title">{{ auth()->user()->name }}</h2>
                <div class="spec-grid">
                    <div><span>Email</span><strong>{{ auth()->user()->email }}</strong></div>
                    <div><span>Số điện thoại</span><strong>{{ auth()->user()->phone ?: 'Chưa cập nhật' }}</strong></div>
                    <div><span>Trạng thái</span><strong>{{ auth()->user()->status === 'active' ? 'Đang hoạt động' : 'Tạm khóa' }}</strong></div>
                    <div><span>Ngày tham gia</span><strong>{{ optional(auth()->user()->created_at)->format('d/m/Y') ?: 'Chưa cập nhật' }}</strong></div>
                    <div><span>Tổng đơn hàng</span><strong>{{ $accountStats['total_orders'] ?? 0 }}</strong></div>
                    <div><span>Thiết bị đã mua</span><strong>{{ $accountStats['purchased_items'] ?? 0 }} sản phẩm</strong></div>
                    <div><span>Địa chỉ đã lưu</span><strong>{{ $accountStats['address_count'] ?? 0 }}</strong></div>
                    <div><span>Phương thức thanh toán</span><strong>{{ $accountStats['payment_count'] ?? 0 }}</strong></div>
                </div>
                <div class="hero__actions u-m-t-20">
                    <a class="primary-action" href="{{ url('/dash-edit-profile.html') }}">Chỉnh sửa hồ sơ</a>
                    <a class="secondary-action" href="{{ route('frontend.wishlist') }}">Xem yêu thích</a>
                </div>
            </div>
        </div>
    </section>
@endsection
