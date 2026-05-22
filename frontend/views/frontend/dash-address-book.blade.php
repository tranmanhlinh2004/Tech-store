@extends('frontend.layouts.tech')

@section('title', 'Sổ địa chỉ | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <h1>Sổ địa chỉ</h1>
            <p>Quản lý địa chỉ giao hàng và thanh toán mặc định.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container account-layout">
            @include('frontend.partials.account-nav', ['active' => 'address'])

            <div class="account-panel">
                <div class="shop-toolbar">
                    <h2 class="panel-title u-m-0">Địa chỉ đã lưu</h2>
                    <a class="primary-action" href="{{ url('/dash-address-add.html') }}">Thêm địa chỉ</a>
                </div>
                @if($addresses->isNotEmpty())
                    <div class="address-grid">
                        @foreach($addresses as $address)
                            <div class="info-card">
                                <span class="{{ $address->is_default ? 'status-badge' : 'status-badge status-badge--muted' }}">
                                    {{ $address->is_default ? 'Mặc định' : $address->type_label }}
                                </span>
                                <h3>{{ $address->full_name }}</h3>
                                <p class="muted">{{ $address->phone }}</p>
                                <p class="muted">{{ $address->full_address }}</p>
                                <div class="hero__actions">
                                    <a class="secondary-action" href="{{ route('frontend.account.addresses.edit') }}">Sửa</a>
                                    @unless($address->is_default)
                                        <a class="secondary-action" href="{{ route('frontend.account.addresses') }}">Đặt mặc định</a>
                                    @endunless
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state empty-state--small">
                        <strong>Chưa có địa chỉ</strong>
                        <span>Thêm địa chỉ giao hàng để đặt hàng nhanh hơn.</span>
                        <a class="primary-action" href="{{ url('/dash-address-add.html') }}">Thêm địa chỉ</a>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
