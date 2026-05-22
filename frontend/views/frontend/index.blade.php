@extends('frontend.layouts.tech')

@section('title', 'Đồ Công Nghệ | Laptop, điện thoại và phụ kiện chính hãng')
@section('meta_description', 'Đồ Công Nghệ - cửa hàng laptop, điện thoại, phụ kiện và thiết bị thông minh chính hãng.')

@section('content')
    @php
        $heroProduct = $featuredProducts->first();
    @endphp

    <section class="hero">
        <div class="site-container hero__content">
            <p class="eyebrow">Tech sale tháng này</p>
            <h1>Thiết bị công nghệ đáng mua cho học tập, làm việc và gaming.</h1>
            <p class="hero__lead">Chọn nhanh laptop, smartphone, màn hình và phụ kiện từ các thương hiệu quen thuộc. Giá rõ ràng, bảo hành minh bạch, hỗ trợ trả góp.</p>

            <div class="hero__actions">
                <a class="primary-button" href="{{ route('frontend.shop') }}">
                    <i class="fas fa-bolt"></i>
                    Mua ngay
                </a>
                <a class="secondary-button" href="{{ $heroProduct ? route('frontend.product', $heroProduct->slug) : route('frontend.shop') }}">
                    Xem sản phẩm nổi bật
                </a>
            </div>

            <div class="hero__metrics" aria-label="Số liệu nổi bật">
                <div>
                    <strong>{{ $stats['products'] ?? 0 }}+</strong>
                    <span>Mẫu sản phẩm</span>
                </div>
                <div>
                    <strong>{{ $stats['brands'] ?? 0 }}</strong>
                    <span>Thương hiệu</span>
                </div>
                <div>
                    <strong>0%</strong>
                    <span>Trả góp linh hoạt</span>
                </div>
            </div>
        </div>
    </section>

    <section class="category-band" aria-labelledby="category-title">
        <div class="site-container">
            <div class="section-heading">
                <span>Danh mục</span>
                <h2 id="category-title">Mua theo nhu cầu</h2>
                <a href="{{ route('frontend.shop') }}">Xem tất cả <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="category-grid">
                @forelse($categoryTiles as $category)
                    <a class="category-tile" href="{{ route('frontend.shop', ['category' => $category->slug]) }}">
                        <img src="{{ asset($category->image ?: 'template/images/collection/coll-1.jpg') }}" alt="{{ $category->name }}">
                        <span class="category-tile__icon"><i class="{{ $category->icon }}"></i></span>
                        <strong>{{ $category->name }}</strong>
                        <small>{{ $category->subtitle }}</small>
                    </a>
                @empty
                    <div class="panel empty-state">
                        <strong>Chưa có danh mục</strong>
                        <span>Danh mục sản phẩm sẽ được cập nhật sớm.</span>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="deal-section" aria-labelledby="deal-title">
        <div class="site-container">
            <div class="section-heading">
                <span>Ưu đãi nhanh</span>
                <h2 id="deal-title">Sản phẩm đang được giảm giá</h2>
                <a href="{{ route('frontend.shop', ['sort' => 'price_desc']) }}">Săn deal <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="deal-grid">
                @forelse($dealProducts as $index => $product)
                    <a class="deal-tile {{ $index === 0 ? 'deal-tile--dark' : ($index === 2 ? 'deal-tile--green' : '') }}" href="{{ route('frontend.product', $product->slug) }}">
                        <div>
                            <span>{{ $product->discount_label }}</span>
                            <h3>{{ $product->name }}</h3>
                            <p>{{ $product->teaser }} Giá chỉ từ {{ $product->display_price }}.</p>
                        </div>
                        <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}">
                    </a>
                @empty
                    <div class="panel empty-state">
                        <strong>Chưa có ưu đãi</strong>
                        <span>Các chương trình giảm giá sẽ được cập nhật sớm.</span>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="product-section" aria-labelledby="featured-title">
        <div class="site-container">
            <div class="section-heading">
                <span>Nổi bật</span>
                <h2 id="featured-title">Sản phẩm nên xem hôm nay</h2>
                <a href="{{ route('frontend.shop') }}">Tới cửa hàng <i class="fas fa-arrow-right"></i></a>
            </div>

            <div class="product-grid">
                @forelse($featuredProducts as $product)
                    @include('frontend.partials.product-card', ['product' => $product])
                @empty
                    <div class="panel empty-state">
                        <strong>Chưa có sản phẩm</strong>
                        <span>Danh sách sản phẩm đang được cập nhật.</span>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="service-section" aria-label="Cam kết dịch vụ">
        <div class="site-container service-grid">
            <div class="service-item">
                <i class="fas fa-box-open"></i>
                <strong>Đổi trả 7 ngày</strong>
                <span>Kiểm tra sản phẩm thoải mái, hỗ trợ đổi mới khi lỗi phần cứng.</span>
            </div>
            <div class="service-item">
                <i class="fas fa-tools"></i>
                <strong>Kỹ thuật hỗ trợ</strong>
                <span>Cài đặt phần mềm, chuyển dữ liệu, tư vấn cấu hình theo nhu cầu.</span>
            </div>
            <div class="service-item">
                <i class="fas fa-credit-card"></i>
                <strong>Thanh toán linh hoạt</strong>
                <span>Chuyển khoản, thẻ, ví điện tử và trả góp qua đối tác tài chính.</span>
            </div>
        </div>
    </section>

    <section class="brand-section" aria-labelledby="brand-title">
        <div class="site-container">
            <div class="section-heading">
                <span>Thương hiệu</span>
                <h2 id="brand-title">Đối tác quen thuộc</h2>
            </div>
            <div class="brand-list">
                @forelse($brandNames as $brandName)
                    <span>{{ $brandName }}</span>
                @empty
                    <span>Apple</span>
                    <span>Samsung</span>
                    <span>Dell</span>
                    <span>Asus</span>
                    <span>Logitech</span>
                    <span>Kingston</span>
                @endforelse
            </div>
        </div>
    </section>

    <section class="newsletter-section">
        <div class="site-container newsletter-panel">
            <div>
                <span>Không bỏ lỡ deal tốt</span>
                <h2>Nhận bảng giá và ưu đãi mới mỗi tuần.</h2>
            </div>
            <form action="{{ route('frontend.home') }}" method="get">
                <label class="sr-only" for="newsletter-email">Email nhận tin</label>
                <input id="newsletter-email" type="email" placeholder="Email của bạn">
                <button type="submit">Đăng ký</button>
            </form>
        </div>
    </section>
@endsection
