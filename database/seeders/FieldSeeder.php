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
            'width' => 3,
            'height' => 3,
            'x_coordinate' => 0,
            'y_coordinate' => 0,
        ]);

        Field::create([
            'caption' => 'Email Caption',
            'form_id' => 1,
            'type_id' => 11,
            'is_required' => true,
            'column_name' => 'test column 2',
            'width' => 4,
            'height' => 4,
            'x_coordinate' => 3,
            'y_coordinate' => 0,
        ]);

        Field::create([
            'caption' => 'Password Caption',
            'form_id' => 1,
            'type_id' => 12,
            'is_required' => true,
            'column_name' => 'test column 3',
            'width' => 4,
            'height' => 4,
            'x_coordinate' => 3,
            'y_coordinate' => 3,
        ]);

        Field::create([
            'caption' => 'Date Caption',
            'form_id' => 2,
            'type_id' => 9,
            'is_required' => false,
            'column_name' => 'test column 1',
            'width' => 3,
            'height' => 3,
            'x_coordinate' => 0,
            'y_coordinate' => 0,
        ]);

         Field::create([
            'caption' => 'Time Caption',
            'form_id' => 2,
            'type_id' => 10,
            'is_required' => false,
            'column_name' => 'test column 3',
            'width' => 3,
            'height' => 3,
            'x_coordinate' => 0,
            'y_coordinate' => 3,
        ]);
    }
}
