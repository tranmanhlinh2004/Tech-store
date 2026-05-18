@extends('frontend.layouts.tech')

@section('title', 'Hủy đơn hàng | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <h1>Yêu cầu hủy đơn</h1>
            <p>Gửi yêu cầu hủy khi đơn chưa bàn giao cho đơn vị vận chuyển.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container account-layout">
            @include('frontend.partials.account-nav', ['active' => 'cancellation'])

            <form class="account-panel stack" action="{{ url('/dash-my-order.html') }}" method="get">
                <h2 class="panel-title">Thông tin hủy đơn</h2>
                <div class="field">
                    <label for="cancel-order">Mã đơn</label>
                    <select id="cancel-order">
                        <option>#TS20260518 - ROG Strix G16</option>
                        <option>#TS20260517 - AirPods Pro 2</option>
                    </select>
                </div>
                <div class="field">
                    <label for="cancel-reason">Lý do</label>
                    <textarea id="cancel-reason" placeholder="Mô tả lý do hủy đơn"></textarea>
                </div>
                <button class="danger-action" type="submit">Gửi yêu cầu hủy</button>
            </form>
        </div>
    </section>
@endsection
