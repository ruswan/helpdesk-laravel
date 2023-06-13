<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::insert([
            ['name' => 'Sales Department'],
            ['name' => 'Technical Support'],
            ['name' => 'Billing Support'],
        ]);
    }
}
