@extends('frontend.layouts.tech')

@section('title', 'Giới thiệu | Đồ Công Nghệ')

@section('content')
    <section class="page-hero">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend.home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Giới thiệu</span>
            </div>
            <h1>Shop công nghệ tập trung vào trải nghiệm mua sắm rõ ràng.</h1>
            <p>Đồ Công Nghệ chọn sản phẩm theo nhu cầu thực tế: học tập, văn phòng, sáng tạo nội dung, gaming và nâng cấp góc làm việc.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container content-grid">
            <div class="info-card">
                <h2 class="panel-title">Cách chúng tôi chọn sản phẩm</h2>
                <p class="muted">Mỗi thiết bị được ưu tiên theo độ ổn định, chính sách bảo hành, hiệu năng trên giá và khả năng hỗ trợ sau bán. Mục tiêu là giúp khách chọn nhanh, hiểu rõ thứ mình mua và dùng lâu dài.</p>
                <ul class="feature-list">
                    <li><i class="fas fa-check"></i> Tư vấn cấu hình theo nhu cầu thay vì chỉ theo giá.</li>
                    <li><i class="fas fa-check"></i> Chính sách bảo hành, đổi trả và nâng cấp được nói rõ trước khi mua.</li>
                    <li><i class="fas fa-check"></i> Hỗ trợ cài đặt, chuyển dữ liệu và kiểm tra máy khi nhận hàng.</li>
                </ul>
            </div>

            <aside class="summary-card">
                <h2 class="panel-title">Điểm mạnh</h2>
                <div class="summary-list">
                    <div><span>Sản phẩm mẫu</span><strong>40+</strong></div>
                    <div><span>Thương hiệu</span><strong>20</strong></div>
                    <div><span>Bảo hành</span><strong>12 - 36 tháng</strong></div>
                    <div><span>Hỗ trợ</span><strong>08:00 - 21:00</strong></div>
                </div>
            </aside>
        </div>
    </section>

    <section class="service-section">
        <div class="site-container service-grid">
            <div class="service-item">
                <i class="fas fa-search"></i>
                <strong>Tư vấn đúng nhu cầu</strong>
                <span>Gợi ý thiết bị theo ngành học, công việc, game và ngân sách.</span>
            </div>
            <div class="service-item">
                <i class="fas fa-shield-alt"></i>
                <strong>Hàng chính hãng</strong>
                <span>Thông tin bảo hành rõ ràng, hỗ trợ xử lý khi cần.</span>
            </div>
            <div class="service-item">
                <i class="fas fa-tools"></i>
                <strong>Hậu mãi kỹ thuật</strong>
                <span>Kiểm tra, vệ sinh, cài đặt và nâng cấp thiết bị.</span>
            </div>
        </div>
    </section>
@endsection
