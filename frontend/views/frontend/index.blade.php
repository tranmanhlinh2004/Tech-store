<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Đồ Công Nghệ - cửa hàng laptop, điện thoại, phụ kiện và thiết bị thông minh.">
    <link href="{{ asset('template/images/favicon.png') }}" rel="shortcut icon">
    <title>Đồ Công Nghệ | Laptop, điện thoại và phụ kiện chính hãng</title>

    <link rel="stylesheet" href="{{ asset('template/css/vendor.css') }}?v=20260518">
    <link rel="stylesheet" href="{{ asset('template/css/home-redesign.css') }}?v=20260518-site3">
</head>
<body>
    <header class="site-header">
        <div class="top-strip">
            <div class="site-container top-strip__inner">
                <span><i class="fas fa-shield-alt"></i> Bảo hành chính hãng đến 36 tháng</span>
                <span><i class="fas fa-truck"></i> Giao nhanh trong ngày tại nội thành</span>
                <a href="tel:0900901904"><i class="fas fa-phone-alt"></i> 0900 901 904</a>
            </div>
        </div>

        <div class="site-container nav-bar">
            <a class="brand" href="{{ route('frontend.home') }}" aria-label="Đồ Công Nghệ">
                <span class="brand__mark"><i class="fas fa-microchip"></i></span>
                <span class="brand__text">Đồ Công Nghệ</span>
            </a>

            <form class="search-bar" action="{{ route('frontend.shop') }}" method="get">
                <label class="sr-only" for="site-search">Tìm kiếm sản phẩm</label>
                <i class="fas fa-search"></i>
                <input id="site-search" name="q" type="search" placeholder="Tìm laptop, điện thoại, tai nghe...">
                <button type="submit">Tìm kiếm</button>
            </form>

            <nav class="main-nav" aria-label="Điều hướng chính">
                <a href="{{ route('frontend.shop') }}">Sản phẩm</a>
                <a href="{{ route('frontend.about') }}">Về chúng tôi</a>
                <a href="{{ route('frontend.contact') }}">Liên hệ</a>
            </nav>

            <div class="nav-actions">
                <a class="icon-button" href="{{ route('frontend.wishlist') }}" aria-label="Yêu thích">
                    <i class="far fa-heart"></i>
                </a>
                <a class="icon-button icon-button--cart" href="{{ route('frontend.cart') }}" aria-label="Giỏ hàng">
                    <i class="fas fa-shopping-bag"></i>
                    <span>2</span>
                </a>
            </div>
        </div>
    </header>

    <main>
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
                    <a class="secondary-button" href="{{ route('frontend.product') }}">
                        Xem sản phẩm nổi bật
                    </a>
                </div>

                <div class="hero__metrics" aria-label="Số liệu nổi bật">
                    <div>
                        <strong>40+</strong>
                        <span>Mẫu sản phẩm</span>
                    </div>
                    <div>
                        <strong>20</strong>
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
                    <a class="category-tile" href="{{ route('frontend.shop') }}">
                        <img src="{{ asset('template/images/product/ultrabook/macbook-air-m3-13-inch.jpg') }}" alt="Laptop mỏng nhẹ">
                        <span class="category-tile__icon"><i class="fas fa-laptop"></i></span>
                        <strong>Laptop</strong>
                        <small>Văn phòng, học tập, gaming</small>
                    </a>
                    <a class="category-tile" href="{{ route('frontend.shop') }}">
                        <img src="{{ asset('template/images/product/android-phone/samsung-galaxy-s24-ultra.jpg') }}" alt="Điện thoại Android">
                        <span class="category-tile__icon"><i class="fas fa-mobile-alt"></i></span>
                        <strong>Smartphone</strong>
                        <small>iPhone và Android</small>
                    </a>
                    <a class="category-tile" href="{{ route('frontend.shop') }}">
                        <img src="{{ asset('template/images/product/monitor/lg-ultragear-27gp850.jpg') }}" alt="Màn hình máy tính">
                        <span class="category-tile__icon"><i class="fas fa-desktop"></i></span>
                        <strong>Màn hình</strong>
                        <small>Làm việc và giải trí</small>
                    </a>
                    <a class="category-tile" href="{{ route('frontend.shop') }}">
                        <img src="{{ asset('template/images/product/bluetooth-headphone/sony-wh-1000xm5.jpg') }}" alt="Tai nghe chống ồn">
                        <span class="category-tile__icon"><i class="fas fa-headphones-alt"></i></span>
                        <strong>Âm thanh</strong>
                        <small>Tai nghe, loa, micro</small>
                    </a>
                    <a class="category-tile" href="{{ route('frontend.shop') }}">
                        <img src="{{ asset('template/images/product/mechanical-keyboard/logitech-mx-keys-s.webp') }}" alt="Bàn phím cơ và văn phòng">
                        <span class="category-tile__icon"><i class="fas fa-keyboard"></i></span>
                        <strong>Phụ kiện</strong>
                        <small>Chuột, phím, sạc, hub</small>
                    </a>
                    <a class="category-tile" href="{{ route('frontend.shop') }}">
                        <img src="{{ asset('template/images/product/pc-components/gigabyte-rtx-4060-eagle-oc.png') }}" alt="Linh kiện máy tính">
                        <span class="category-tile__icon"><i class="fas fa-memory"></i></span>
                        <strong>Linh kiện PC</strong>
                        <small>SSD, RAM, VGA, mainboard</small>
                    </a>
                </div>
            </div>
        </section>

        <section class="deal-section" aria-labelledby="deal-title">
            <div class="site-container">
                <div class="section-heading">
                    <span>Ưu đãi nhanh</span>
                    <h2 id="deal-title">Combo đang được chọn nhiều</h2>
                    <a href="{{ route('frontend.shop') }}">Săn deal <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="deal-grid">
                    <a class="deal-tile deal-tile--dark" href="{{ route('frontend.product') }}">
                        <div>
                            <span>Gaming ready</span>
                            <h3>ROG Strix G16 + chuột gaming</h3>
                            <p>Hiệu năng mạnh cho esports, đồ họa và học kỹ thuật.</p>
                        </div>
                        <img src="{{ asset('template/images/product/gaming-laptop/asus-rog-strix-g16.jpg') }}" alt="Asus ROG Strix G16">
                    </a>
                    <a class="deal-tile" href="{{ route('frontend.product') }}">
                        <div>
                            <span>Apple setup</span>
                            <h3>iPhone 15 Pro giảm 1.500.000đ</h3>
                            <p>Máy chính hãng, đủ màu, hỗ trợ trả góp.</p>
                        </div>
                        <img src="{{ asset('template/images/product/iphone/iphone-15-pro-256gb.webp') }}" alt="iPhone 15 Pro">
                    </a>
                    <a class="deal-tile deal-tile--green" href="{{ route('frontend.product') }}">
                        <div>
                            <span>Work station</span>
                            <h3>Màn hình QHD 165Hz từ 6.990.000đ</h3>
                            <p>Không gian làm việc rộng, màu sắc ổn định.</p>
                        </div>
                        <img src="{{ asset('template/images/product/monitor/lg-ultragear-27gp850.jpg') }}" alt="LG UltraGear 27GP850">
                    </a>
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
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Thêm iPhone 15 Pro vào yêu thích"><i class="far fa-heart"></i></a>
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
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Thêm Galaxy S24 Ultra vào yêu thích"><i class="far fa-heart"></i></a>
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
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Thêm MacBook Air M3 vào yêu thích"><i class="far fa-heart"></i></a>
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
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Thêm ROG Strix G16 vào yêu thích"><i class="far fa-heart"></i></a>
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
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Thêm UltraGear 27GP850 vào yêu thích"><i class="far fa-heart"></i></a>
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
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Thêm AirPods Pro 2 vào yêu thích"><i class="far fa-heart"></i></a>
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
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Thêm MX Keys S vào yêu thích"><i class="far fa-heart"></i></a>
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
                                <a href="{{ route('frontend.wishlist') }}" aria-label="Thêm Kingston NV2 vào yêu thích"><i class="far fa-heart"></i></a>
                            </div>
                        </div>
                    </article>
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
                    <span>Apple</span>
                    <span>Samsung</span>
                    <span>Dell</span>
                    <span>Asus</span>
                    <span>Logitech</span>
                    <span>Kingston</span>
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
    </main>

    <footer class="site-footer">
        <div class="site-container footer-grid">
            <div>
                <a class="brand brand--footer" href="{{ route('frontend.home') }}">
                    <span class="brand__mark"><i class="fas fa-microchip"></i></span>
                    <span class="brand__text">Đồ Công Nghệ</span>
                </a>
                <p>Shop thiết bị công nghệ cho học tập, làm việc, giải trí và nâng cấp góc làm việc cá nhân.</p>
            </div>
            <div>
                <strong>Cửa hàng</strong>
                <a href="{{ route('frontend.shop') }}">Sản phẩm</a>
                <a href="{{ route('frontend.cart') }}">Giỏ hàng</a>
                <a href="{{ route('frontend.wishlist') }}">Yêu thích</a>
            </div>
            <div>
                <strong>Hỗ trợ</strong>
                <a href="{{ route('frontend.about') }}">Giới thiệu</a>
                <a href="{{ route('frontend.contact') }}">Liên hệ</a>
                <a href="mailto:contact@docongnghe.com">contact@docongnghe.com</a>
            </div>
            <div>
                <strong>Liên hệ nhanh</strong>
                <span>0900 901 904</span>
                <span>08:00 - 21:00 mỗi ngày</span>
                <span>TP. Hồ Chí Minh</span>
            </div>
        </div>
        <div class="site-container footer-bottom">
            <span>© 2026 Đồ Công Nghệ. All rights reserved.</span>
            <span>Thanh toán an toàn · Bảo hành minh bạch</span>
        </div>
    </footer>
</body>
</html>
