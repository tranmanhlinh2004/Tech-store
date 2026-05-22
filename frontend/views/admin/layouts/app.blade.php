<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | Đồ Công Nghệ</title>
    <link rel="stylesheet" href="{{ asset('template/css/vendor.css') }}?v=20260518">
    <link rel="stylesheet" href="{{ asset('template/css/admin.css') }}?v=20260523-admin-rbac">
</head>
<body class="admin-body">
    @php
        $adminUser = auth()->user();
        $adminName = $adminUser?->name ?: 'Admin';
        $adminRole = $adminUser?->role?->name ?: 'admin';
        $adminInitial = mb_strtoupper(mb_substr($adminName, 0, 1));
        $adminCan = fn (string $permission): bool => $adminUser?->hasPermission($permission) ?? false;
        $adminNavItems = [
            ['route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'permission' => 'dashboard.view', 'icon' => 'fa-chart-line', 'label' => 'Dashboard'],
            ['route' => 'admin.users.index', 'active' => 'admin.users.*', 'permission' => 'users.view', 'icon' => 'fa-users', 'label' => 'Tài khoản'],
            ['route' => 'admin.roles.index', 'active' => 'admin.roles.*', 'permission' => 'roles.manage', 'icon' => 'fa-user-shield', 'label' => 'Vai trò & quyền'],
            ['route' => 'admin.products.index', 'active' => 'admin.products.*', 'permission' => 'products.view', 'icon' => 'fa-box', 'label' => 'Sản phẩm'],
            ['route' => 'admin.product-images.index', 'active' => 'admin.product-images.*', 'permission' => 'products.update', 'icon' => 'fa-photo-video', 'label' => 'Ảnh sản phẩm'],
            ['route' => 'admin.product-specifications.index', 'active' => 'admin.product-specifications.*', 'permission' => 'products.update', 'icon' => 'fa-tasks', 'label' => 'Thông số kỹ thuật'],
            ['route' => 'admin.orders.index', 'active' => 'admin.orders.*', 'permission' => 'orders.view', 'icon' => 'fa-receipt', 'label' => 'Đơn hàng'],
            ['route' => 'admin.coupons.index', 'active' => 'admin.coupons.*', 'permission' => 'coupons.manage', 'icon' => 'fa-tags', 'label' => 'Mã giảm giá'],
            ['route' => 'admin.reviews.index', 'active' => 'admin.reviews.*', 'permission' => 'reviews.manage', 'icon' => 'fa-star-half-alt', 'label' => 'Đánh giá'],
            ['route' => 'admin.categories.index', 'active' => 'admin.categories.*', 'permission' => 'categories.manage', 'icon' => 'fa-layer-group', 'label' => 'Danh mục'],
            ['route' => 'admin.brands.index', 'active' => 'admin.brands.*', 'permission' => 'brands.manage', 'icon' => 'fa-copyright', 'label' => 'Thương hiệu'],
            ['route' => 'admin.banners.index', 'active' => 'admin.banners.*', 'permission' => 'banners.manage', 'icon' => 'fa-images', 'label' => 'Banner'],
        ];
        $adminHomeItem = collect($adminNavItems)->first(fn (array $item): bool => $adminCan($item['permission']));
        $adminHomeHref = $adminHomeItem ? route($adminHomeItem['route']) : route('frontend.home');
    @endphp

    <div class="admin-shell" id="adminShell">
        <aside class="admin-sidebar">
            <a class="admin-brand" href="{{ $adminHomeHref }}" title="Admin Shop">
                <span class="admin-brand__icon"><i class="fas fa-microchip"></i></span>
                <strong>Admin Shop</strong>
            </a>

            <nav class="admin-nav" aria-label="Admin">
                @foreach($adminNavItems as $item)
                    @if($adminCan($item['permission']))
                        <a class="{{ request()->routeIs($item['active']) ? 'active' : '' }}" href="{{ route($item['route']) }}" title="{{ $item['label'] }}"><i class="fas {{ $item['icon'] }}"></i> <span>{{ $item['label'] }}</span></a>
                    @endif
                @endforeach
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
