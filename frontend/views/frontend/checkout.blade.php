@extends('frontend.layouts.tech')

@section('title', 'Thanh toán | Đồ Công Nghệ')

@php
    $formatPrice = fn ($value) => number_format((float) $value, 0, ',', '.').'đ';
    $defaultAddressText = $defaultAddress?->full_address ?? '';
@endphp

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend.home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Thanh toán</span>
            </div>
            <h1>Hoàn tất đơn hàng</h1>
            <p>Nhập thông tin giao hàng và chọn phương thức thanh toán phù hợp.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container checkout-layout">
            <form class="auth-card stack" action="{{ route('frontend.checkout.store') }}" method="post">
                @csrf
                <input type="hidden" name="checkout_source" value="{{ $checkoutSource ?? 'cart' }}">
                <h2 class="panel-title">Thông tin nhận hàng</h2>
                <div class="form-grid">
                    <div class="field">
                        <label for="checkout-name">Họ tên</label>
                        <input id="checkout-name" name="customer_name" type="text" value="{{ old('customer_name', auth()->user()->name) }}" autocomplete="name" required>
                        @error('customer_name')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field">
                        <label for="checkout-phone">Số điện thoại</label>
                        <input id="checkout-phone" name="customer_phone" type="tel" value="{{ old('customer_phone', $defaultAddress?->phone ?: auth()->user()->phone) }}" autocomplete="tel" required>
                        @error('customer_phone')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field field--full">
                        <label for="checkout-email">Email</label>
                        <input id="checkout-email" name="customer_email" type="email" value="{{ old('customer_email', auth()->user()->email) }}" autocomplete="email" required>
                        @error('customer_email')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field field--full">
                        <label for="checkout-address">Địa chỉ</label>
                        <input id="checkout-address" name="shipping_address" type="text" value="{{ old('shipping_address', $defaultAddressText) }}" placeholder="Số nhà, đường, phường/xã, quận/huyện" autocomplete="street-address" required>
                        @error('shipping_address')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field">
                        <label for="checkout-shipping">Giao hàng</label>
                        <select id="checkout-shipping" name="shipping_method" required>
                            @foreach($shippingMethods as $value => $label)
                                <option value="{{ $value }}" @selected(old('shipping_method', 'standard') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('shipping_method')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field">
                        <label for="checkout-payment">Thanh toán</label>
                        <select id="checkout-payment" name="payment_method" required>
                            <option value="cod" @selected(old('payment_method', 'cod') === 'cod')>COD - Thanh toán khi nhận hàng</option>
                        </select>
                        @error('payment_method')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field field--full">
                        <label for="checkout-note">Ghi chú</label>
                        <textarea id="checkout-note" name="note" placeholder="Ví dụ: gọi trước khi giao, giao ngoài giờ hành chính...">{{ old('note') }}</textarea>
                        @error('note')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <button class="primary-action" type="submit"><i class="fas fa-truck"></i> Đặt hàng COD</button>
            </form>

            <aside class="summary-card">
                <h2 class="panel-title">Đơn hàng</h2>
                @if(($checkoutSource ?? 'cart') === 'buy_now')
                    <p class="muted">Bạn đang thanh toán nhanh cho sản phẩm vừa chọn.</p>
                @endif
                <div class="summary-list">
                    @foreach($cartItems as $item)
                        <div>
                            <span>{{ $item->name }}{{ $item->quantity > 1 ? ' x'.$item->quantity : '' }}</span>
                            <strong>{{ $item->display_line_total }}</strong>
                        </div>
                    @endforeach
                    <div><span>Tạm tính</span><strong>{{ $formatPrice($checkoutSummary['regular_subtotal']) }}</strong></div>
                    @if(($checkoutSummary['discount'] ?? 0) > 0)
                        <div><span>Giảm giá</span><strong>-{{ $formatPrice($checkoutSummary['discount']) }}</strong></div>
                    @endif
                    <div><span>Vận chuyển</span><strong>Miễn phí</strong></div>
                    <div class="summary-total"><span>Tổng cộng</span><strong>{{ $formatPrice($checkoutSummary['total']) }}</strong></div>
                </div>
                <p class="muted">Nhân viên sẽ xác nhận đơn hàng qua điện thoại trước khi giao. COD sẽ được ghi nhận là chưa thanh toán cho đến khi giao hàng thành công.</p>
            </aside>
        </div>
    </section>
@endsection
