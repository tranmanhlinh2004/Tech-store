@extends('frontend.layouts.tech')

@section('title', 'Giỏ hàng | Đồ Công Nghệ')

@php
    $formatPrice = fn ($value) => number_format((float) $value, 0, ',', '.').'đ';
@endphp

@section('content')
    <section class="page-hero page-hero--compact">
        <div class="site-container">
            <div class="breadcrumb-mini">
                <a href="{{ route('frontend.home') }}">Trang chủ</a>
                <i class="fas fa-chevron-right"></i>
                <span>Giỏ hàng</span>
            </div>
            <h1>Giỏ hàng của bạn</h1>
            <p>Kiểm tra lại sản phẩm, số lượng và ưu đãi trước khi thanh toán.</p>
        </div>
    </section>

    <section class="inner-section">
        <div class="site-container cart-layout">
            <div class="cart-lines" data-cart-lines>
                @forelse($cartItems as $item)
                    <article class="cart-line" data-cart-item="{{ $item->id }}">
                        <a href="{{ $item->detail_url }}">
                            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}">
                        </a>
                        <div class="cart-line__content">
                            <h3><a href="{{ $item->detail_url }}">{{ $item->name }}</a></h3>
                            <p class="muted">{{ $item->variant_label ?: ($item->short_description ?: 'Sản phẩm trong giỏ hàng') }}</p>
                            <div class="cart-line__controls" aria-label="Cập nhật số lượng {{ $item->name }}">
                                <form action="{{ route('frontend.cart.items.update', $item->id) }}" method="post" data-cart-ajax-form>
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity" value="{{ max(1, $item->quantity - 1) }}" data-cart-quantity-input="decrease">
                                    <button class="quantity-button" type="submit" aria-label="Giảm số lượng {{ $item->name }}" data-cart-quantity-button="decrease" @disabled($item->quantity <= 1)>
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </form>
                                <span class="quantity-pill" data-cart-quantity>{{ $item->quantity }}</span>
                                <form action="{{ route('frontend.cart.items.update', $item->id) }}" method="post" data-cart-ajax-form>
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="quantity" value="{{ min($item->stock_quantity, $item->quantity + 1) }}" data-cart-quantity-input="increase">
                                    <button class="quantity-button" type="submit" aria-label="Tăng số lượng {{ $item->name }}" data-cart-quantity-button="increase" @disabled($item->quantity >= $item->stock_quantity)>
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                            </div>
                            <p class="muted u-m-0">Đơn giá: {{ $item->display_unit_price }}</p>
                        </div>
                        <div class="cart-line__aside">
                            <strong data-cart-line-total>{{ $item->display_line_total }}</strong>
                            <form action="{{ route('frontend.cart.items.destroy', $item->id) }}" method="post" data-cart-ajax-form>
                                @csrf
                                @method('DELETE')
                                <button class="cart-remove-button" type="submit" aria-label="Xóa {{ $item->name }} khỏi giỏ hàng">
                                    <i class="fas fa-trash-alt"></i>
                                    <span>Xóa</span>
                                </button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="panel empty-state">
                        <strong>Giỏ hàng đang trống</strong>
                        @guest
                            <span>Đăng nhập để xem giỏ hàng đã lưu theo tài khoản của bạn.</span>
                        @else
                            <span>Bạn chưa có sản phẩm nào trong giỏ hàng.</span>
                        @endguest
                    </div>
                @endforelse

                <a class="secondary-action" href="{{ route('frontend.shop') }}"><i class="fas fa-arrow-left"></i> Tiếp tục mua sắm</a>
                @guest
                    <a class="primary-action" href="{{ route('frontend.signin') }}">Đăng nhập</a>
                @endguest
            </div>

            <aside class="summary-card">
                <h2 class="panel-title">Tóm tắt đơn hàng</h2>
                <div class="summary-list">
                    <div><span>Số lượng</span><strong data-cart-summary="item-count">{{ $cartSummary['item_count'] }} sản phẩm</strong></div>
                    <div><span>Tạm tính</span><strong data-cart-summary="regular-subtotal">{{ $formatPrice($cartSummary['regular_subtotal']) }}</strong></div>
                    <div><span>Giảm giá</span><strong data-cart-summary="discount">-{{ $formatPrice($cartSummary['discount']) }}</strong></div>
                    <div><span>Vận chuyển</span><strong>Miễn phí</strong></div>
                    <div class="summary-total"><span>Tổng cộng</span><strong data-cart-summary="total">{{ $formatPrice($cartSummary['total']) }}</strong></div>
                </div>
                <div data-cart-summary-action data-shop-url="{{ route('frontend.shop') }}" data-checkout-url="{{ route('frontend.checkout', ['source' => 'cart']) }}">
                    @if($cartItems->isNotEmpty())
                        <a class="primary-action" href="{{ route('frontend.checkout', ['source' => 'cart']) }}">Thanh toán</a>
                    @else
                        <a class="secondary-action" href="{{ route('frontend.shop') }}">Chọn sản phẩm</a>
                    @endif
                </div>
            </aside>
        </div>
    </section>

    <script>
        (function () {
            var cartLines = document.querySelector('[data-cart-lines]');

            if (!cartLines) {
                return;
            }

            function showToast(message, type) {
                if (typeof window.showToastNotification === 'function') {
                    window.showToastNotification(message, type);
                    return;
                }

                window.alert(message);
            }

            function setRowBusy(row, busy) {
                if (!row) {
                    return;
                }

                row.classList.toggle('is-updating', busy);
                row.querySelectorAll('button').forEach(function (button) {
                    if (busy) {
                        button.dataset.wasDisabled = button.disabled ? '1' : '0';
                        button.disabled = true;
                        return;
                    }

                    button.disabled = button.dataset.wasDisabled === '1';
                    delete button.dataset.wasDisabled;
                });
            }

            function updateSummary(summary) {
                if (!summary) {
                    return;
                }

                var fields = {
                    'item-count': summary.item_count_label,
                    'regular-subtotal': summary.regular_subtotal,
                    'discount': summary.discount,
                    'total': summary.total
                };

                Object.keys(fields).forEach(function (key) {
                    var target = document.querySelector('[data-cart-summary="' + key + '"]');

                    if (target) {
                        target.textContent = fields[key];
                    }
                });

                document.querySelectorAll('[data-cart-count]').forEach(function (target) {
                    target.textContent = summary.item_count;
                });

                var action = document.querySelector('[data-cart-summary-action]');

                if (!action) {
                    return;
                }

                if (summary.item_count > 0) {
                    action.innerHTML = '<a class="primary-action" href="' + action.dataset.checkoutUrl + '">Thanh toán</a>';
                    return;
                }

                action.innerHTML = '<a class="secondary-action" href="' + action.dataset.shopUrl + '">Chọn sản phẩm</a>';
            }

            function updateItem(item) {
                if (!item) {
                    return;
                }

                var row = cartLines.querySelector('[data-cart-item="' + item.id + '"]');

                if (!row) {
                    return;
                }

                var quantity = row.querySelector('[data-cart-quantity]');
                var lineTotal = row.querySelector('[data-cart-line-total]');
                var decreaseInput = row.querySelector('[data-cart-quantity-input="decrease"]');
                var increaseInput = row.querySelector('[data-cart-quantity-input="increase"]');
                var decreaseButton = row.querySelector('[data-cart-quantity-button="decrease"]');
                var increaseButton = row.querySelector('[data-cart-quantity-button="increase"]');

                if (quantity) {
                    quantity.textContent = item.quantity;
                }

                if (lineTotal) {
                    lineTotal.textContent = item.display_line_total;
                }

                if (decreaseInput) {
                    decreaseInput.value = item.decrease_quantity;
                }

                if (increaseInput) {
                    increaseInput.value = item.increase_quantity;
                }

                if (decreaseButton) {
                    decreaseButton.disabled = item.decrease_disabled;
                    decreaseButton.dataset.wasDisabled = item.decrease_disabled ? '1' : '0';
                }

                if (increaseButton) {
                    increaseButton.disabled = item.increase_disabled;
                    increaseButton.dataset.wasDisabled = item.increase_disabled ? '1' : '0';
                }
            }

            function showEmptyCart() {
                if (cartLines.querySelector('[data-cart-empty]')) {
                    return;
                }

                var continueLink = cartLines.querySelector('a.secondary-action');
                var emptyState = document.createElement('div');
                emptyState.className = 'panel empty-state';
                emptyState.dataset.cartEmpty = 'true';
                emptyState.innerHTML = '<strong>Giỏ hàng đang trống</strong><span>Bạn chưa có sản phẩm nào trong giỏ hàng.</span>';

                cartLines.insertBefore(emptyState, continueLink || null);
            }

            async function submitCartForm(form) {
                var row = form.closest('[data-cart-item]');
                var formData = new FormData(form);

                setRowBusy(row, true);

                try {
                    var response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    var data = await response.json().catch(function () {
                        return {};
                    });

                    if (!response.ok) {
                        throw new Error(data.message || 'Không thể cập nhật giỏ hàng.');
                    }

                    setRowBusy(row, false);

                    if (data.removed_item_id) {
                        var removedRow = cartLines.querySelector('[data-cart-item="' + data.removed_item_id + '"]');

                        if (removedRow) {
                            removedRow.remove();
                        }
                    }

                    updateItem(data.item);
                    updateSummary(data.summary);

                    if (data.is_empty) {
                        showEmptyCart();
                    }

                    showToast(data.message || 'Đã cập nhật giỏ hàng.', 'success');
                } catch (error) {
                    setRowBusy(row, false);
                    showToast(error.message || 'Không thể cập nhật giỏ hàng.', 'error');
                }
            }

            document.addEventListener('submit', function (event) {
                var form = event.target.closest('[data-cart-ajax-form]');

                if (!form) {
                    return;
                }

                event.preventDefault();
                submitCartForm(form);
            });
        })();
    </script>
@endsection
