@extends('admin.layouts.app')

@section('title', 'Thương hiệu')
@section('page_title', 'Quản lý thương hiệu')

@section('content')
    <section class="admin-panel">
        <div class="admin-panel__head">
            <h2>Thương hiệu</h2>
            <a class="admin-button" href="{{ route('admin.brands.create') }}"><i class="fas fa-plus"></i> Thêm thương hiệu</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Logo</th>
                        <th>Tên</th>
                        <th>Slug</th>
                        <th>Sản phẩm</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($brands as $brand)
                        <tr>
                            <td><img class="admin-thumb" src="{{ asset($brand->logo ?: 'template/images/loading.gif') }}" alt="{{ $brand->name }}"></td>
                            <td><strong>{{ $brand->name }}</strong></td>
                            <td>{{ $brand->slug }}</td>
                            <td>{{ $brand->product_count }}</td>
                            <td><span class="admin-badge {{ $brand->status ? '' : 'admin-badge--off' }}">{{ $brand->status ? 'Hiện' : 'Ẩn' }}</span></td>
                            <td>
                                <div class="admin-row-actions">
                                    <a class="admin-link-button" href="{{ route('admin.brands.edit', $brand->id) }}">Sửa</a>
                                    <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="post" onsubmit="return confirm('Xóa thương hiệu này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-danger-button" type="submit">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6">Chưa có thương hiệu.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
