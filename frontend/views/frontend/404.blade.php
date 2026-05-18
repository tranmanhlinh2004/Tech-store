@extends('frontend.layouts.tech')

@section('title', 'Không tìm thấy trang | Đồ Công Nghệ')

@section('content')
    <section class="inner-section inner-section--soft">
        <div class="site-container">
            <div class="empty-state">
                <i class="fas fa-search"></i>
                <h1>Không tìm thấy trang</h1>
                <p>Liên kết có thể đã thay đổi hoặc sản phẩm không còn hiển thị. Bạn có thể quay về trang chủ hoặc xem danh mục sản phẩm.</p>
                <div class="hero__actions actions-center">
                    <a class="primary-action" href="{{ route('frontend.home') }}">Về trang chủ</a>
                    <a class="secondary-action" href="{{ route('frontend.shop') }}">Xem sản phẩm</a>
                </div>
            </div>
        </div>
    </section>
@endsection
