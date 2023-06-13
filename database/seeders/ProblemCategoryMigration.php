<?php

namespace Database\Seeders;

use App\Models\ProblemCategory;
use Illuminate\Database\Seeder;

class ProblemCategoryMigration extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProblemCategory::insert([
            [
                'unit_id' => 1,
                'name' => 'Problem One at Sales Department',
            ],
            [
                'unit_id' => 1,
                'name' => 'Problem Two at Sales Department',
            ],
            [
                'unit_id' => 2,
                'name' => 'Problem One at Technical Support',
            ],
            [
                'unit_id' => 3,
                'name' => 'Problem One at Billing Support',
            ],
        ]);
    }
}
