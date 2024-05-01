<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ActivityRelation;

class ActivityRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ActivityRelation::create([
            'source_id' => 1,
            'target_id' => 2,
            'condition_id' => 1,
        ]);

        ActivityRelation::create([
            'source_id' => 2,
            'target_id' => 3,
            'condition_id' => 2,
        ]);

        ActivityRelation::create([
            'source_id' => 1,
            'target_id' => 3,
        ]);
    }
}
