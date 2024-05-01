<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Activity::create([
            'name' => 'Activity 1',
            'process_id' => 1,
            'form_id' => 1,
            'status' => "active",
            'width' => 3,
            'height' => 3,
            'x_coordinate' => 0,
            'y_coordinate' => 0,
        ]);

        Activity::create([
            'name' => 'Activity 2',
            'process_id' => 1,
            'form_id' => 2,
            'status' => "active",
            'width' => 3,
            'height' => 3,
            'x_coordinate' => 3,
            'y_coordinate' => 0,
        ]);

        Activity::create([
            'name' => 'Activity 3',
            'process_id' => 1,
            'form_id' => 3,
            'status' => "active",
            'width' => 3,
            'height' => 3,
            'x_coordinate' => 6,
            'y_coordinate' => 0,
        ]);

        Activity::create([
            'name' => 'Activity 4',
            'process_id' => 1,
            'form_id' => 1,
            'status' => "active",
            'width' => 4,
            'height' => 4,
            'x_coordinate' => 0,
            'y_coordinate' => 4,
        ]);

        Activity::create([
            'name' => 'Activity 5',
            'process_id' => 2,
            'form_id' => 1,
            'status' => "active",
            'width' => 4,
            'height' => 4,
            'x_coordinate' => 4,
            'y_coordinate' => 4,
        ]);
    }
}
