@extends('frontend.layouts.tech')

@section('title', 'Đăng ký | Đồ Công Nghệ')

@section('content')
    <section class="inner-section">
        <div class="site-container auth-shell">
            <div class="auth-visual">
                <h1>Tạo tài khoản để mua sắm nhanh hơn.</h1>
                <p>Lưu địa chỉ, sản phẩm yêu thích và lịch sử bảo hành cho các thiết bị của bạn.</p>
            </div>

            <form class="auth-card stack" action="{{ route('frontend.signup.store') }}" method="post">
                @csrf
                <div>
                    <h1>Đăng ký</h1>
                    <p class="muted">Thông tin cơ bản để tạo tài khoản.</p>
                </div>
                @if ($errors->any())
                    <div class="form-message form-message--error">
                        Vui lòng kiểm tra lại thông tin đăng ký.
                    </div>
                @endif
                <div class="form-grid">
                    <div class="field">
                        <label for="signup-name">Họ tên</label>
                        <input id="signup-name" name="name" type="text" value="{{ old('name') }}" placeholder="Nguyễn Văn A" autocomplete="name" required>
                        @error('name')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field">
                        <label for="signup-phone">Số điện thoại</label>
                        <input id="signup-phone" name="phone" type="tel" value="{{ old('phone') }}" placeholder="0900 000 000" autocomplete="tel" required>
                        @error('phone')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field field--full">
                        <label for="signup-email">Email</label>
                        <input id="signup-email" name="email" type="email" value="{{ old('email') }}" placeholder="ban@example.com" autocomplete="email" required>
                        @error('email')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field">
                        <label for="signup-password">Mật khẩu</label>
                        <input id="signup-password" name="password" type="password" placeholder="Tối thiểu 8 ký tự" autocomplete="new-password" required>
                        @error('password')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field">
                        <label for="signup-password-confirmation">Nhập lại mật khẩu</label>
                        <input id="signup-password-confirmation" name="password_confirmation" type="password" placeholder="Nhập lại mật khẩu" autocomplete="new-password" required>
                    </div>
                </div>
                <button class="primary-action" type="submit">Tạo tài khoản</button>
                <a class="secondary-action" href="{{ route('frontend.signin') }}">Tôi đã có tài khoản</a>
            </form>
        </div>
    </section>
@endsection
