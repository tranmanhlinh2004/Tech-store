@extends('admin.layouts.app')

@php
    $isEdit = (bool) $product;
    $action = $isEdit ? route('admin.products.update', $product->id) : route('admin.products.store');
@endphp

@section('title', $isEdit ? 'Sửa sản phẩm' : 'Thêm sản phẩm')
@section('page_title', $isEdit ? 'Sửa sản phẩm' : 'Thêm sản phẩm')

@section('content')
    <form class="admin-panel" action="{{ $action }}" method="post" enctype="multipart/form-data">
        @csrf
        @if($isEdit)
            @method('PUT')
        @endif

        <div class="admin-form-grid">
            <div class="admin-field">
                <label for="name">Tên sản phẩm</label>
                <input id="name" name="name" value="{{ old('name', $product->name ?? '') }}" required>
            </div>

            <div class="admin-field">
                <label for="slug">Slug</label>
                <input id="slug" name="slug" value="{{ old('slug', $product->slug ?? '') }}" placeholder="Tự tạo nếu để trống">
            </div>

            <div class="admin-field">
                <label for="sku">Mã SKU</label>
                <input id="sku" name="sku" value="{{ old('sku', $product->sku ?? '') }}" required>
            </div>

            <div class="admin-field">
                <label for="status">Trạng thái</label>
                <select id="status" name="status">
                    @foreach(['active' => 'Đang bán', 'inactive' => 'Ẩn', 'out_of_stock' => 'Hết hàng'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $product->status ?? 'active') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="admin-field">
                <label for="category_id">Danh mục</label>
                <select id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected((int) old('category_id', $product->category_id ?? 0) === $category->id)>
                            {{ $category->parent_id ? '— ' : '' }}{{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="admin-field">
                <label for="brand_id">Thương hiệu</label>
                <select id="brand_id" name="brand_id" required>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" @selected((int) old('brand_id', $product->brand_id ?? 0) === $brand->id)>{{ $brand->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="admin-field">
                <label for="import_price">Giá nhập</label>
                <input id="import_price" name="import_price" type="number" min="0" step="1000" value="{{ old('import_price', $product->import_price ?? 0) }}">
            </div>

            <div class="admin-field">
                <label for="price">Giá bán</label>
                <input id="price" name="price" type="number" min="0" step="1000" value="{{ old('price', $product->price ?? '') }}" required>
            </div>

            <div class="admin-field">
                <label for="sale_price">Giá khuyến mãi</label>
                <input id="sale_price" name="sale_price" type="number" min="0" step="1000" value="{{ old('sale_price', $product->sale_price ?? '') }}">
            </div>

            <div class="admin-field">
                <label for="quantity">Tồn kho</label>
                <input id="quantity" name="quantity" type="number" min="0" value="{{ old('quantity', $product->quantity ?? 0) }}">
            </div>

            <div class="admin-field">
                <label for="warranty_months">Bảo hành (tháng)</label>
                <input id="warranty_months" name="warranty_months" type="number" min="0" value="{{ old('warranty_months', $product->warranty_months ?? 12) }}">
            </div>

            <div class="admin-field">
                <label for="thumbnail_file">Ảnh đại diện</label>
                <input type="hidden" name="current_thumbnail" value="{{ old('current_thumbnail', $product->thumbnail ?? '') }}">
                <input id="thumbnail_file" name="thumbnail_file" type="file" accept="image/png,image/jpeg,image/webp,image/gif">
                @if($product?->thumbnail)
                    <div class="admin-current-image">
                        <img src="{{ asset($product->thumbnail) }}" alt="{{ $product->name }}">
                        <span>{{ $product->thumbnail }}</span>
                    </div>
                @endif
                <span class="admin-help">Chọn file JPG, PNG, WEBP hoặc GIF từ máy. Để trống nếu muốn giữ ảnh hiện tại.</span>
            </div>

            <div class="admin-field admin-field--full">
                <label for="short_description">Mô tả ngắn</label>
                <textarea id="short_description" name="short_description">{{ old('short_description', $product->short_description ?? '') }}</textarea>
            </div>

            <div class="admin-field admin-field--full">
                <label for="description">Mô tả chi tiết</label>
                <textarea id="description" name="description">{{ old('description', $product->description ?? '') }}</textarea>
            </div>

            <div class="admin-field admin-field--full">
                <label for="specifications">Thông số kỹ thuật</label>
                <textarea id="specifications" name="specifications" placeholder="CPU: Intel Core i7&#10;RAM: 16GB">{{ old('specifications', $specificationText) }}</textarea>
                <span class="admin-help">Mỗi dòng một thông số, viết theo dạng Tên: Giá trị.</span>
            </div>

            <div class="admin-field admin-field--full">
                <label for="image_files">Ảnh phụ</label>
                <textarea name="current_image_paths" hidden>{{ old('current_image_paths', $imagePathText) }}</textarea>
                <input id="image_files" name="image_files[]" type="file" accept="image/png,image/jpeg,image/webp,image/gif" multiple>
                <span class="admin-help">Có thể chọn nhiều file cùng lúc. File mới sẽ được thêm vào danh sách ảnh phụ hiện tại.</span>
            </div>

            <div class="admin-field admin-field--full">
                <div class="admin-checks">
                    <label><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured ?? false))> Sản phẩm nổi bật</label>
                    <label><input type="checkbox" name="is_free_shipping" value="1" @checked(old('is_free_shipping', $product->is_free_shipping ?? false))> Miễn phí giao hàng</label>
                </div>
            </div>
        </div>

        <div class="admin-form-actions">
            <button class="admin-button" type="submit"><i class="fas fa-save"></i> Lưu</button>
            <a class="admin-link-button" href="{{ route('admin.products.index') }}">Quay lại</a>
            @if($isEdit)
                <a class="admin-link-button" href="{{ route('frontend.product', $product->slug) }}" target="_blank" rel="noreferrer">Xem ngoài website</a>
            @endif
        </div>
    </form>
@endsection
