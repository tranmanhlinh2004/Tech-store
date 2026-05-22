<?php

use App\Support\AdminPermission;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('permissions')) {
            Schema::create('permissions', function (Blueprint $table): void {
                $table->id();
                $table->string('name')->unique();
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('role_permissions')) {
            Schema::create('role_permissions', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
                $table->foreignId('permission_id')->constrained('permissions')->cascadeOnDelete();
                $table->unique(['role_id', 'permission_id'], 'role_permission_unique');
            });
        }

        $now = now();

        foreach (AdminPermission::defaultRoleDescriptions() as $name => $description) {
            DB::table('roles')->updateOrInsert(
                ['name' => $name],
                [
                    'description' => $description,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        foreach (AdminPermission::descriptions() as $name => $description) {
            DB::table('permissions')->updateOrInsert(
                ['name' => $name],
                [
                    'description' => $description,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        }

        foreach (AdminPermission::defaultRolePermissions() as $roleName => $permissionNames) {
            $roleId = DB::table('roles')->where('name', $roleName)->value('id');

            if (! $roleId) {
                continue;
            }

            $existingCount = DB::table('role_permissions')->where('role_id', $roleId)->count();
            $permissionsToAttach = $roleName === 'admin' || $existingCount === 0
                ? $permissionNames
                : [];

            foreach ($permissionsToAttach as $permissionName) {
                $permissionId = DB::table('permissions')->where('name', $permissionName)->value('id');

                if (! $permissionId) {
                    continue;
                }

                DB::table('role_permissions')->updateOrInsert([
                    'role_id' => $roleId,
                    'permission_id' => $permissionId,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('permissions');
    }
};
