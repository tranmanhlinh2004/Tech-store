@extends('admin.layouts.app')

@php
    $isEdit = (bool) $coupon;
    $action = $isEdit ? route('admin.coupons.update', $coupon->id) : route('admin.coupons.store');
@endphp

@section('title', $isEdit ? 'Sửa mã giảm giá' : 'Thêm mã giảm giá')
@section('page_title', $isEdit ? 'Sửa mã giảm giá' : 'Thêm mã giảm giá')

@section('content')
    <form class="admin-panel" action="{{ $action }}" method="post">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="admin-form-grid">
            <div class="admin-field">
                <label for="code">Mã giảm giá</label>
                <input id="code" name="code" value="{{ old('code', $coupon->code ?? '') }}" required>
            </div>

            <div class="admin-field">
                <label for="name">Tên chương trình</label>
                <input id="name" name="name" value="{{ old('name', $coupon->name ?? '') }}" required>
            </div>

            <div class="admin-field">
                <label for="discount_type">Loại giảm</label>
                <select id="discount_type" name="discount_type">
                    <option value="percentage" @selected(old('discount_type', $coupon->discount_type ?? 'percentage') === 'percentage')>Phần trăm</option>
                    <option value="fixed" @selected(old('discount_type', $coupon->discount_type ?? '') === 'fixed')>Số tiền cố định</option>
                </select>
            </div>

            <div class="admin-field">
                <label for="discount_value">Giá trị giảm</label>
                <input id="discount_value" name="discount_value" type="number" min="0" step="0.01" value="{{ old('discount_value', $coupon->discount_value ?? 0) }}" required>
            </div>

            <div class="admin-field">
                <label for="min_order_value">Giá trị đơn tối thiểu</label>
                <input id="min_order_value" name="min_order_value" type="number" min="0" step="1000" value="{{ old('min_order_value', $coupon->min_order_value ?? 0) }}">
            </div>

            <div class="admin-field">
                <label for="max_discount_amount">Giảm tối đa</label>
                <input id="max_discount_amount" name="max_discount_amount" type="number" min="0" step="1000" value="{{ old('max_discount_amount', $coupon->max_discount_amount ?? '') }}">
            </div>

            <div class="admin-field">
                <label for="quantity">Số lượng</label>
                <input id="quantity" name="quantity" type="number" min="0" value="{{ old('quantity', $coupon->quantity ?? 0) }}" required>
            </div>

            <div class="admin-field">
                <label for="used_count">Đã dùng</label>
                <input id="used_count" name="used_count" type="number" min="0" value="{{ old('used_count', $coupon->used_count ?? 0) }}">
            </div>

            <div class="admin-field">
                <label for="start_date">Ngày bắt đầu</label>
                <input id="start_date" name="start_date" type="date" value="{{ old('start_date', $coupon->start_date ?? now()->toDateString()) }}" required>
            </div>

            <div class="admin-field">
                <label for="end_date">Ngày kết thúc</label>
                <input id="end_date" name="end_date" type="date" value="{{ old('end_date', $coupon->end_date ?? now()->addMonth()->toDateString()) }}" required>
            </div>

            <div class="admin-field admin-field--full">
                <div class="admin-checks">
                    <label><input type="checkbox" name="status" value="1" @checked(old('status', $coupon->status ?? true))> Đang bật</label>
                </div>
            </div>
        </div>

        <div class="admin-form-actions">
            <button class="admin-button" type="submit"><i class="fas fa-save"></i> Lưu</button>
            <a class="admin-link-button" href="{{ route('admin.coupons.index') }}">Quay lại</a>
        </div>
    </form>
@endsection
