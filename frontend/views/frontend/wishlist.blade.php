@extends('frontend.layouts.tech')

@section('title', 'Yêu thích | Đồ Công Nghệ')

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend.home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Yêu thích</span>
            </div>
            <h1>Sản phẩm yêu thích</h1>
            <p>Lưu lại các thiết bị bạn đang cân nhắc để so sánh và mua sau.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container cart-lines">
            @guest
                <div class="empty-state empty-state--small">
                    <strong>Đăng nhập để xem yêu thích</strong>
                    <span>Danh sách yêu thích được lưu theo tài khoản của bạn.</span>
                    <a class="primary-action" href="{{ route('frontend.signin') }}">Đăng nhập</a>
                </div>
            @else
                @forelse($wishlistProducts as $product)
                    <article class="wishlist-line">
                        <a href="{{ route('frontend.product', $product->slug) }}">
                            <img src="{{ asset($product->thumbnail ?: 'template/images/loading.gif') }}" alt="{{ $product->name }}">
                        </a>
                        <div>
                            <h3><a href="{{ route('frontend.product', $product->slug) }}">{{ $product->name }}</a></h3>
                            <p class="muted">{{ $product->brand_name }} · {{ $product->stock_label }} · bảo hành {{ $product->warranty_months }} tháng</p>
                            <strong>{{ $product->display_price }}</strong>
                        </div>
                        <div class="wishlist-line__actions">
                            <form action="{{ route('frontend.cart.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button class="primary-action" type="submit">Thêm vào giỏ</button>
                            </form>
                            <form action="{{ route('frontend.wishlist.items.destroy', $product->id) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="secondary-action" type="submit"><i class="fas fa-heart-broken"></i> Xóa</button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="empty-state empty-state--small">
                        <strong>Chưa có sản phẩm yêu thích</strong>
                        <span>Lưu lại các thiết bị bạn quan tâm để quay lại mua sau.</span>
                    </div>
                @endforelse
            @endguest
            <a class="secondary-action" href="{{ route('frontend.shop') }}">Xem thêm sản phẩm</a>
        </div>
    </section>
@endsection
