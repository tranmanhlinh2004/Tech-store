@extends('admin.layouts.app')

@php
    $isEdit = (bool) $category;
    $action = $isEdit ? route('admin.categories.update', $category->id) : route('admin.categories.store');
@endphp

@section('title', $isEdit ? 'Sửa danh mục' : 'Thêm danh mục')
@section('page_title', $isEdit ? 'Sửa danh mục' : 'Thêm danh mục')

@section('content')
    <form class="admin-panel" action="{{ $action }}" method="post">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="admin-form-grid">
            <div class="admin-field">
                <label for="name">Tên danh mục</label>
                <input id="name" name="name" value="{{ old('name', $category->name ?? '') }}" required>
            </div>

            <div class="admin-field">
                <label for="slug">Slug</label>
                <input id="slug" name="slug" value="{{ old('slug', $category->slug ?? '') }}" placeholder="Tự tạo nếu để trống">
            </div>

            <div class="admin-field">
                <label for="parent_id">Danh mục cha</label>
                <select id="parent_id" name="parent_id">
                    <option value="">Không có</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" @selected((int) old('parent_id', $category->parent_id ?? 0) === $parent->id)>
                            {{ $parent->parent_id ? '— ' : '' }}{{ $parent->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="admin-field">
                <label for="image">Ảnh danh mục</label>
                <input id="image" name="image" value="{{ old('image', $category->image ?? '') }}" placeholder="template/images/...">
            </div>

            <div class="admin-field admin-field--full">
                <label for="description">Mô tả</label>
                <textarea id="description" name="description">{{ old('description', $category->description ?? '') }}</textarea>
            </div>

            <div class="admin-field admin-field--full">
                <div class="admin-checks">
                    <label><input type="checkbox" name="status" value="1" @checked(old('status', $category->status ?? true))> Hiển thị</label>
                </div>
            </div>
        </div>

        <div class="admin-form-actions">
            <button class="admin-button" type="submit"><i class="fas fa-save"></i> Lưu</button>
            <a class="admin-link-button" href="{{ route('admin.categories.index') }}">Quay lại</a>
        </div>
    </form>
@endsection
