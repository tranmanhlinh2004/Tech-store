@extends('frontend.layouts.tech')

@section('title', 'Đăng nhập | Đồ Công Nghệ')

@section('content')
    <section class="inner-section">
        <div class="site-container auth-shell">
            <div class="auth-visual">
                <h1>Quản lý đơn hàng và ưu đãi cá nhân.</h1>
                <p>Đăng nhập để theo dõi bảo hành, lưu sản phẩm yêu thích và nhận gợi ý phù hợp.</p>
            </div>

            <form class="auth-card stack" action="{{ route('frontend.dashboard') }}" method="get">
                <div>
                    <h1>Đăng nhập</h1>
                    <p class="muted">Sử dụng tài khoản Đồ Công Nghệ của bạn.</p>
                </div>
                <div class="field">
                    <label for="signin-email">Email</label>
                    <input id="signin-email" type="email" placeholder="ban@example.com">
                </div>
                <div class="field">
                    <label for="signin-password">Mật khẩu</label>
                    <input id="signin-password" type="password" placeholder="••••••••">
                </div>
                <button class="primary-action" type="submit">Đăng nhập</button>
                <a class="secondary-action" href="{{ route('frontend.signup') }}">Tạo tài khoản mới</a>
                <a class="muted" href="{{ url('/lost-password.html') }}">Quên mật khẩu?</a>
            </form>
        </div>
    </section>
@endsection
