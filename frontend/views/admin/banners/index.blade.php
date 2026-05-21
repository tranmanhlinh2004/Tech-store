@extends('admin.layouts.app')

@section('title', 'Banner')
@section('page_title', 'Quản lý banner')

@section('content')
    <section class="admin-panel">
        <div class="admin-panel__head">
            <h2>Banner và khối quảng bá</h2>
            <a class="admin-button" href="{{ route('admin.banners.create') }}"><i class="fas fa-plus"></i> Thêm banner</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Tiêu đề</th>
                        <th>Vị trí</th>
                        <th>Link</th>
                        <th>Thứ tự</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                        <tr>
                            <td><img class="admin-thumb" src="{{ asset($banner->image ?: 'template/images/loading.gif') }}" alt="{{ $banner->title }}"></td>
                            <td><strong>{{ $banner->title }}</strong></td>
                            <td>{{ $banner->position ?: '-' }}</td>
                            <td>{{ $banner->link ?: '-' }}</td>
                            <td>{{ $banner->sort_order }}</td>
                            <td><span class="admin-badge {{ $banner->status ? '' : 'admin-badge--off' }}">{{ $banner->status ? 'Hiện' : 'Ẩn' }}</span></td>
                            <td>
                                <div class="admin-row-actions">
                                    <a class="admin-link-button" href="{{ route('admin.banners.edit', $banner->id) }}">Sửa</a>
                                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="post" onsubmit="return confirm('Xóa banner này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-danger-button" type="submit">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">Chưa có banner.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
