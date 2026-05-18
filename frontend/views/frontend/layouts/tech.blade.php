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
    <link rel="stylesheet" href="{{ asset('template/css/home-redesign.css') }}?v=20260518-site3">
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
                    <span>2</span>
                </a>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

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
</body>
</html>
