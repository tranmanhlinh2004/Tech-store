@extends('frontend.layouts.tech')

@section('title', 'ROG Strix G16 | Đồ Công Nghệ')
@section('meta_description', 'Chi tiết sản phẩm Asus ROG Strix G16 tại Đồ Công Nghệ.')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend.home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('frontend.shop') }}">Sản phẩm</a>
                <i class="fas fa-chevron-right"></i>
                <span>ROG Strix G16</span>
            </div>
            <h1>Asus ROG Strix G16</h1>
            <p>Laptop gaming hiệu năng cao cho esports, đồ họa và học tập kỹ thuật.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container detail-grid">
            <div class="gallery-card">
                <div class="gallery-main">
                    <img src="{{ asset('template/images/product/gaming-laptop/asus-rog-strix-g16.jpg') }}" alt="Asus ROG Strix G16">
                </div>
                <div class="thumb-row">
                    <img src="{{ asset('template/images/product/gaming-laptop/asus-rog-strix-g16.jpg') }}" alt="Góc nhìn ROG Strix G16">
                    <img src="{{ asset('template/images/product/gaming-laptop/msi-katana-15-b13v.png') }}" alt="Laptop gaming MSI">
                    <img src="{{ asset('template/images/product/gaming-laptop/lenovo-legion-5-pro.jpg') }}" alt="Laptop gaming Lenovo">
                    <img src="{{ asset('template/images/product/monitor/lg-ultragear-27gp850.jpg') }}" alt="Màn hình gaming">
                </div>
            </div>

            <aside class="purchase-card">
                <div class="rating-row">
                    <span><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i></span>
                    <span class="muted">4.8 · 126 đánh giá</span>
                </div>
                <h2>ROG Strix G16 Core i7 RTX 4060</h2>
                <p class="muted">Màn hình tần số quét cao, tản nhiệt tốt, phù hợp chơi game, dựng video và chạy phần mềm kỹ thuật.</p>
                <div class="price-row">
                    <strong>32.990.000đ</strong>
                    <del>34.990.000đ</del>
                </div>

                <strong>Cấu hình</strong>
                <div class="choice-row">
                    <span>Core i7</span>
                    <span>RTX 4060</span>
                    <span>16GB RAM</span>
                    <span>512GB SSD</span>
                </div>

                <div class="hero__actions">
                    <a class="primary-action" href="{{ route('frontend.cart') }}"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ</a>
                    <a class="secondary-action" href="{{ route('frontend.checkout') }}">Mua ngay</a>
                </div>

                <div class="spec-grid u-m-t-18">
                    <div><span>Bảo hành</span><strong>24 tháng</strong></div>
                    <div><span>Tình trạng</span><strong>Còn hàng</strong></div>
                    <div><span>Giao hàng</span><strong>Trong ngày</strong></div>
                    <div><span>Trả góp</span><strong>0%</strong></div>
                </div>
            </aside>
        </div>
    </section>

    <section class="inner-section inner-section--soft">
        <div class="site-container content-grid">
            <div class="info-card">
                <h2 class="panel-title">Mô tả sản phẩm</h2>
                <p class="muted">ROG Strix G16 là lựa chọn cân bằng cho người dùng cần hiệu năng mạnh, màn hình mượt và hệ thống tản nhiệt ổn định. Thiết kế phù hợp cả gaming lẫn công việc đồ họa.</p>
                <ul class="feature-list">
                    <li><i class="fas fa-check"></i> GPU RTX 4060 đáp ứng tốt game phổ biến và phần mềm dựng hình.</li>
                    <li><i class="fas fa-check"></i> Màn hình tần số quét cao giúp thao tác mượt và giảm nhòe chuyển động.</li>
                    <li><i class="fas fa-check"></i> Hỗ trợ nâng cấp RAM, SSD theo nhu cầu sử dụng lâu dài.</li>
                </ul>
            </div>
            <aside class="summary-card">
                <h2 class="panel-title">Dịch vụ đi kèm</h2>
                <div class="summary-list">
                    <div><span>Cài Windows, Office</span><strong>Miễn phí</strong></div>
                    <div><span>Vệ sinh lần đầu</span><strong>Miễn phí</strong></div>
                    <div><span>Đổi trả lỗi phần cứng</span><strong>7 ngày</strong></div>
                </div>
            </aside>
        </div>
    </section>
@endsection
