@extends('admin.layouts.app')

@section('title', 'Đánh giá sản phẩm')
@section('page_title', 'Quản lý đánh giá sản phẩm')

@section('content')
    <section class="admin-panel">
        <div class="admin-toolbar">
            <h2>Danh sách đánh giá</h2>
            <form action="{{ route('admin.reviews.index') }}" method="get">
                <select name="status">
                    <option value="">Mọi trạng thái</option>
                    <option value="1" @selected($filters['status'] === '1')>Đang hiển thị</option>
                    <option value="0" @selected($filters['status'] === '0')>Đang ẩn</option>
                </select>
                <button class="admin-link-button" type="submit"><i class="fas fa-search"></i> Lọc</button>
            </form>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Khách hàng</th>
                        <th>Sản phẩm</th>
                        <th>Đánh giá</th>
                        <th>Nội dung</th>
                        <th>Ngày tạo</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>
                                <strong>{{ $review->reviewer_name ?: ($review->user_name ?: 'Khách hàng') }}</strong><br>
                                <span class="admin-muted">{{ $review->reviewer_email ?: '-' }}</span>
                            </td>
                            <td>{{ $review->product_name ?: '-' }}</td>
                            <td>
                                <strong>{{ $review->rating }}/5</strong><br>
                                <span class="admin-muted">{{ $review->title ?: '-' }}</span>
                            </td>
                            <td>{{ $review->comment ?: '-' }}</td>
                            <td>{{ $review->created_at }}</td>
                            <td><span class="admin-badge {{ $review->status ? '' : 'admin-badge--off' }}">{{ $review->status ? 'Hiển thị' : 'Ẩn' }}</span></td>
                            <td>
                                <div class="admin-row-actions">
                                    <form action="{{ route('admin.reviews.update', $review->id) }}" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="{{ $review->status ? '0' : '1' }}">
                                        <button class="admin-link-button" type="submit">{{ $review->status ? 'Ẩn' : 'Hiện' }}</button>
                                    </form>
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="post" onsubmit="return confirm('Xóa đánh giá này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-danger-button" type="submit">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">Không có đánh giá phù hợp.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
