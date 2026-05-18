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
                <h2 class="panel-title">Nguyễn Minh Anh</h2>
                <div class="spec-grid">
                    <div><span>Email</span><strong>minhanh@example.com</strong></div>
                    <div><span>Số điện thoại</span><strong>0901 000 004</strong></div>
                    <div><span>Hạng khách hàng</span><strong>Member</strong></div>
                    <div><span>Thiết bị đã mua</span><strong>5 sản phẩm</strong></div>
                </div>
                <div class="hero__actions u-m-t-20">
                    <a class="primary-action" href="{{ url('/dash-edit-profile.html') }}">Chỉnh sửa hồ sơ</a>
                    <a class="secondary-action" href="{{ route('frontend.wishlist') }}">Xem yêu thích</a>
                </div>
            </div>
        </div>
    </section>
@endsection
