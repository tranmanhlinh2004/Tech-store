@extends('admin.layouts.app')

@php
    $money = fn ($value) => number_format((float) $value, 0, ',', '.').'đ';
@endphp

@section('title', 'Mã giảm giá')
@section('page_title', 'Quản lý mã giảm giá')

@section('content')
    <section class="admin-panel">
        <div class="admin-panel__head">
            <h2>Danh sách mã giảm giá</h2>
            <a class="admin-button" href="{{ route('admin.coupons.create') }}"><i class="fas fa-plus"></i> Thêm mã</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Mã</th>
                        <th>Tên</th>
                        <th>Giảm</th>
                        <th>Điều kiện</th>
                        <th>Số lượng</th>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td><strong>{{ $coupon->code }}</strong></td>
                            <td>{{ $coupon->name }}</td>
                            <td>
                                {{ $coupon->discount_type === 'percentage' ? number_format((float) $coupon->discount_value, 0, ',', '.').'%' : $money($coupon->discount_value) }}
                            </td>
                            <td>
                                Tối thiểu {{ $money($coupon->min_order_value) }}<br>
                                <span class="admin-muted">Tối đa: {{ $coupon->max_discount_amount ? $money($coupon->max_discount_amount) : '-' }}</span>
                            </td>
                            <td>{{ $coupon->used_count }}/{{ $coupon->quantity }}</td>
                            <td>{{ $coupon->start_date }} - {{ $coupon->end_date }}</td>
                            <td><span class="admin-badge {{ $coupon->status ? '' : 'admin-badge--off' }}">{{ $coupon->status ? 'Đang bật' : 'Đã tắt' }}</span></td>
                            <td>
                                <div class="admin-row-actions">
                                    <a class="admin-link-button" href="{{ route('admin.coupons.edit', $coupon->id) }}">Sửa</a>
                                    <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="post" onsubmit="return confirm('Xóa mã giảm giá này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-danger-button" type="submit">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8">Chưa có mã giảm giá.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
