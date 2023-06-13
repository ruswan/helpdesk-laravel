<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'Admin Unit',
            'guard_name' => 'web',
        ]);

        Role::create([
            'name' => 'Staff Unit',
            'guard_name' => 'web',
        ]);
    }
}
