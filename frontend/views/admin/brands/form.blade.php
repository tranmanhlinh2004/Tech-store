@extends('admin.layouts.app')

@php
    $isEdit = (bool) $brand;
    $action = $isEdit ? route('admin.brands.update', $brand->id) : route('admin.brands.store');
@endphp

@section('title', $isEdit ? 'Sửa thương hiệu' : 'Thêm thương hiệu')
@section('page_title', $isEdit ? 'Sửa thương hiệu' : 'Thêm thương hiệu')

@section('content')
    <form class="admin-panel" action="{{ $action }}" method="post">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="admin-form-grid">
            <div class="admin-field">
                <label for="name">Tên thương hiệu</label>
                <input id="name" name="name" value="{{ old('name', $brand->name ?? '') }}" required>
            </div>

            <div class="admin-field">
                <label for="slug">Slug</label>
                <input id="slug" name="slug" value="{{ old('slug', $brand->slug ?? '') }}" placeholder="Tự tạo nếu để trống">
            </div>

            <div class="admin-field admin-field--full">
                <label for="logo">Logo</label>
                <input id="logo" name="logo" value="{{ old('logo', $brand->logo ?? '') }}" placeholder="template/images/brand/...">
            </div>

            <div class="admin-field admin-field--full">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description">{{ old('description', $brand->description ?? '') }}</textarea>
            </div>

            <div class="admin-field admin-field--full">
                <div class="admin-checks">
                    <label><input type="checkbox" name="status" value="1" @checked(old('status', $brand->status ?? true))> Hiển thị</label>
                </div>
            </div>
        </div>

        <div class="admin-form-actions">
            <button class="admin-button" type="submit"><i class="fas fa-save"></i> Lưu</button>
            <a class="admin-link-button" href="{{ route('admin.brands.index') }}">Quay lại</a>
        </div>
    </form>
@endsection
