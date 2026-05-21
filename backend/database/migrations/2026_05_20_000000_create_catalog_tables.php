<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('brands')) {
            Schema::create('brands', function (Blueprint $table): void {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('logo')->nullable();
                $table->text('description')->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->boolean('status')->default(true);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('products')) {
            Schema::create('products', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('category_id')->constrained('categories');
                $table->foreignId('brand_id')->constrained('brands');
                $table->string('name');
                $table->string('slug')->unique();
                $table->string('sku')->unique();
                $table->text('short_description')->nullable();
                $table->longText('description')->nullable();
                $table->decimal('import_price', 15, 2)->default(0);
                $table->decimal('price', 15, 2);
                $table->decimal('sale_price', 15, 2)->nullable();
                $table->unsignedInteger('quantity')->default(0);
                $table->unsignedInteger('warranty_months')->default(0);
                $table->string('thumbnail')->nullable();
                $table->string('status')->default('active');
                $table->boolean('is_featured')->default(false);
                $table->boolean('is_free_shipping')->default(false);
                $table->unsignedInteger('sold_count')->default(0);
                $table->unsignedInteger('view_count')->default(0);
                $table->timestamps();

                $table->index(['status', 'is_featured']);
                $table->index('sold_count');
            });
        }

        if (! Schema::hasTable('product_images')) {
            Schema::create('product_images', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->string('image_path');
                $table->boolean('is_main')->default(false);
                $table->unsignedInteger('sort_order')->default(0);
                $table->timestamp('created_at')->nullable();
            });
        }

        if (! Schema::hasTable('product_specifications')) {
            Schema::create('product_specifications', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $table->string('spec_name');
                $table->text('spec_value');
                $table->unsignedInteger('sort_order')->default(0);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_specifications');
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('brands');
    }
};
