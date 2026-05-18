@extends('frontend.layouts.tech')

@section('title', 'Đăng ký | Đồ Công Nghệ')

@section('content')
    <section class="inner-section">
        <div class="site-container auth-shell">
            <div class="auth-visual">
                <h1>Tạo tài khoản để mua sắm nhanh hơn.</h1>
                <p>Lưu địa chỉ, sản phẩm yêu thích và lịch sử bảo hành cho các thiết bị của bạn.</p>
            </div>

            <form class="auth-card stack" action="{{ route('frontend.dashboard') }}" method="get">
                <div>
                    <h1>Đăng ký</h1>
                    <p class="muted">Thông tin cơ bản để tạo tài khoản.</p>
                </div>
                <div class="form-grid">
                    <div class="field">
                        <label for="signup-name">Họ tên</label>
                        <input id="signup-name" type="text" placeholder="Nguyễn Văn A">
                    </div>
                    <div class="field">
                        <label for="signup-phone">Số điện thoại</label>
                        <input id="signup-phone" type="tel" placeholder="0900 000 000">
                    </div>
                    <div class="field field--full">
                        <label for="signup-email">Email</label>
                        <input id="signup-email" type="email" placeholder="ban@example.com">
                    </div>
                    <div class="field field--full">
                        <label for="signup-password">Mật khẩu</label>
                        <input id="signup-password" type="password" placeholder="Tối thiểu 8 ký tự">
                    </div>
                </div>
                <button class="primary-action" type="submit">Tạo tài khoản</button>
                <a class="secondary-action" href="{{ route('frontend.signin') }}">Tôi đã có tài khoản</a>
            </form>
        </div>
    </section>
@endsection
