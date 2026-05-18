@php($active = $active ?? 'dashboard')

<nav class="account-nav" aria-label="Tài khoản">
    <a class="{{ $active === 'dashboard' ? 'active' : '' }}" href="{{ route('frontend.dashboard') }}"><i class="fas fa-th-large"></i> Tổng quan</a>
    <a class="{{ $active === 'orders' ? 'active' : '' }}" href="{{ url('/dash-my-order.html') }}"><i class="fas fa-receipt"></i> Đơn hàng</a>
    <a class="{{ $active === 'track' ? 'active' : '' }}" href="{{ url('/dash-track-order.html') }}"><i class="fas fa-truck"></i> Theo dõi đơn</a>
    <a class="{{ $active === 'profile' ? 'active' : '' }}" href="{{ url('/dash-my-profile.html') }}"><i class="fas fa-user"></i> Hồ sơ</a>
    <a class="{{ $active === 'address' ? 'active' : '' }}" href="{{ url('/dash-address-book.html') }}"><i class="fas fa-map-marker-alt"></i> Địa chỉ</a>
    <a class="{{ $active === 'payment' ? 'active' : '' }}" href="{{ url('/dash-payment-option.html') }}"><i class="fas fa-credit-card"></i> Thanh toán</a>
    <a class="{{ $active === 'cancellation' ? 'active' : '' }}" href="{{ url('/dash-cancellation.html') }}"><i class="fas fa-ban"></i> Hủy đơn</a>
</nav>
