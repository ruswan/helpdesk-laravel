<?php

namespace Database\Seeders;

use App\Models\TicketStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TicketStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TicketStatus::insert([
            ['name' => 'Open'],
            ['name' => 'Assigned'],
            ['name' => 'In Progress'],
            ['name' => 'On Hold'],
            ['name' => 'Escalated'],
            ['name' => 'Pending Customer Response'],
            ['name' => 'Resolved'],
            ['name' => 'Closed'],
        ]);
    }
}
