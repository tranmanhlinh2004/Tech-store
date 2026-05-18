@extends('frontend.layouts.tech')

@section('title', 'Liên hệ | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend.home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Liên hệ</span>
            </div>
            <h1>Liên hệ tư vấn và hỗ trợ kỹ thuật</h1>
            <p>Gửi nhu cầu của bạn, đội ngũ Đồ Công Nghệ sẽ phản hồi với cấu hình và phương án phù hợp.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container contact-grid">
            <form class="auth-card stack" action="{{ route('frontend.contact') }}" method="get">
                <h2 class="panel-title">Gửi tin nhắn</h2>
                <div class="form-grid">
                    <div class="field">
                        <label for="contact-name">Họ tên</label>
                        <input id="contact-name" type="text" placeholder="Tên của bạn">
                    </div>
                    <div class="field">
                        <label for="contact-phone">Số điện thoại</label>
                        <input id="contact-phone" type="tel" placeholder="0900 000 000">
                    </div>
                    <div class="field field--full">
                        <label for="contact-email">Email</label>
                        <input id="contact-email" type="email" placeholder="ban@example.com">
                    </div>
                    <div class="field field--full">
                        <label for="contact-message">Nội dung</label>
                        <textarea id="contact-message" placeholder="Bạn cần tư vấn sản phẩm nào?"></textarea>
                    </div>
                </div>
                <button class="primary-action" type="submit">Gửi yêu cầu</button>
            </form>

            <aside class="contact-methods">
                <div class="contact-method">
                    <i class="fas fa-phone-alt"></i>
                    <div>
                        <strong>Hotline</strong>
                        <p class="muted">0900 901 904</p>
                    </div>
                </div>
                <div class="contact-method">
                    <i class="far fa-envelope"></i>
                    <div>
                        <strong>Email</strong>
                        <p class="muted">contact@docongnghe.com</p>
                    </div>
                </div>
                <div class="map-card">
                    <div>
                        <h2>TP. Hồ Chí Minh</h2>
                        <p>Hỗ trợ giao nhanh nội thành và tư vấn online toàn quốc.</p>
                    </div>
                </div>
            </aside>
        </div>
    </section>
@endsection
