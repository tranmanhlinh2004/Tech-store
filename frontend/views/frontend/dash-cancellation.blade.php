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
                @if($cancelableOrders->isNotEmpty())
                    <div class="field">
                        <label for="cancel-order">Mã đơn</label>
                        <select id="cancel-order" name="order">
                            @foreach($cancelableOrders as $order)
                                <option value="{{ $order->id }}">#{{ $order->order_code }} - {{ $order->item_summary }} - {{ ucfirst($order->status_label) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label for="cancel-reason">Lý do</label>
                        <textarea id="cancel-reason" name="reason" placeholder="Mô tả lý do hủy đơn"></textarea>
                    </div>
                    <button class="danger-action" type="submit">Gửi yêu cầu hủy</button>
                @else
                    <div class="empty-state empty-state--small">
                        <strong>Không có đơn có thể hủy</strong>
                        <span>Chỉ các đơn đang chờ xác nhận, đã xác nhận hoặc đang xử lý mới có thể gửi yêu cầu hủy.</span>
                        <a class="secondary-action" href="{{ route('frontend.account.orders') }}">Xem đơn hàng</a>
                    </div>
                @endif
            </form>
        </div>
    </section>
@endsection
