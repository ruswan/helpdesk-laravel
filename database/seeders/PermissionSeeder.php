<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // running Althinect/filament-spatie-roles-permissions for  generate permissions
        Artisan::call('permissions:sync');
    }
}
