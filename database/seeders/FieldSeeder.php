<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Field;
use App\Models\FieldLocation;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Field::create([
            'caption' => 'First Name',
            'form_id' => 1,
            'type_id' => 1,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => 'first_name',
            // 'width' => 3,
            // 'height' => 3,
            // 'x_coordinate' => 0,
            // 'y_coordinate' => 0,
        ]);

         FieldLocation::create([
            'field_id' => 1,
            'width' => 3,
            'height' => 3,
            'x_coordinate' => 0,
            'y_coordinate' => 0,
        ]);

        Field::create([
            'caption' => 'Last Name',
            'form_id' => 1,
            'type_id' => 1,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => 'last_name',
            // 'width' => 3,
            // 'height' => 3,
            // 'x_coordinate' => 3,
            // 'y_coordinate' => 0,
        ]);

        FieldLocation::create([
            'field_id' => 2,
            'width' => 3,
            'height' => 3,
            'x_coordinate' => 3,
            'y_coordinate' => 0,
        ]);

        Field::create([
            'caption' => 'Birthday',
            'form_id' => 1,
            'type_id' => 9,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => 'birthday',
            // 'width' => 3,
            // 'height' => 3,
            // 'x_coordinate' => 6,
            // 'y_coordinate' => 0,
        ]);

        FieldLocation::create([
            'field_id' => 3,
            'width' => 3,
            'height' => 3,
            'x_coordinate' => 6,
            'y_coordinate' => 0,
        ]);

        Field::create([
            'caption' => 'Email',
            'form_id' => 1,
            'type_id' => 11,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => 'email',
            // 'width' => 4,
            // 'height' => 4,
            // 'x_coordinate' => 0,
            // 'y_coordinate' => 4,
        ]);

         FieldLocation::create([
            'field_id' => 4,
            'width' => 4,
            'height' => 4,
            'x_coordinate' => 0,
            'y_coordinate' => 4,
        ]);

        Field::create([
            'caption' => 'Password',
            'form_id' => 1,
            'type_id' => 12,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => 'password',
            // 'width' => 4,
            // 'height' => 4,
            // 'x_coordinate' => 4,
            // 'y_coordinate' => 4,
        ]);

        FieldLocation::create([
            'field_id' => 5,
            'width' => 4,
            'height' => 4,
            'x_coordinate' => 4,
            'y_coordinate' => 4,
        ]);

        Field::create([
            'caption' => 'Date Caption',
            'form_id' => 2,
            'type_id' => 9,
            'is_required' => false,
            'table_name' => 'demo_items',
            'column_name' => 'manufactured_date',
            // 'width' => 3,
            // 'height' => 3,
            // 'x_coordinate' => 0,
            // 'y_coordinate' => 0,
        ]);

        FieldLocation::create([
            'field_id' => 6,
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
            'table_name' => 'demo_items',
            'column_name' => 'expired_date',
            // 'width' => 3,
            // 'height' => 3,
            // 'x_coordinate' => 0,
            // 'y_coordinate' => 3,
        ]);

         FieldLocation::create([
            'field_id' => 7,
            'width' => 3,
            'height' => 3,
            'x_coordinate' => 0,
            'y_coordinate' => 3,
        ]);
    }
}
