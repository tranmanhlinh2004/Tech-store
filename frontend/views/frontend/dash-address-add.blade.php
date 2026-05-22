@extends('frontend.layouts.tech')

@section('title', 'Thêm địa chỉ | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <h1>Thêm địa chỉ mới</h1>
            <p>Địa chỉ chính xác giúp giao hàng nhanh và hạn chế gọi xác nhận nhiều lần.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container account-layout">
            @include('frontend.partials.account-nav', ['active' => 'address'])

            <form class="account-panel stack" action="{{ route('frontend.account.addresses') }}" method="get">
                <h2 class="panel-title">Thông tin địa chỉ</h2>
                <div class="form-grid">
                    <div class="field">
                        <label for="address-name">Người nhận</label>
                        <input id="address-name" type="text" placeholder="{{ auth()->user()->name }}">
                    </div>
                    <div class="field">
                        <label for="address-phone">Số điện thoại</label>
                        <input id="address-phone" type="tel" placeholder="{{ auth()->user()->phone ?: '0900 000 000' }}">
                    </div>
                    <div class="field field--full">
                        <label for="address-line">Địa chỉ</label>
                        <input id="address-line" type="text" placeholder="Số nhà, đường, phường/xã, quận/huyện">
                    </div>
                </div>
                <button class="primary-action" type="submit">Lưu địa chỉ</button>
            </form>
        </div>
    </section>
@endsection
