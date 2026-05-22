@extends('admin.layouts.app')

@section('title', 'Ảnh sản phẩm')
@section('page_title', 'Quản lý ảnh sản phẩm')

@section('content')
    <section class="admin-panel">
        <div class="admin-toolbar">
            <h2>Chọn sản phẩm</h2>
            <form action="{{ route('admin.product-images.index') }}" method="get">
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
        <form class="admin-panel" action="{{ route('admin.product-images.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ $selectedProduct->id }}">

            <div class="admin-panel__head">
                <h2>{{ $selectedProduct->name }}</h2>
                <button class="admin-button" type="submit"><i class="fas fa-save"></i> Lưu ảnh</button>
            </div>

            <div class="admin-form-grid">
                <div class="admin-field admin-field--full">
                    <label for="thumbnail_file">Ảnh đại diện</label>
                    <input type="hidden" name="current_thumbnail" value="{{ old('current_thumbnail', $selectedProduct->thumbnail ?? '') }}">
                    <input id="thumbnail_file" name="thumbnail_file" type="file" accept="image/png,image/jpeg,image/webp,image/gif">
                    @if($selectedProduct->thumbnail)
                        <div class="admin-current-image">
                            <img src="{{ asset($selectedProduct->thumbnail) }}" alt="{{ $selectedProduct->name }}">
                            <span>{{ $selectedProduct->thumbnail }}</span>
                        </div>
                    @endif
                    <span class="admin-help">Chọn file mới nếu muốn thay ảnh đại diện. Để trống để giữ ảnh hiện tại.</span>
                </div>

                <div class="admin-field admin-field--full">
                    <label for="image_files">Ảnh phụ</label>
                    <textarea name="current_image_paths" hidden>{{ old('current_image_paths', $imagePathText) }}</textarea>
                    <input id="image_files" name="image_files[]" type="file" accept="image/png,image/jpeg,image/webp,image/gif" multiple>
                    <span class="admin-help">Có thể chọn nhiều file cùng lúc. File mới sẽ được thêm vào danh sách ảnh phụ hiện tại.</span>
                </div>
            </div>
        </form>

        <section class="admin-panel">
            <div class="admin-panel__head">
                <h2>Ảnh hiện tại</h2>
                <span class="admin-muted">{{ $images->count() }} ảnh</span>
            </div>

            <div class="admin-preview-grid">
                @forelse($images as $image)
                    <div class="admin-preview-card">
                        <img src="{{ asset($image->image_path) }}" alt="{{ $selectedProduct->name }}">
                        <span>{{ $image->is_main ? 'Ảnh chính' : 'Ảnh phụ' }}</span>
                        <span>{{ $image->image_path }}</span>
                    </div>
                @empty
                    <p class="admin-muted">Sản phẩm này chưa có ảnh.</p>
                @endforelse
            </div>
        </section>
    @else
        <section class="admin-panel">
            <p class="admin-muted">Chưa có sản phẩm để quản lý ảnh.</p>
        </section>
    @endif
@endsection
