<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Group;
use App\Models\Form;
use App\Models\Field;
use App\Models\FieldLocation;
use App\Models\FieldListValue;

class AllFieldFormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Group::create([
            'name' => 'Test Group',
            'created_by' => 1,
        ]);

        Form::create([
            'name' => 'All Fields Form',
            'short_name' => 'AFF',
            'group_id' => 1,
            'created_by' => 1,
        ]);

        Field::create([
            'caption' => 'First Name',
            'form_id' => 4,
            'type_id' => 1,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => 'first_name',
        ]);

         FieldLocation::create([
            'field_id' => 8,
            'width' => 5,
            'height' => 2,
            'x_coordinate' => 0,
            'y_coordinate' => 0,
        ]);

        Field::create([
            'caption' => 'Textarea Last Name',
            'form_id' => 4,
            'type_id' => 2,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => 'last_name',
        ]);

        FieldLocation::create([
            'field_id' => 9,
            'width' => 7,
            'height' => 2,
            'x_coordinate' => 5,
            'y_coordinate' => 0,
        ]);

        Field::create([
            'caption' => 'Number Age',
            'form_id' => 4,
            'type_id' => 3,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => 'age',
        ]);

         FieldLocation::create([
            'field_id' => 10,
            'width' => 5,
            'height' => 2,
            'x_coordinate' => 0,
            'y_coordinate' => 2,
        ]);

        Field::create([
            'caption' => 'Status',
            'form_id' => 4,
            'type_id' => 4,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => null,
        ]);

        FieldLocation::create([
            'field_id' => 11,
            'width' => 5,
            'height' => 2,
            'x_coordinate' => 5,
            'y_coordinate' => 2,
        ]);

        FieldListValue::create([
            'label' => 'Single',
            'value' => 1,
            'field_id' => 11,
        ]);

        FieldListValue::create([
            'label' => 'Married',
            'value' => 2,
            'field_id' => 11,
        ]);
       
        Field::create([
            'caption' => 'Child',
            'form_id' => 4,
            'type_id' => 5,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => null,
        ]);

        FieldLocation::create([
            'field_id' => 12,
            'width' => 5,
            'height' => 4,
            'x_coordinate' => 0,
            'y_coordinate' => 4,
        ]);

        FieldListValue::create([
            'label' => 'More than 1',
            'value' => 1,
            'field_id' => 12,
        ]);

        FieldListValue::create([
            'label' => '2 and above',
            'value' => 2,
            'field_id' => 12,
        ]);

        Field::create([
            'caption' => 'Suiz',
            'form_id' => 4,
            'type_id' => 6,
            'is_required' => true,
            'table_name' => null,
            'column_name' => null,
        ]);

        FieldLocation::create([
            'field_id' => 13,
            'width' => 2,
            'height' => 2,
            'x_coordinate' => 10,
            'y_coordinate' => 2,
        ]);

        Field::create([
            'caption' => 'Place Lived',
            'form_id' => 4,
            'type_id' => 7,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => 'company_name',
        ]);

        FieldLocation::create([
            'field_id' => 14,
            'width' => 4,
            'height' => 4,
            'x_coordinate' => 5,
            'y_coordinate' => 4,
        ]);

        FieldListValue::create([
            'label' => 'City',
            'value' => 1,
            'field_id' => 14,
        ]);

        FieldListValue::create([
            'label' => 'Village',
            'value' => 2,
            'field_id' => 14,
        ]);

        FieldListValue::create([
            'label' => 'Oversea',
            'value' => 3,
            'field_id' => 14,
        ]);

        Field::create([
            'caption' => 'Upload Photo',
            'form_id' => 4,
            'type_id' => 8,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => 'email',
        ]);

        FieldLocation::create([
            'field_id' => 15,
            'width' => 6,
            'height' => 3,
            'x_coordinate' => 0,
            'y_coordinate' => 8,
        ]);

        Field::create([
            'caption' => 'Birthday',
            'form_id' => 4,
            'type_id' => 9,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => 'birthday',
        ]);

        FieldLocation::create([
            'field_id' => 16,
            'width' => 5,
            'height' => 3,
            'x_coordinate' => 6,
            'y_coordinate' => 8,
        ]);

        Field::create([
            'caption' => 'Current Time',
            'form_id' => 4,
            'type_id' => 10,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => 'created_at',
        ]);

        FieldLocation::create([
            'field_id' => 17,
            'width' => 5,
            'height' => 3,
            'x_coordinate' => 0,
            'y_coordinate' => 11,
        ]);

        Field::create([
            'caption' => 'Your Email',
            'form_id' => 4,
            'type_id' => 11,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => 'email',
        ]);

        FieldLocation::create([
            'field_id' => 18,
            'width' => 6,
            'height' => 3,
            'x_coordinate' => 0,
            'y_coordinate' => 14,
        ]);
    
        Field::create([
            'caption' => 'Password to Login',
            'form_id' => 4,
            'type_id' => 12,
            'is_required' => true,
            'table_name' => 'demo_customers',
            'column_name' => 'password',
        ]);

        FieldLocation::create([
            'field_id' => 19,
            'width' => 6,
            'height' => 3,
            'x_coordinate' => 6,
            'y_coordinate' => 14,
        ]);


    }
}
