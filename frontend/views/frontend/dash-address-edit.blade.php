@extends('frontend.layouts.tech')

@section('title', 'Sửa địa chỉ | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <h1>Sửa địa chỉ giao hàng</h1>
            <p>Cập nhật địa chỉ mặc định của bạn.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container account-layout">
            @include('frontend.partials.account-nav', ['active' => 'address'])

            <form class="account-panel stack" action="{{ route('frontend.account.addresses') }}" method="get">
                @if($address)
                    <h2 class="panel-title">Địa chỉ mặc định</h2>
                    <div class="form-grid">
                        <div class="field">
                            <label for="edit-address-name">Người nhận</label>
                            <input id="edit-address-name" type="text" value="{{ $address->full_name }}">
                        </div>
                        <div class="field">
                            <label for="edit-address-phone">Số điện thoại</label>
                            <input id="edit-address-phone" type="tel" value="{{ $address->phone }}">
                        </div>
                        <div class="field field--full">
                            <label for="edit-address-line">Địa chỉ</label>
                            <input id="edit-address-line" type="text" value="{{ $address->full_address }}">
                        </div>
                    </div>
                    <button class="primary-action" type="submit">Cập nhật</button>
                @else
                    <div class="empty-state empty-state--small">
                        <strong>Chưa có địa chỉ để sửa</strong>
                        <span>Thêm địa chỉ giao hàng trước khi chỉnh sửa.</span>
                        <a class="primary-action" href="{{ url('/dash-address-add.html') }}">Thêm địa chỉ</a>
                    </div>
                @endif
            </form>
        </div>
    </section>
@endsection
