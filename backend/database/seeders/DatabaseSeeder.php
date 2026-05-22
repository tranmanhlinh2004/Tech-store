<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id')
            ?: DB::table('roles')->insertGetId([
                'name' => 'admin',
                'description' => 'System administrator',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        User::query()->updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'role_id' => $adminRoleId,
                'name' => 'Admin User',
                'phone' => '0900000000',
                'password' => Hash::make('12345678'),
            ]
        );

        $this->call(CatalogSeeder::class);
    }
}
