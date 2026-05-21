@extends('frontend.layouts.tech')

@section('title', 'Đăng nhập | Đồ Công Nghệ')

@section('content')
    <section class="inner-section">
        <div class="site-container auth-shell">
            <div class="auth-visual">
                <h1>Quản lý đơn hàng và ưu đãi cá nhân.</h1>
                <p>Đăng nhập để theo dõi bảo hành, lưu sản phẩm yêu thích và nhận gợi ý phù hợp.</p>
            </div>

            <form class="auth-card stack" action="{{ route('frontend.signin.store') }}" method="post">
                @csrf
                <div>
                    <h1>Đăng nhập</h1>
                    <p class="muted">Sử dụng tài khoản Đồ Công Nghệ của bạn.</p>
                </div>
                @if ($errors->any())
                    <div class="form-message form-message--error">
                        {{ $errors->first() }}
                    </div>
                @endif
                <div class="field">
                    <label for="signin-email">Email</label>
                    <input id="signin-email" name="email" type="email" value="{{ old('email') }}" placeholder="ban@example.com" autocomplete="email" required>
                </div>
                <div class="field">
                    <label for="signin-password">Mật khẩu</label>
                    <input id="signin-password" name="password" type="password" placeholder="••••••••" autocomplete="current-password" required>
                </div>
                <label class="check-line">
                    <input type="checkbox" name="remember" value="1" @checked(old('remember'))>
                    <span>Ghi nhớ đăng nhập</span>
                </label>
                <button class="primary-action" type="submit">Đăng nhập</button>
                <a class="secondary-action" href="{{ route('frontend.signup') }}">Tạo tài khoản mới</a>
                <a class="muted" href="{{ url('/lost-password.html') }}">Quên mật khẩu?</a>
            </form>
        </div>
    </section>
@endsection
