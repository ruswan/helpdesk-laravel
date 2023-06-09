<?php

namespace Database\Seeders;

use App\Models\ProblemCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'name' => 'Progbel One at Unit One',
            ],
            [
                'unit_id' => 1,
                'name' => 'Progbel Two at Unit One',
            ],
            [
                'unit_id' => 2,
                'name' => 'Progbel One at Unit Two',
            ],
            [
                'unit_id' => 2,
                'name' => 'Progbel Two at Unit Two',
            ],
        ]);
    }
}
