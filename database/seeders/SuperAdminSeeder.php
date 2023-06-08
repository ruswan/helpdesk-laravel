<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. make a create role
        $role = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        // 2. make a create user
        $user = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
        ]);

        // 3. assign user to tole
        $user->syncRoles('Super Admin');
    }
}
