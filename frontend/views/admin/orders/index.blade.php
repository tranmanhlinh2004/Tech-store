@extends('admin.layouts.app')

@php
    $money = fn ($value) => number_format((float) $value, 0, ',', '.').'đ';
@endphp

@section('title', 'Đơn hàng')
@section('page_title', 'Quản lý đơn hàng')

@section('content')
    <section class="admin-panel">
        <div class="admin-toolbar">
            <h2>Danh sách đơn hàng</h2>
            <form action="{{ route('admin.orders.index') }}" method="get">
                <input name="q" value="{{ $filters['q'] }}" type="search" placeholder="Mã đơn, khách hàng, email, SĐT">
                <select name="status">
                    <option value="">Mọi trạng thái đơn</option>
                    @foreach($orderStatuses as $value => $label)
                        <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <select name="payment_status">
                    <option value="">Mọi thanh toán</option>
                    @foreach($paymentStatuses as $value => $label)
                        <option value="{{ $value }}" @selected($filters['payment_status'] === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <button class="admin-link-button" type="submit"><i class="fas fa-search"></i> Lọc</button>
            </form>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Mã đơn</th>
                        <th>Khách hàng</th>
                        <th>Tổng tiền</th>
                        <th>Ngày tạo</th>
                        <th>Cập nhật trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->order_code }}</strong><br>
                                <span class="admin-muted">{{ $order->customer_phone }}</span>
                            </td>
                            <td>
                                <strong>{{ $order->customer_name }}</strong><br>
                                <span class="admin-muted">{{ $order->customer_email }}</span>
                            </td>
                            <td>
                                <strong>{{ $money($order->total_amount) }}</strong><br>
                                <span class="admin-muted">Ship: {{ $money($order->shipping_fee ?? 0) }}</span>
                            </td>
                            <td>{{ $order->created_at }}</td>
                            <td>
                                <form class="admin-row-actions" action="{{ route('admin.orders.update', $order->id) }}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="filter_q" value="{{ $filters['q'] }}">
                                    <input type="hidden" name="filter_status" value="{{ $filters['status'] }}">
                                    <input type="hidden" name="filter_payment_status" value="{{ $filters['payment_status'] }}">
                                    <select name="order_status">
                                        @foreach($orderStatuses as $value => $label)
                                            <option value="{{ $value }}" @selected($order->order_status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <select name="payment_status">
                                        @foreach($paymentStatuses as $value => $label)
                                            <option value="{{ $value }}" @selected($order->payment_status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    <input name="tracking_number" value="{{ $order->tracking_number ?? '' }}" placeholder="Mã vận đơn">
                                    <button class="admin-button" type="submit">Lưu</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Không có đơn hàng phù hợp.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
