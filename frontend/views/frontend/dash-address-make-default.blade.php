@extends('frontend.layouts.tech')

@section('title', 'Đặt địa chỉ mặc định | Đồ Công Nghệ')

@section('content')
    <section class="inner-section inner-section--soft">
        <div class="site-container">
            <div class="empty-state">
                <i class="fas fa-map-marker-alt"></i>
                <h1>Đã đặt làm địa chỉ mặc định</h1>
                <p>Địa chỉ văn phòng sẽ được ưu tiên khi bạn tạo đơn hàng mới.</p>
                <a class="primary-action" href="{{ url('/dash-address-book.html') }}">Quay lại sổ địa chỉ</a>
            </div>
        </div>
    </section>
@endsection
