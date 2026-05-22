<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('wishlists')) {
            $idColumn = collect(DB::select("SHOW COLUMNS FROM wishlists WHERE Field = 'id'"))->first();

            if ($idColumn && ! str_contains(strtolower((string) $idColumn->Extra), 'auto_increment')) {
                DB::statement('ALTER TABLE wishlists MODIFY id INT NOT NULL AUTO_INCREMENT');
            }

            return;
        }

        Schema::create('wishlists', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->timestamp('created_at')->nullable();

            $table->unique(['user_id', 'product_id'], 'user_product_unique');
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('wishlists') && ! DB::table('wishlists')->exists()) {
            Schema::dropIfExists('wishlists');
        }
    }
};
