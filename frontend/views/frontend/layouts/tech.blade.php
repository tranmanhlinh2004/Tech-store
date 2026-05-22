<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('meta_description', 'Đồ Công Nghệ - laptop, điện thoại, phụ kiện và thiết bị thông minh chính hãng.')">
    <link href="{{ asset('template/images/favicon.png') }}" rel="shortcut icon">
    <title>@yield('title', 'Đồ Công Nghệ')</title>

    <link rel="stylesheet" href="{{ asset('template/css/vendor.css') }}?v=20260518">
    <link rel="stylesheet" href="{{ asset('template/css/home-redesign.css') }}?v=20260523-reviews">
</head>
<body>
    <header class="site-header">
        <div class="top-strip">
            <div class="site-container top-strip__inner">
                <span><i class="fas fa-shield-alt"></i> Bảo hành chính hãng đến 36 tháng</span>
                <span><i class="fas fa-truck"></i> Giao nhanh trong ngày tại nội thành</span>
                <a href="tel:0900901904"><i class="fas fa-phone-alt"></i> 0900 901 904</a>
            </div>
        </div>

        <div class="site-container nav-bar">
            <a class="brand" href="{{ route('frontend.home') }}" aria-label="Đồ Công Nghệ">
                <span class="brand__mark"><i class="fas fa-microchip"></i></span>
                <span class="brand__text">Đồ Công Nghệ</span>
            </a>

            <form class="search-bar" action="{{ route('frontend.shop') }}" method="get">
                <label class="sr-only" for="site-search">Tìm kiếm sản phẩm</label>
                <i class="fas fa-search"></i>
                <input id="site-search" name="q" type="search" placeholder="Tìm laptop, điện thoại, tai nghe...">
                <button type="submit">Tìm kiếm</button>
            </form>

            <nav class="main-nav" aria-label="Điều hướng chính">
                <a href="{{ route('frontend.shop') }}">Sản phẩm</a>
                <a href="{{ route('frontend.about') }}">Về chúng tôi</a>
                <a href="{{ route('frontend.contact') }}">Liên hệ</a>
            </nav>

            <div class="nav-actions">
                <a class="icon-button" href="{{ route('frontend.wishlist') }}" aria-label="Yêu thích">
                    <i class="far fa-heart"></i>
                </a>
                <a class="icon-button icon-button--cart" href="{{ route('frontend.cart') }}" aria-label="Giỏ hàng">
                    <i class="fas fa-shopping-bag"></i>
                    <span data-cart-count>{{ $cartItemCount ?? 0 }}</span>
                </a>
                @auth
                    <div class="account-menu">
                        <a class="account-chip" href="{{ route('frontend.dashboard') }}" aria-label="Tài khoản">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ auth()->user()->name }}</span>
                        </a>
                        <form action="{{ route('frontend.logout') }}" method="post">
                            @csrf
                            <button class="account-logout" type="submit" aria-label="Đăng xuất" title="Đăng xuất">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="auth-links" aria-label="Tài khoản">
                        <a class="auth-link" href="{{ route('frontend.signin') }}">Đăng nhập</a>
                        <a class="auth-link auth-link--primary" href="{{ route('frontend.signup') }}">Đăng ký</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    @php
        $toastMessage = session('status') ?: session('error') ?: ($errors->any() ? $errors->first() : null);
        $toastType = session('status') ? 'success' : ($toastMessage ? 'error' : null);
    @endphp

    <main>
        @yield('content')
    </main>

    <div class="toast-stack" data-toast-stack aria-live="polite" aria-atomic="true">
        @if($toastMessage)
            <div class="toast-notification toast-notification--{{ $toastType }}" data-toast role="alert">
                <span class="toast-notification__icon">
                    <i class="fas {{ $toastType === 'success' ? 'fa-check' : 'fa-exclamation-triangle' }}"></i>
                </span>
                <span>{{ $toastMessage }}</span>
            </div>
        @endif
    </div>

    @guest
        <div class="cart-login-modal" id="cart-login-modal" role="dialog" aria-modal="true" aria-labelledby="cart-login-modal-title" hidden>
            <div class="cart-login-modal__backdrop" data-cart-login-close></div>
            <div class="cart-login-modal__dialog" role="document">
                <button class="cart-login-modal__close" type="button" aria-label="Đóng" data-cart-login-close>
                    <i class="fas fa-times"></i>
                </button>
                <span class="cart-login-modal__icon"><i class="fas fa-lock"></i></span>
                <h2 id="cart-login-modal-title">Vui lòng đăng nhập</h2>
                <p>Vui lòng đăng nhập để thêm giỏ hàng.</p>
                <div class="cart-login-modal__actions">
                    <a class="primary-action" href="{{ route('frontend.signin') }}">Đăng nhập</a>
                    <button class="secondary-action" type="button" data-cart-login-close>Tiếp tục xem</button>
                </div>
            </div>
        </div>
    @endguest

    <footer class="site-footer">
        <div class="site-container footer-grid">
            <div>
                <a class="brand brand--footer" href="{{ route('frontend.home') }}">
                    <span class="brand__mark"><i class="fas fa-microchip"></i></span>
                    <span class="brand__text">Đồ Công Nghệ</span>
                </a>
                <p>Shop thiết bị công nghệ cho học tập, làm việc, giải trí và nâng cấp góc làm việc cá nhân.</p>
            </div>
            <div>
                <strong>Cửa hàng</strong>
                <a href="{{ route('frontend.shop') }}">Sản phẩm</a>
                <a href="{{ route('frontend.cart') }}">Giỏ hàng</a>
                <a href="{{ route('frontend.wishlist') }}">Yêu thích</a>
            </div>
            <div>
                <strong>Hỗ trợ</strong>
                <a href="{{ route('frontend.about') }}">Giới thiệu</a>
                <a href="{{ route('frontend.contact') }}">Liên hệ</a>
                <a href="mailto:contact@docongnghe.com">contact@docongnghe.com</a>
            </div>
            <div>
                <strong>Liên hệ nhanh</strong>
                <span>0900 901 904</span>
                <span>08:00 - 21:00 mỗi ngày</span>
                <span>TP. Hồ Chí Minh</span>
            </div>
        </div>
        <div class="site-container footer-bottom">
            <span>© 2026 Đồ Công Nghệ. All rights reserved.</span>
            <span>Thanh toán an toàn · Bảo hành minh bạch</span>
        </div>
    </footer>
    <script>
        (function () {
            var stack = document.querySelector('[data-toast-stack]');

            if (!stack) {
                return;
            }

            var toastDuration = 2000;
            var toastExitDuration = 220;

            function removeToast(toast) {
                if (!toast) {
                    return;
                }

                toast.classList.add('toast-notification--hide');
                window.setTimeout(function () {
                    toast.remove();
                }, toastExitDuration);
            }

            window.showToastNotification = function (message, type) {
                var toast = document.createElement('div');
                var toastType = type === 'error' ? 'error' : 'success';
                var iconClass = toastType === 'success' ? 'fa-check' : 'fa-exclamation-triangle';

                toast.className = 'toast-notification toast-notification--' + toastType;
                toast.dataset.toast = 'true';
                toast.style.setProperty('--toast-duration', toastDuration + 'ms');
                toast.setAttribute('role', 'alert');
                toast.innerHTML = '<span class="toast-notification__icon"><i class="fas ' + iconClass + '"></i></span><span></span>';
                toast.querySelector('span:last-child').textContent = message || (toastType === 'success' ? 'Thao tác thành công.' : 'Đã có lỗi xảy ra.');

                stack.appendChild(toast);
                window.setTimeout(function () {
                    removeToast(toast);
                }, toastDuration);
            };

            stack.querySelectorAll('[data-toast]').forEach(function (toast) {
                toast.style.setProperty('--toast-duration', toastDuration + 'ms');
                window.setTimeout(function () {
                    removeToast(toast);
                }, toastDuration);
            });
        })();
    </script>
    @guest
        <script>
            (function () {
                var modal = document.getElementById('cart-login-modal');

                if (!modal) {
                    return;
                }

                var previousFocus = null;

                function openCartLoginModal() {
                    previousFocus = document.activeElement;
                    modal.hidden = false;
                    document.documentElement.classList.add('cart-login-modal-open');

                    var loginLink = modal.querySelector('.primary-action');

                    if (loginLink) {
                        loginLink.focus();
                    }
                }

                function closeCartLoginModal() {
                    modal.hidden = true;
                    document.documentElement.classList.remove('cart-login-modal-open');

                    if (previousFocus && typeof previousFocus.focus === 'function') {
                        previousFocus.focus();
                    }
                }

                document.addEventListener('click', function (event) {
                    var trigger = event.target.closest('[data-cart-login-trigger]');

                    if (!trigger || trigger.tagName === 'FORM') {
                        return;
                    }

                    event.preventDefault();
                    openCartLoginModal();
                });

                document.addEventListener('submit', function (event) {
                    if (!event.target.matches('[data-cart-login-trigger]')) {
                        return;
                    }

                    event.preventDefault();
                    openCartLoginModal();
                });

                modal.addEventListener('click', function (event) {
                    if (!event.target.closest('[data-cart-login-close]')) {
                        return;
                    }

                    event.preventDefault();
                    closeCartLoginModal();
                });

                document.addEventListener('keydown', function (event) {
                    if (event.key === 'Escape' && !modal.hidden) {
                        closeCartLoginModal();
                    }
                });

                @if (session('cart_login_required'))
                    openCartLoginModal();
                @endif
            })();
        </script>
    @endguest
</body>
</html>
