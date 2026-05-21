<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('banners')) {
            Schema::create('banners', function (Blueprint $table): void {
                $table->id();
                $table->string('title');
                $table->string('image');
                $table->string('link')->nullable();
                $table->string('position', 50)->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();
            });

            return;
        }

        Schema::table('banners', function (Blueprint $table): void {
            if (! Schema::hasColumn('banners', 'updated_at')) {
                $table->timestamp('updated_at')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
