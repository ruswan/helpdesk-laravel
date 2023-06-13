<?php

namespace Database\Seeders;

use App\Models\Priority;
use Illuminate\Database\Seeder;

class PrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Priority::create(['id' => Priority::CRITICAL, 'name' => 'Critical/Urgent']);
        Priority::create(['id' => Priority::HIGHT, 'name' => 'High']);
        Priority::create(['id' => Priority::MEDIUM, 'name' => 'Medium']);
        Priority::create(['id' => Priority::LOW, 'name' => 'Low']);
        Priority::create(['id' => Priority::ENHANCEMENT, 'name' => 'Enhancement/Feature Request']);
    }
}
