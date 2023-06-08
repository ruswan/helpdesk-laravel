<?php

namespace Database\Seeders;

use App\Models\TicketPriorities;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketPrioritiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TicketPriorities::create(['id' => TicketPriorities::CRITICAL, 'name' => 'Critical/Urgent']);
        TicketPriorities::create(['id' => TicketPriorities::HIGHT, 'name' => 'High']);
        TicketPriorities::create(['id' => TicketPriorities::MEDIUM, 'name' => 'Medium']);
        TicketPriorities::create(['id' => TicketPriorities::LOW, 'name' => 'Low']);
        TicketPriorities::create(['id' => TicketPriorities::ENHANCEMENT, 'name' => 'Enhancement/Feature Request']);
    }
}
