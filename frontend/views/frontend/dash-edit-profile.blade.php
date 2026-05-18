@extends('frontend.layouts.tech')

@section('title', 'Chỉnh sửa hồ sơ | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <h1>Chỉnh sửa hồ sơ</h1>
            <p>Cập nhật thông tin liên hệ để nhận hỗ trợ nhanh hơn.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container account-layout">
            @include('frontend.partials.account-nav', ['active' => 'profile'])

            <form class="account-panel stack" action="{{ url('/dash-my-profile.html') }}" method="get">
                <h2 class="panel-title">Thông tin cá nhân</h2>
                <div class="form-grid">
                    <div class="field">
                        <label for="profile-name">Họ tên</label>
                        <input id="profile-name" type="text" value="Nguyễn Minh Anh">
                    </div>
                    <div class="field">
                        <label for="profile-phone">Số điện thoại</label>
                        <input id="profile-phone" type="tel" value="0901000004">
                    </div>
                    <div class="field field--full">
                        <label for="profile-email">Email</label>
                        <input id="profile-email" type="email" value="minhanh@example.com">
                    </div>
                </div>
                <button class="primary-action" type="submit">Lưu thay đổi</button>
            </form>
        </div>
    </section>
@endsection
