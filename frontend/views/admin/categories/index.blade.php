@extends('admin.layouts.app')

@section('title', 'Danh mục')
@section('page_title', 'Quản lý danh mục')

@section('content')
    <section class="admin-panel">
        <div class="admin-panel__head">
            <h2>Danh mục sản phẩm</h2>
            <a class="admin-button" href="{{ route('admin.categories.create') }}"><i class="fas fa-plus"></i> Thêm danh mục</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên</th>
                        <th>Slug</th>
                        <th>Danh mục cha</th>
                        <th>Sản phẩm</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td><img class="admin-thumb" src="{{ asset($category->image ?: 'template/images/loading.gif') }}" alt="{{ $category->name }}"></td>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->parent_name ?: '-' }}</td>
                            <td>{{ $category->product_count }}</td>
                            <td><span class="admin-badge {{ $category->status ? '' : 'admin-badge--off' }}">{{ $category->status ? 'Hiện' : 'Ẩn' }}</span></td>
                            <td>
                                <div class="admin-row-actions">
                                    <a class="admin-link-button" href="{{ route('admin.categories.edit', $category->id) }}">Sửa</a>
                                    <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post" onsubmit="return confirm('Xóa danh mục này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-danger-button" type="submit">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">Chưa có danh mục.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
