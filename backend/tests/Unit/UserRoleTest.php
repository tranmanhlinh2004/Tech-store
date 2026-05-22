<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserRoleTest extends TestCase
{
    public function test_user_matches_allowed_role(): void
    {
        $user = new User;
        $user->setRelation('role', new Role(['name' => 'admin']));

        $this->assertTrue($user->hasAnyRole(['admin', 'staff', 'manage']));
    }

    public function test_user_without_allowed_role_is_rejected(): void
    {
        $user = new User;
        $user->setRelation('role', new Role(['name' => 'customer']));

        $this->assertFalse($user->hasAnyRole(['admin', 'staff', 'manage']));
    }
}
