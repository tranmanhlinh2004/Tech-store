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
            <aside class="filter-panel">
                <h2 class="panel-title">Bộ lọc</h2>

                <div class="filter-group">
                    <strong>Danh mục</strong>
                    <div class="filter-list">
                        <label class="check-line"><input type="checkbox" checked> Laptop</label>
                        <label class="check-line"><input type="checkbox"> Smartphone</label>
                        <label class="check-line"><input type="checkbox"> Màn hình</label>
                        <label class="check-line"><input type="checkbox"> Phụ kiện</label>
                        <label class="check-line"><input type="checkbox"> Linh kiện PC</label>
                    </div>
                </div>

                <div class="filter-group">
                    <strong>Thương hiệu</strong>
                    <div class="filter-list">
                        <label class="check-line"><input type="checkbox"> Apple</label>
                        <label class="check-line"><input type="checkbox"> Samsung</label>
                        <label class="check-line"><input type="checkbox"> Asus</label>
                        <label class="check-line"><input type="checkbox"> Logitech</label>
                    </div>
                </div>

                <div class="filter-group">
                    <strong>Khoảng giá</strong>
                    <div class="filter-list">
                        <label class="radio-line"><input type="radio" name="price" checked> Tất cả</label>
                        <label class="radio-line"><input type="radio" name="price"> Dưới 5 triệu</label>
                        <label class="radio-line"><input type="radio" name="price"> 5 - 15 triệu</label>
                        <label class="radio-line"><input type="radio" name="price"> Trên 15 triệu</label>
                    </div>
                </div>
            </aside>

            <div>
                <div class="shop-toolbar">
                    <span>Hiển thị 8 sản phẩm nổi bật</span>
                    <select class="select-control" aria-label="Sắp xếp sản phẩm">
                        <option>Sắp xếp: Nổi bật</option>
                        <option>Giá thấp đến cao</option>
                        <option>Giá cao đến thấp</option>
                    </select>
                </div>

                <div class="product-grid">
                    <article class="product-card">
                        <a class="product-card__media" href="{{ route('frontend.product') }}">
                            <img src="{{ asset('template/images/product/iphone/iphone-15-pro-256gb.webp') }}" alt="iPhone 15 Pro 256GB">
                            <span>-5%</span>
                        </a>
                        <div class="product-card__body">
                            <small>Apple</small>
                            <h3><a href="{{ route('frontend.product') }}">iPhone 15 Pro 256GB</a></h3>
                            <p>A17 Pro, camera 48MP, khung titanium.</p>
                            <div class="product-card__price"><strong>27.490.000đ</strong><del>28.990.000đ</del></div>
                            <div class="product-card__actions">
                                <a href="{{ route('frontend.cart') }}"><i class="fas fa-shopping-cart"></i> Thêm</a>
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Yêu thích"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                    </article>

                    <article class="product-card">
                        <a class="product-card__media" href="{{ route('frontend.product') }}">
                            <img src="{{ asset('template/images/product/android-phone/samsung-galaxy-s24-ultra.jpg') }}" alt="Samsung Galaxy S24 Ultra">
                            <span>Hot</span>
                        </a>
                        <div class="product-card__body">
                            <small>Samsung</small>
                            <h3><a href="{{ route('frontend.product') }}">Galaxy S24 Ultra</a></h3>
                            <p>Màn lớn, S Pen, zoom xa và pin bền.</p>
                            <div class="product-card__price"><strong>26.490.000đ</strong><del>27.990.000đ</del></div>
                            <div class="product-card__actions">
                                <a href="{{ route('frontend.cart') }}"><i class="fas fa-shopping-cart"></i> Thêm</a>
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Yêu thích"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                    </article>

                    <article class="product-card">
                        <a class="product-card__media" href="{{ route('frontend.product') }}">
                            <img src="{{ asset('template/images/product/ultrabook/macbook-air-m3-13-inch.jpg') }}" alt="MacBook Air M3 13 inch">
                            <span>M3</span>
                        </a>
                        <div class="product-card__body">
                            <small>Apple</small>
                            <h3><a href="{{ route('frontend.product') }}">MacBook Air M3 13 inch</a></h3>
                            <p>Mỏng nhẹ, pin lâu, phù hợp đi học và đi làm.</p>
                            <div class="product-card__price"><strong>27.990.000đ</strong><del>28.990.000đ</del></div>
                            <div class="product-card__actions">
                                <a href="{{ route('frontend.cart') }}"><i class="fas fa-shopping-cart"></i> Thêm</a>
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Yêu thích"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                    </article>

                    <article class="product-card">
                        <a class="product-card__media" href="{{ route('frontend.product') }}">
                            <img src="{{ asset('template/images/product/gaming-laptop/asus-rog-strix-g16.jpg') }}" alt="Asus ROG Strix G16">
                            <span>RTX</span>
                        </a>
                        <div class="product-card__body">
                            <small>Asus</small>
                            <h3><a href="{{ route('frontend.product') }}">ROG Strix G16</a></h3>
                            <p>Core i7, RTX 4060, màn hình tần số quét cao.</p>
                            <div class="product-card__price"><strong>32.990.000đ</strong><del>34.990.000đ</del></div>
                            <div class="product-card__actions">
                                <a href="{{ route('frontend.cart') }}"><i class="fas fa-shopping-cart"></i> Thêm</a>
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Yêu thích"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                    </article>

                    <article class="product-card">
                        <a class="product-card__media" href="{{ route('frontend.product') }}">
                            <img src="{{ asset('template/images/product/monitor/lg-ultragear-27gp850.jpg') }}" alt="LG UltraGear 27GP850">
                            <span>165Hz</span>
                        </a>
                        <div class="product-card__body">
                            <small>LG</small>
                            <h3><a href="{{ route('frontend.product') }}">UltraGear 27GP850</a></h3>
                            <p>Màn QHD IPS cho gaming và làm việc đa nhiệm.</p>
                            <div class="product-card__price"><strong>6.990.000đ</strong><del>7.990.000đ</del></div>
                            <div class="product-card__actions">
                                <a href="{{ route('frontend.cart') }}"><i class="fas fa-shopping-cart"></i> Thêm</a>
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Yêu thích"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                    </article>

                    <article class="product-card">
                        <a class="product-card__media" href="{{ route('frontend.product') }}">
                            <img src="{{ asset('template/images/product/bluetooth-headphone/airpods-pro-2-usb-c.jpg') }}" alt="AirPods Pro 2 USB-C">
                            <span>ANC</span>
                        </a>
                        <div class="product-card__body">
                            <small>Apple</small>
                            <h3><a href="{{ route('frontend.product') }}">AirPods Pro 2 USB-C</a></h3>
                            <p>Chống ồn chủ động, âm thanh không gian.</p>
                            <div class="product-card__price"><strong>5.890.000đ</strong><del>6.490.000đ</del></div>
                            <div class="product-card__actions">
                                <a href="{{ route('frontend.cart') }}"><i class="fas fa-shopping-cart"></i> Thêm</a>
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Yêu thích"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                    </article>

                    <article class="product-card">
                        <a class="product-card__media" href="{{ route('frontend.product') }}">
                            <img src="{{ asset('template/images/product/mechanical-keyboard/logitech-mx-keys-s.webp') }}" alt="Logitech MX Keys S">
                            <span>Office</span>
                        </a>
                        <div class="product-card__body">
                            <small>Logitech</small>
                            <h3><a href="{{ route('frontend.product') }}">MX Keys S</a></h3>
                            <p>Bàn phím không dây, gõ êm, đèn nền thông minh.</p>
                            <div class="product-card__price"><strong>2.590.000đ</strong><del>2.990.000đ</del></div>
                            <div class="product-card__actions">
                                <a href="{{ route('frontend.cart') }}"><i class="fas fa-shopping-cart"></i> Thêm</a>
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Yêu thích"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                    </article>

                    <article class="product-card">
                        <a class="product-card__media" href="{{ route('frontend.product') }}">
                            <img src="{{ asset('template/images/product/ssd-and-ram/kingston-nv2-1tb.png') }}" alt="Kingston NV2 1TB">
                            <span>1TB</span>
                        </a>
                        <div class="product-card__body">
                            <small>Kingston</small>
                            <h3><a href="{{ route('frontend.product') }}">NV2 1TB PCIe 4.0</a></h3>
                            <p>Nâng cấp SSD nhanh cho laptop và desktop.</p>
                            <div class="product-card__price"><strong>1.390.000đ</strong><del>1.590.000đ</del></div>
                            <div class="product-card__actions">
                                <a href="{{ route('frontend.cart') }}"><i class="fas fa-shopping-cart"></i> Thêm</a>
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Yêu thích"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection
