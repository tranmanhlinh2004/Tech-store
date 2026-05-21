@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard quản trị')

@section('content')
    <section class="admin-stats">
        <div class="admin-stat admin-stat--blue">
            <span><i class="fas fa-box"></i> Sản phẩm</span>
            <strong>{{ $stats['products'] }}</strong>
        </div>
        <div class="admin-stat admin-stat--green">
            <span><i class="fas fa-layer-group"></i> Danh mục</span>
            <strong>{{ $stats['categories'] }}</strong>
        </div>
        <div class="admin-stat admin-stat--purple">
            <span><i class="fas fa-copyright"></i> Thương hiệu</span>
            <strong>{{ $stats['brands'] }}</strong>
        </div>
        <div class="admin-stat admin-stat--amber">
            <span><i class="fas fa-images"></i> Banner</span>
            <strong>{{ $stats['banners'] }}</strong>
        </div>
        <div class="admin-stat admin-stat--cyan">
            <span><i class="fas fa-star"></i> Sản phẩm nổi bật</span>
            <strong>{{ $stats['featured'] }}</strong>
        </div>
        <div class="admin-stat admin-stat--red">
            <span><i class="fas fa-exclamation-triangle"></i> Sắp hết hàng</span>
            <strong>{{ $stats['lowStock'] }}</strong>
        </div>
    </section>

    <section class="admin-panel">
        <div class="admin-panel__head">
            <h2>Sản phẩm cập nhật gần đây</h2>
            <a class="admin-button" href="{{ route('admin.products.create') }}"><i class="fas fa-plus"></i> Thêm sản phẩm</a>
        </div>

        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Thương hiệu</th>
                        <th>Giá</th>
                        <th>Tồn kho</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestProducts as $product)
                        <tr>
                            <td><img class="admin-thumb" src="{{ asset($product->thumbnail ?: 'template/images/loading.gif') }}" alt="{{ $product->name }}"></td>
                            <td><a href="{{ route('admin.products.edit', $product->id) }}">{{ $product->name }}</a></td>
                            <td>{{ $product->category_name }}</td>
                            <td>{{ $product->brand_name }}</td>
                            <td>{{ number_format((float) ($product->sale_price ?: $product->price), 0, ',', '.') }}đ</td>
                            <td>{{ $product->quantity }}</td>
                            <td><span class="admin-badge {{ $product->status !== 'active' ? 'admin-badge--off' : '' }}">{{ $product->status }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="7">Chưa có sản phẩm.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
