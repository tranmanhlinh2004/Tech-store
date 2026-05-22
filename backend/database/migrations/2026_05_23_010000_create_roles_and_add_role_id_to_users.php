<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table): void {
                $table->id();
                $table->string('name')->unique();
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        $now = now();
        $roles = [
            ['name' => 'admin', 'description' => 'System administrator'],
            ['name' => 'manager', 'description' => 'Store manager'],
            ['name' => 'staff', 'description' => 'Store staff'],
            ['name' => 'manage', 'description' => 'Legacy manager role alias'],
            ['name' => 'customer', 'description' => 'Registered customer account'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['name' => $role['name']],
                [
                    'description' => $role['description'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        if (! Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->unsignedBigInteger('role_id')->nullable()->index();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'role_id')) {
            Schema::table('users', function (Blueprint $table): void {
                $table->dropColumn('role_id');
            });
        }

        Schema::dropIfExists('roles');
    }
};
