@extends('frontend.layouts.tech')

@section('title', 'Sổ địa chỉ | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <h1>Sổ địa chỉ</h1>
            <p>Quản lý địa chỉ giao hàng và thanh toán mặc định.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container account-layout">
            @include('frontend.partials.account-nav', ['active' => 'address'])

            <div class="account-panel">
                <div class="shop-toolbar">
                    <h2 class="panel-title u-m-0">Địa chỉ đã lưu</h2>
                    <a class="primary-action" href="{{ url('/dash-address-add.html') }}">Thêm địa chỉ</a>
                </div>
                <div class="address-grid">
                    <div class="info-card">
                        <span class="status-badge">Mặc định</span>
                        <h3>Nguyễn Minh Anh</h3>
                        <p class="muted">123 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh</p>
                        <div class="hero__actions">
                            <a class="secondary-action" href="{{ url('/dash-address-edit.html') }}">Sửa</a>
                        </div>
                    </div>
                    <div class="info-card">
                        <span class="status-badge--muted status-badge">Văn phòng</span>
                        <h3>Minh Anh</h3>
                        <p class="muted">88 Lê Văn Sỹ, Quận 3, TP. Hồ Chí Minh</p>
                        <div class="hero__actions">
                            <a class="secondary-action" href="{{ url('/dash-address-make-default.html') }}">Đặt mặc định</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
