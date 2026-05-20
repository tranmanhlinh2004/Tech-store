@extends('frontend.layouts.tech')

@section('title', 'Sản phẩm | Đồ Công Nghệ')
@section('meta_description', 'Danh sách laptop, điện thoại, phụ kiện, màn hình và linh kiện PC tại Đồ Công Nghệ.')

@php
    $formatPrice = fn ($value) => number_format((float) $value, 0, ',', '.').'đ';
    $fallbackImage = 'template/images/product/electronic/product1.jpg';
@endphp

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend.home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Sản phẩm</span>
            </div>
            <h1>Danh mục sản phẩm công nghệ</h1>
            <p>Lọc nhanh theo danh mục, tìm kiếm theo tên, SKU hoặc thương hiệu để chọn đúng thiết bị.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container layout-grid">
            <aside class="filter-panel">
                <h2 class="panel-title">Danh mục sản phẩm</h2>

                <div class="filter-group">
                    <div class="filter-list">
                        <a class="filter-link {{ $selectedCategoryId === null ? 'active' : '' }}" href="{{ route('frontend.shop', request()->except(['category', 'page'])) }}">
                            <span>Tất cả sản phẩm</span>
                            <strong>{{ $totalProductsCount }}</strong>
                        </a>

                        @foreach ($categories as $category)
                            <a class="filter-link {{ $selectedCategoryId === $category->id ? 'active' : '' }}" href="{{ route('frontend.shop', array_merge(request()->except(['page']), ['category' => $category->id])) }}">
                                <span>{{ $category->name }}</span>
                                <strong>{{ $category->products_count }}</strong>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="filter-group">
                    <strong>Thương hiệu đang có</strong>
                    <div class="filter-list">
                        @foreach ($brands->take(10) as $brand)
                            <span class="filter-chip">{{ $brand->name }}</span>
                        @endforeach
                    </div>
                </div>
            </aside>

            <div>
                <form class="shop-toolbar" action="{{ route('frontend.shop') }}" method="get">
                    @if ($selectedCategoryId !== null)
                        <input type="hidden" name="category" value="{{ $selectedCategoryId }}">
                    @endif

                    <label class="sr-only" for="shop-search">Tìm sản phẩm</label>
                    <input class="select-control shop-search-input" id="shop-search" name="q" type="search" value="{{ $searchKeyword }}" placeholder="Tìm theo tên sản phẩm, SKU, thương hiệu...">

                    <label class="sr-only" for="shop-sort">Sắp xếp</label>
                    <select class="select-control" id="shop-sort" name="sort">
                        <option value="featured" @selected($sort === 'featured')>Sắp xếp: Nổi bật</option>
                        <option value="newest" @selected($sort === 'newest')>Mới nhất</option>
                        <option value="price_asc" @selected($sort === 'price_asc')>Giá thấp đến cao</option>
                        <option value="price_desc" @selected($sort === 'price_desc')>Giá cao đến thấp</option>
                    </select>

                    <button class="primary-action" type="submit">Áp dụng</button>
                </form>

                <div class="shop-result-count">
                    Hiển thị {{ $products->count() }} / {{ $products->total() }} sản phẩm
                    @if ($searchKeyword !== '')
                        cho từ khóa <strong>"{{ $searchKeyword }}"</strong>
                    @endif
                </div>

                @if ($products->isEmpty())
                    <div class="empty-state empty-state--small">
                        <i class="fas fa-search"></i>
                        <h2>Không tìm thấy sản phẩm</h2>
                        <p>Hãy thử bỏ lọc danh mục hoặc dùng từ khóa ngắn hơn.</p>
                        <a class="primary-action" href="{{ route('frontend.shop') }}">Xem tất cả sản phẩm</a>
                    </div>
                @else
                    <div class="product-grid">
                        @foreach ($products as $product)
                            @php
                                $displayPrice = $product->sale_price ?: $product->price;
                                $hasDiscount = $product->sale_price !== null && (float) $product->sale_price < (float) $product->price;
                                $discountPercent = $hasDiscount ? round((1 - ((float) $product->sale_price / (float) $product->price)) * 100) : null;
                            @endphp

                            <article class="product-card">
                                <a class="product-card__media" href="{{ route('frontend.product', $product->id) }}">
                                    <img src="{{ asset($product->thumbnail ?: $fallbackImage) }}" alt="{{ $product->name }}">
                                    @if ($hasDiscount)
                                        <span>-{{ $discountPercent }}%</span>
                                    @elseif ($product->is_featured)
                                        <span>Hot</span>
                                    @else
                                        <span>{{ $product->quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}</span>
                                    @endif
                                </a>
                                <div class="product-card__body">
                                    <small>{{ $product->brand_name ?? 'Tech Shop' }}</small>
                                    <h3><a href="{{ route('frontend.product', $product->id) }}">{{ $product->name }}</a></h3>
                                    <p>{{ $product->short_description ?: $product->category_name }}</p>
                                    <div class="product-card__price">
                                        <strong>{{ $formatPrice($displayPrice) }}</strong>
                                        @if ($hasDiscount)
                                            <del>{{ $formatPrice($product->price) }}</del>
                                        @endif
                                    </div>
                                    <div class="product-card__actions">
                                        <a href="{{ route('frontend.cart') }}"><i class="fas fa-shopping-cart"></i> Thêm</a>
                                        <a href="{{ route('frontend.wishlist') }}" aria-label="Yêu thích {{ $product->name }}"><i class="far fa-heart"></i></a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <div class="pagination-row">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
