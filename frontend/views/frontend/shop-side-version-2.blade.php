@extends('frontend.layouts.tech')

@section('title', 'Sản phẩm | Đồ Công Nghệ')
@section('meta_description', 'Danh sách laptop, điện thoại, phụ kiện, màn hình và linh kiện PC tại Đồ Công Nghệ.')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend.home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Sản phẩm</span>
            </div>
            <h1>Danh mục sản phẩm công nghệ</h1>
            <p>Lọc nhanh theo nhu cầu, thương hiệu và ngân sách để chọn đúng thiết bị.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container layout-grid">
            <form class="filter-panel" action="{{ route('frontend.shop') }}" method="get">
                <h2 class="panel-title">Bộ lọc</h2>

                <div class="filter-group">
                    <strong>Tìm kiếm</strong>
                    <div class="field">
                        <label class="sr-only" for="shop-search">Từ khóa</label>
                        <input id="shop-search" name="q" value="{{ $filters['q'] }}" type="search" placeholder="Tên, mã, thương hiệu...">
                    </div>
                </div>

                <div class="filter-group">
                    <strong>Danh mục</strong>
                    <div class="filter-list">
                        <label class="radio-line"><input type="radio" name="category" value="" @checked($filters['category'] === '')> Tất cả</label>
                        @foreach($categories as $category)
                            <label class="radio-line">
                                <input type="radio" name="category" value="{{ $category->slug }}" @checked($filters['category'] === $category->slug)>
                                {{ $category->name }}
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="filter-group">
                    <strong>Thương hiệu</strong>
                    <select class="select-control" name="brand" aria-label="Lọc theo thương hiệu">
                        <option value="">Tất cả thương hiệu</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->slug }}" @selected($filters['brand'] === $brand->slug)>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <strong>Khoảng giá</strong>
                    <div class="filter-list">
                        <label class="radio-line"><input type="radio" name="price" value="" @checked($filters['price'] === '')> Tất cả</label>
                        <label class="radio-line"><input type="radio" name="price" value="under_5" @checked($filters['price'] === 'under_5')> Dưới 5 triệu</label>
                        <label class="radio-line"><input type="radio" name="price" value="5_15" @checked($filters['price'] === '5_15')> 5 - 15 triệu</label>
                        <label class="radio-line"><input type="radio" name="price" value="over_15" @checked($filters['price'] === 'over_15')> Trên 15 triệu</label>
                    </div>
                </div>

                <div class="filter-group">
                    <strong>Sắp xếp</strong>
                    <select class="select-control" name="sort" aria-label="Sắp xếp sản phẩm">
                        <option value="featured" @selected($filters['sort'] === 'featured')>Nổi bật</option>
                        <option value="price_asc" @selected($filters['sort'] === 'price_asc')>Giá thấp đến cao</option>
                        <option value="price_desc" @selected($filters['sort'] === 'price_desc')>Giá cao đến thấp</option>
                        <option value="newest" @selected($filters['sort'] === 'newest')>Mới nhất</option>
                        <option value="best_selling" @selected($filters['sort'] === 'best_selling')>Bán chạy</option>
                    </select>
                </div>

                <div class="hero__actions u-m-t-20">
                    <button class="primary-action" type="submit"><i class="fas fa-filter"></i> Áp dụng</button>
                    <a class="secondary-action" href="{{ route('frontend.shop') }}">Xóa lọc</a>
                </div>
            </form>

            <div>
                <div class="shop-toolbar">
                    <span>Hiển thị {{ $products->count() }} sản phẩm</span>
                </div>

                <div class="product-grid">
                    @forelse($products as $product)
                        @include('frontend.partials.product-card', ['product' => $product])
                    @empty
                        <div class="panel empty-state">
                            <strong>Không tìm thấy sản phẩm</strong>
                            <span>Thử đổi từ khóa, danh mục hoặc khoảng giá.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
