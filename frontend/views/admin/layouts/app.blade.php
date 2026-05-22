<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | Đồ Công Nghệ</title>
    <link rel="stylesheet" href="{{ asset('template/css/vendor.css') }}?v=20260518">
    <link rel="stylesheet" href="{{ asset('template/css/admin.css') }}?v=20260523-admin-sales">
</head>
<body class="admin-body">
    @php
        $adminUser = auth()->user();
        $adminName = $adminUser?->name ?: 'Admin';
        $adminRole = $adminUser?->role?->name ?: 'admin';
        $adminInitial = mb_strtoupper(mb_substr($adminName, 0, 1));
    @endphp

    <div class="admin-shell" id="adminShell">
        <aside class="admin-sidebar">
            <a class="admin-brand" href="{{ route('admin.dashboard') }}" title="Admin Shop">
                <span class="admin-brand__icon"><i class="fas fa-microchip"></i></span>
                <strong>Admin Shop</strong>
            </a>

            <nav class="admin-nav" aria-label="Admin">
                <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" title="Dashboard"><i class="fas fa-chart-line"></i> <span>Dashboard</span></a>
                <a class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}" title="Sản phẩm"><i class="fas fa-box"></i> <span>Sản phẩm</span></a>
                <a class="{{ request()->routeIs('admin.product-images.*') ? 'active' : '' }}" href="{{ route('admin.product-images.index') }}" title="Ảnh sản phẩm"><i class="fas fa-photo-video"></i> <span>Ảnh sản phẩm</span></a>
                <a class="{{ request()->routeIs('admin.product-specifications.*') ? 'active' : '' }}" href="{{ route('admin.product-specifications.index') }}" title="Thông số kỹ thuật"><i class="fas fa-tasks"></i> <span>Thông số kỹ thuật</span></a>
                <a class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}" title="Đơn hàng"><i class="fas fa-receipt"></i> <span>Đơn hàng</span></a>
                <a class="{{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}" href="{{ route('admin.coupons.index') }}" title="Mã giảm giá"><i class="fas fa-tags"></i> <span>Mã giảm giá</span></a>
                <a class="{{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}" href="{{ route('admin.reviews.index') }}" title="Đánh giá"><i class="fas fa-star-half-alt"></i> <span>Đánh giá</span></a>
                <a class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}" title="Danh mục"><i class="fas fa-layer-group"></i> <span>Danh mục</span></a>
                <a class="{{ request()->routeIs('admin.brands.*') ? 'active' : '' }}" href="{{ route('admin.brands.index') }}" title="Thương hiệu"><i class="fas fa-copyright"></i> <span>Thương hiệu</span></a>
                <a class="{{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}" title="Banner"><i class="fas fa-images"></i> <span>Banner</span></a>
            </nav>

            <form class="admin-sidebar__logout" action="{{ route('frontend.logout') }}" method="post">
                @csrf
                <button type="submit" title="Đăng xuất"><i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span></button>
            </form>
        </aside>

        <div class="admin-main">
            <header class="admin-topbar">
                <div class="admin-topbar__left">
                    <button class="admin-menu-toggle" type="button" id="adminSidebarToggle" aria-label="Ẩn hiện menu" aria-expanded="true">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h1>@yield('page_title', 'Admin')</h1>
                </div>

                <div class="admin-profile" title="{{ $adminName }}">
                    <span class="admin-profile__avatar">{{ $adminInitial }}</span>
                    <span class="admin-profile__meta">
                        <strong>{{ $adminName }}</strong>
                        <small>{{ $adminRole }}</small>
                    </span>
                </div>
            </header>

            <main class="admin-content">
                @if(session('status'))
                    <div class="admin-alert admin-alert--success">{{ session('status') }}</div>
                @endif

                @if(isset($errors) && $errors->any())
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

    <script>
        (() => {
            const shell = document.getElementById('adminShell');
            const toggle = document.getElementById('adminSidebarToggle');
            const storageKey = 'adminSidebarCollapsed';

            if (!shell || !toggle) {
                return;
            }

            const setCollapsed = (collapsed) => {
                shell.classList.toggle('is-sidebar-collapsed', collapsed);
                toggle.setAttribute('aria-expanded', String(!collapsed));
                localStorage.setItem(storageKey, collapsed ? '1' : '0');
            };

            setCollapsed(localStorage.getItem(storageKey) === '1');
            toggle.addEventListener('click', () => {
                setCollapsed(!shell.classList.contains('is-sidebar-collapsed'));
            });
        })();
    </script>
</body>
</html>
