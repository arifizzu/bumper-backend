<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Field;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Field::create([
            'caption' => 'Text Input Caption',
            'form_id' => 1,
            'type_id' => 1,
            'is_required' => true,
            'column_name' => 'test column 1',
            'width' => 30,
            'height' => 10,
            'x_coordinate' => 100,
            'y_coordinate' => -50,
        ]);

        Field::create([
            'caption' => 'Checkbox Caption',
            'form_id' => 1,
            'type_id' => 4,
            'is_required' => true,
            'column_name' => 'test column 2',
            'width' => 10,
            'height' => 5,
            'x_coordinate' => 150,
            'y_coordinate' => -200,
        ]);

        Field::create([
            'caption' => 'Checkbox Caption',
            'form_id' => 2,
            'type_id' => 4,
            'is_required' => false,
            'column_name' => 'test column 3',
            'width' => 10,
            'height' => 5,
            'x_coordinate' => 150,
            'y_coordinate' => -200,
        ]);
    }
}
