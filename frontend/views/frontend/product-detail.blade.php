@extends('frontend.layouts.tech')

@section('title', $product->name.' | Đồ Công Nghệ')
@section('meta_description', $product->teaser)

@section('content')
    @php
        $mainImage = $productImages->first() ?: ($product->thumbnail ?: 'template/images/loading.gif');
        $reviewAverage = (float) ($reviewSummary['average'] ?? 0);
        $reviewTotal = (int) ($reviewSummary['total'] ?? 0);
    @endphp

    <section class="page-hero page-hero--compact" style="background: linear-gradient(90deg, rgba(15, 23, 42, 0.96), rgba(15, 23, 42, 0.72)), url('{{ asset($mainImage) }}') right center / contain no-repeat, #111827;">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend.home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('frontend.shop') }}">Sản phẩm</a>
                @if ($product->category_name)
                    <i class="fas fa-chevron-right"></i>
                    <a href="{{ route('frontend.shop', ['category' => $product->category_id]) }}">{{ $product->category_name }}</a>
                @endif
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('frontend.shop', ['category' => $product->category_slug]) }}">{{ $product->category_name }}</a>
                <i class="fas fa-chevron-right"></i>
                <span>{{ $product->name }}</span>
            </div>
            <h1>{{ $product->name }}</h1>
            <p>{{ $product->teaser }}</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container detail-grid">
            <div class="gallery-card">
                <div class="gallery-main">
                    <img src="{{ asset($mainImage) }}" alt="{{ $product->name }}">
                </div>

                <div class="thumb-row">
                    @foreach($productImages as $image)
                        <img src="{{ asset($image) }}" alt="{{ $product->name }}">
                    @endforeach
                </div>
            </div>

            <aside class="purchase-card">
                <div class="rating-row">
                    <span class="star-meter" aria-label="{{ $reviewTotal ? ($reviewSummary['average_label'].' trên 5 sao') : 'Chưa có đánh giá' }}">
                        @for($star = 1; $star <= 5; $star++)
                            @if($reviewAverage >= $star)
                                <i class="fas fa-star"></i>
                            @elseif($reviewAverage >= $star - 0.5)
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </span>
                    <a class="muted" href="#reviews">{{ $reviewTotal ? $reviewSummary['average_label'].'/5 từ '.$reviewTotal.' đánh giá' : 'Chưa có đánh giá' }}</a>
                    <span class="muted">{{ number_format($product->view_count) }} lượt xem</span>
                </div>
                <h2>{{ $product->name }}</h2>
                <p class="muted">{{ $product->teaser }}</p>
                <div class="price-row">
                    <strong>{{ $product->display_price }}</strong>
                    @if($product->display_original_price)
                        <del>{{ $product->display_original_price }}</del>
                    @endif
                </div>

                <strong>Thông tin nhanh</strong>
                <div class="choice-row">
                    @forelse($specifications->take(4) as $spec)
                        <span>{{ $spec->spec_name }}: {{ $spec->spec_value }}</span>
                    @empty
                        <span>{{ $product->brand_name }}</span>
                        <span>{{ $product->category_name }}</span>
                        <span>{{ $product->sku }}</span>
                    @endforelse
                </div>

                <div class="hero__actions u-m-t-20">
                    <form class="cart-add-form" action="{{ route('frontend.cart.store') }}" method="post" @guest data-cart-login-trigger @endguest>
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <button class="primary-action" type="submit"><i class="fas fa-shopping-cart"></i> Thêm vào giỏ</button>
                    </form>
                    <a class="secondary-action" href="{{ route('frontend.checkout') }}">Mua ngay</a>
                </div>

                <div class="spec-grid u-m-t-18">
                    <div><span>Thương hiệu</span><strong>{{ $product->brand_name }}</strong></div>
                    <div><span>Danh mục</span><strong>{{ $product->category_name }}</strong></div>
                    <div><span>Bảo hành</span><strong>{{ $product->warranty_months }} tháng</strong></div>
                    <div><span>Tình trạng</span><strong>{{ $product->stock_label }}</strong></div>
                    <div><span>Mã sản phẩm</span><strong>{{ $product->sku }}</strong></div>
                    <div><span>Giao hàng</span><strong>{{ $product->is_free_shipping ? 'Miễn phí' : 'Trong ngày' }}</strong></div>
                </div>
            </aside>
        </div>
    </section>

    <section class="inner-section inner-section--soft">
        <div class="site-container content-grid">
            <div class="info-card">
                <h2 class="panel-title">Mô tả sản phẩm</h2>
                <p class="muted">{{ $product->description ?: $product->teaser }}</p>
                <ul class="feature-list">
                    <li><i class="fas fa-check"></i> Tư vấn cấu hình theo nhu cầu học tập, làm việc hoặc giải trí.</li>
                    <li><i class="fas fa-check"></i> Hỗ trợ kiểm tra máy, phụ kiện và tình trạng bảo hành trước khi nhận hàng.</li>
                    <li><i class="fas fa-check"></i> Đổi trả trong 7 ngày nếu phát sinh lỗi phần cứng từ nhà sản xuất.</li>
                </ul>
            </div>

            <aside class="summary-card">
                <h2 class="panel-title">Thông số kỹ thuật</h2>
                <div class="summary-list">
                    @forelse($specifications as $spec)
                        <div><span>{{ $spec->spec_name }}</span><strong>{{ $spec->spec_value }}</strong></div>
                    @empty
                        <div><span>SKU</span><strong>{{ $product->sku }}</strong></div>
                        <div><span>Tồn kho</span><strong>{{ $product->quantity }}</strong></div>
                    @endforelse
                </div>
            </aside>
        </div>
    </section>

    <section class="inner-section" id="reviews">
        <div class="site-container review-grid">
            <div class="review-list-card">
                <div class="review-heading">
                    <div>
                        <span>Khách hàng nói gì</span>
                        <h2 class="panel-title">Bình luận và đánh giá sản phẩm</h2>
                    </div>
                    <a class="secondary-action" href="#review-form"><i class="fas fa-pen"></i> Viết đánh giá</a>
                </div>

                <div class="review-summary">
                    <div class="review-score">
                        <strong>{{ $reviewSummary['average_label'] }}</strong>
                        <span>/5</span>
                        <div class="star-meter" aria-hidden="true">
                            @for($star = 1; $star <= 5; $star++)
                                @if($reviewAverage >= $star)
                                    <i class="fas fa-star"></i>
                                @elseif($reviewAverage >= $star - 0.5)
                                    <i class="fas fa-star-half-alt"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <p>{{ $reviewTotal }} đánh giá đã hiển thị</p>
                    </div>

                    <div class="rating-breakdown">
                        @foreach($reviewSummary['distribution'] as $row)
                            <div class="rating-breakdown__row">
                                <span>{{ $row['rating'] }} sao</span>
                                <div class="rating-breakdown__bar"><i style="width: {{ $row['percent'] }}%"></i></div>
                                <strong>{{ $row['count'] }}</strong>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="review-list">
                    @forelse($reviews as $review)
                        <article class="review-item">
                            <div class="review-avatar">{{ $review->initials }}</div>
                            <div class="review-item__body">
                                <div class="review-item__top">
                                    <div>
                                        <strong>{{ $review->display_name }}</strong>
                                        <span>{{ $review->display_date }}</span>
                                    </div>
                                    <span class="star-meter" aria-label="{{ $review->rating }} trên 5 sao">
                                        @for($star = 1; $star <= 5; $star++)
                                            <i class="{{ $star <= (int) $review->rating ? 'fas' : 'far' }} fa-star"></i>
                                        @endfor
                                    </span>
                                </div>
                                @if($review->title)
                                    <h3>{{ $review->title }}</h3>
                                @endif
                                <p>{{ $review->comment }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="empty-state">
                            <strong>Chưa có đánh giá nào</strong>
                            <span>Hãy là người đầu tiên chia sẻ trải nghiệm về sản phẩm này.</span>
                        </div>
                    @endforelse
                </div>
            </div>

            <aside class="review-form-card" id="review-form">
                <h2 class="panel-title">Gửi đánh giá của bạn</h2>
                <form action="{{ route('frontend.product.reviews.store', $product->id) }}" method="post">
                    @csrf
                    <div class="field">
                        <label>Chọn số sao</label>
                        <div class="rating-input" role="radiogroup" aria-label="Chọn số sao đánh giá">
                            @for($star = 5; $star >= 1; $star--)
                                <input id="review-rating-{{ $star }}" type="radio" name="rating" value="{{ $star }}" @checked((int) old('rating', 5) === $star)>
                                <label for="review-rating-{{ $star }}" title="{{ $star }} sao"><i class="fas fa-star"></i></label>
                            @endfor
                        </div>
                        @error('rating')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    @guest
                        <div class="form-grid">
                            <div class="field">
                                <label for="reviewer_name">Tên của bạn</label>
                                <input id="reviewer_name" name="reviewer_name" type="text" value="{{ old('reviewer_name') }}" autocomplete="name" required>
                                @error('reviewer_name')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="field">
                                <label for="reviewer_email">Email</label>
                                <input id="reviewer_email" name="reviewer_email" type="email" value="{{ old('reviewer_email') }}" autocomplete="email" required>
                                @error('reviewer_email')
                                    <p class="field-error">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @else
                        <p class="review-auth-note"><i class="fas fa-user-check"></i> Đánh giá dưới tên {{ auth()->user()->name }}.</p>
                    @endguest

                    <div class="field">
                        <label for="review_title">Tiêu đề</label>
                        <input id="review_title" name="title" type="text" value="{{ old('title') }}" maxlength="120" placeholder="Ví dụ: Sản phẩm đúng nhu cầu">
                        @error('title')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="review_comment">Bình luận</label>
                        <textarea id="review_comment" name="comment" required placeholder="Chia sẻ cảm nhận thực tế, điểm hài lòng hoặc điều cần cải thiện...">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="primary-action" type="submit"><i class="fas fa-paper-plane"></i> Gửi đánh giá</button>
                </form>
            </aside>
        </div>
    </section>

    @if($relatedProducts->isNotEmpty())
        <section class="product-section" aria-labelledby="related-title">
            <div class="site-container">
                <div class="section-heading">
                    <span>Gợi ý thêm</span>
                    <h2 id="related-title">Sản phẩm liên quan</h2>
                    <a href="{{ route('frontend.shop', ['category' => $product->category_slug]) }}">Xem danh mục <i class="fas fa-arrow-right"></i></a>
                </div>

                <div class="product-grid">
                    @foreach($relatedProducts as $relatedProduct)
                        @include('frontend.partials.product-card', ['product' => $relatedProduct])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
