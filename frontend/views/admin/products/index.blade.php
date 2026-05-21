@extends('admin.layouts.app')

@section('title', 'Sản phẩm')
@section('page_title', 'Quản lý sản phẩm')

@section('content')
    <section class="admin-panel">
        <div class="admin-toolbar">
            <h2>Danh sách sản phẩm</h2>
            <form action="{{ route('admin.products.index') }}" method="get">
                <input name="q" value="{{ $filters['q'] }}" type="search" placeholder="Tìm tên, mã, thương hiệu...">
                <select name="status">
                    <option value="">Mọi trạng thái</option>
                    <option value="active" @selected($filters['status'] === 'active')>Đang bán</option>
                    <option value="inactive" @selected($filters['status'] === 'inactive')>Ẩn</option>
                    <option value="out_of_stock" @selected($filters['status'] === 'out_of_stock')>Hết hàng</option>
                </select>
                <button class="admin-link-button" type="submit"><i class="fas fa-search"></i> Lọc</button>
                <a class="admin-button" href="{{ route('admin.products.create') }}"><i class="fas fa-plus"></i> Thêm</a>
            </form>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Thương hiệu</th>
                        <th>Giá bán</th>
                        <th>Sale</th>
                        <th>Tồn</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td><img class="admin-thumb" src="{{ asset($product->thumbnail ?: 'template/images/loading.gif') }}" alt="{{ $product->name }}"></td>
                            <td>
                                <strong>{{ $product->name }}</strong><br>
                                <span class="admin-muted">{{ $product->sku }}</span>
                            </td>
                            <td>{{ $product->category_name }}</td>
                            <td>{{ $product->brand_name }}</td>
                            <td>{{ number_format((float) $product->price, 0, ',', '.') }}đ</td>
                            <td>{{ $product->sale_price ? number_format((float) $product->sale_price, 0, ',', '.').'đ' : '-' }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>
                                <span class="admin-badge {{ $product->status !== 'active' ? 'admin-badge--off' : '' }}">{{ $product->status }}</span>
                            </td>
                            <td>
                                <div class="admin-row-actions">
                                    <a class="admin-link-button" href="{{ route('admin.products.edit', $product->id) }}">Sửa</a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="post" onsubmit="return confirm('Xóa sản phẩm này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-danger-button" type="submit">Xóa</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9">Không có sản phẩm phù hợp.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
