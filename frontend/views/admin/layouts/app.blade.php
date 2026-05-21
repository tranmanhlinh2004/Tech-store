<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | Đồ Công Nghệ</title>
    <link rel="stylesheet" href="{{ asset('template/css/vendor.css') }}?v=20260518">
    <link rel="stylesheet" href="{{ asset('template/css/admin.css') }}?v=20260521-admin-stats">
</head>
<body class="admin-body">
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a class="admin-brand" href="{{ route('admin.dashboard') }}">
                <span><i class="fas fa-microchip"></i></span>
                <strong>Admin Shop</strong>
            </a>

            <nav class="admin-nav" aria-label="Admin">
                <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><i class="fas fa-chart-line"></i> Dashboard</a>
                <a class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}"><i class="fas fa-box"></i> Sản phẩm</a>
                <a class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}"><i class="fas fa-layer-group"></i> Danh mục</a>
                <a class="{{ request()->routeIs('admin.brands.*') ? 'active' : '' }}" href="{{ route('admin.brands.index') }}"><i class="fas fa-copyright"></i> Thương hiệu</a>
                <a class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}"><i class="fas fa-images"></i> Banner</a>
                <a href="{{ route('frontend.home') }}"><i class="fas fa-store"></i> Xem website</a>
            </nav>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <h1>@yield('page_title', 'Admin')</h1>
                <a href="{{ route('frontend.home') }}" target="_blank" rel="noreferrer">Mở trang chủ <i class="fas fa-external-link-alt"></i></a>
            </header>

            <main class="admin-content">
                @if(session('status'))
                    <div class="admin-alert admin-alert--success">{{ session('status') }}</div>
                @endif

                @if($errors->any())
                    <div class="admin-alert admin-alert--error">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
