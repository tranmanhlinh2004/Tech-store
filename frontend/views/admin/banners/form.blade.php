@extends('admin.layouts.app')

@php
    $isEdit = (bool) $banner;
    $action = $isEdit ? route('admin.banners.update', $banner->id) : route('admin.banners.store');
@endphp

@section('title', $isEdit ? 'Sửa banner' : 'Thêm banner')
@section('page_title', $isEdit ? 'Sửa banner' : 'Thêm banner')

@section('content')
    <form class="admin-panel" action="{{ $action }}" method="post">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="admin-form-grid">
            <div class="admin-field">
                <label for="title">Tiêu đề</label>
                <input id="title" name="title" value="{{ old('title', $banner->title ?? '') }}" required>
            </div>

            <div class="admin-field">
                <label for="position">Vị trí</label>
                <input id="position" name="position" value="{{ old('position', $banner->position ?? 'home_deal') }}" placeholder="home_slider, home_deal, footer...">
            </div>

            <div class="admin-field admin-field--full">
                <label for="image">Ảnh banner</label>
                <input id="image" name="image" value="{{ old('image', $banner->image ?? '') }}" placeholder="template/images/..." required>
            </div>

            <div class="admin-field">
                <label for="link">Đường dẫn</label>
                <input id="link" name="link" value="{{ old('link', $banner->link ?? '') }}" placeholder="/shop?category=laptop">
            </div>

            <div class="admin-field">
                <label for="sort_order">Thứ tự</label>
                <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $banner->sort_order ?? 0) }}">
            </div>

            <div class="admin-field admin-field--full">
                <div class="admin-checks">
                    <label><input type="checkbox" name="status" value="1" @checked(old('status', $banner->status ?? true))> Hiển thị</label>
                </div>
            </div>
        </div>

        <div class="admin-form-actions">
            <button class="admin-button" type="submit"><i class="fas fa-save"></i> Lưu</button>
            <a class="admin-link-button" href="{{ route('admin.banners.index') }}">Quay lại</a>
        </div>
    </form>
@endsection
