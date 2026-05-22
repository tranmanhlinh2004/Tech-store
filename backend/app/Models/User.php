<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Support\AdminPermission;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

#[Fillable(['role_id', 'name', 'phone', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function hasAnyRole(array $roles): bool
    {
        $roleName = strtolower((string) $this->role?->name);

        return in_array($roleName, $roles, true);
    }

    public function hasPermission(string $permission): bool
    {
        $roleName = strtolower((string) $this->role?->name);

        if ($roleName === 'admin') {
            return true;
        }

        if (! $this->role_id || ! Schema::hasTable('permissions') || ! Schema::hasTable('role_permissions')) {
            return $this->hasAnyRole(['admin', 'manager', 'manage', 'staff']);
        }

        return DB::table('role_permissions')
            ->join('permissions', 'permissions.id', '=', 'role_permissions.permission_id')
            ->where('role_permissions.role_id', $this->role_id)
            ->where('permissions.name', $permission)
            ->exists();
    }

    public function hasAnyPermission(array $permissions): bool
    {
        return collect($permissions)->contains(fn (string $permission): bool => $this->hasPermission($permission));
    }

    public function canAccessAdmin(): bool
    {
        if ($this->hasAnyRole(['admin', 'manager', 'manage', 'staff'])) {
            return true;
        }

        return $this->hasAnyPermission(AdminPermission::adminNames());
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
