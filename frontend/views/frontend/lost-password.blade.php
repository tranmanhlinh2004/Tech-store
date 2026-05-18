@extends('frontend.layouts.tech')

@section('title', 'Khôi phục mật khẩu | Đồ Công Nghệ')

@section('content')
    <section class="inner-section">
        <div class="site-container auth-shell">
            <div class="auth-visual">
                <h1>Khôi phục quyền truy cập tài khoản.</h1>
                <p>Nhập email đã đăng ký, hệ thống sẽ gửi hướng dẫn đặt lại mật khẩu.</p>
            </div>

            <form class="auth-card stack" action="{{ route('frontend.signin') }}" method="get">
                <div>
                    <h1>Quên mật khẩu</h1>
                    <p class="muted">Bạn sẽ nhận email hướng dẫn trong vài phút.</p>
                </div>
                <div class="field">
                    <label for="lost-email">Email</label>
                    <input id="lost-email" type="email" placeholder="ban@example.com">
                </div>
                <button class="primary-action" type="submit">Gửi hướng dẫn</button>
                <a class="secondary-action" href="{{ route('frontend.signin') }}">Quay lại đăng nhập</a>
            </form>
        </div>
    </section>
@endsection
