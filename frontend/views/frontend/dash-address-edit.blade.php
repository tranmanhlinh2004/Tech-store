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

            <form class="account-panel stack" action="{{ url('/dash-address-book.html') }}" method="get">
                <h2 class="panel-title">Địa chỉ mặc định</h2>
                <div class="form-grid">
                    <div class="field">
                        <label for="edit-address-name">Người nhận</label>
                        <input id="edit-address-name" type="text" value="Nguyễn Minh Anh">
                    </div>
                    <div class="field">
                        <label for="edit-address-phone">Số điện thoại</label>
                        <input id="edit-address-phone" type="tel" value="0901000004">
                    </div>
                    <div class="field field--full">
                        <label for="edit-address-line">Địa chỉ</label>
                        <input id="edit-address-line" type="text" value="123 Nguyễn Huệ, Quận 1, TP. Hồ Chí Minh">
                    </div>
                </div>
                <button class="primary-action" type="submit">Cập nhật</button>
            </form>
        </div>
    </section>
@endsection
