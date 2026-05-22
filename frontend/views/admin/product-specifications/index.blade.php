@extends('admin.layouts.app')

@section('title', 'Thông số kỹ thuật')
@section('page_title', 'Quản lý thông số kỹ thuật')

@section('content')
    <section class="admin-panel">
        <div class="admin-toolbar">
            <h2>Chọn sản phẩm</h2>
            <form action="{{ route('admin.product-specifications.index') }}" method="get">
                <select name="product_id">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" @selected($selectedProduct && $selectedProduct->id === $product->id)>{{ $product->name }}</option>
                    @endforeach
                </select>
                <button class="admin-link-button" type="submit"><i class="fas fa-search"></i> Xem</button>
            </form>
        </div>
    </section>

    @if($selectedProduct)
        <form class="admin-panel" action="{{ route('admin.product-specifications.update') }}" method="post">
            @csrf
            <input type="hidden" name="product_id" value="{{ $selectedProduct->id }}">

            <div class="admin-panel__head">
                <h2>{{ $selectedProduct->name }}</h2>
                <button class="admin-button" type="submit"><i class="fas fa-save"></i> Lưu thông số</button>
            </div>

            <div class="admin-field">
                <label for="specifications">Thông số kỹ thuật</label>
                <textarea id="specifications" name="specifications" placeholder="CPU: Intel Core i7&#10;RAM: 16GB&#10;Bộ nhớ: 512GB">{{ old('specifications', $specificationText) }}</textarea>
                <span class="admin-help">Mỗi dòng một thông số theo dạng Tên: Giá trị.</span>
            </div>
        </form>

        <section class="admin-panel">
            <div class="admin-panel__head">
                <h2>Thông số hiện tại</h2>
                <span class="admin-muted">{{ $specifications->count() }} dòng</span>
            </div>

            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Thông số</th>
                            <th>Giá trị</th>
                            <th>Thứ tự</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($specifications as $specification)
                            <tr>
                                <td><strong>{{ $specification->spec_name }}</strong></td>
                                <td>{{ $specification->spec_value }}</td>
                                <td>{{ $specification->sort_order }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="3">Sản phẩm này chưa có thông số kỹ thuật.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    @else
        <section class="admin-panel">
            <p class="admin-muted">Chưa có sản phẩm để quản lý thông số.</p>
        </section>
    @endif
@endsection
