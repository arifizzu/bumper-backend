<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\FieldType;

class FieldTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FieldType::create([
            'name' => 'Text Input',
        ]);
        FieldType::create([
            'name' => 'Textarea',
        ]);
        FieldType::create([
            'name' => 'Number Input',
        ]);
        FieldType::create([
            'name' => 'Checkbox',
        ]);
        // FieldType::create([
        //     'name' => 'Checkbox Group',
        // ]);
        FieldType::create([
            'name' => 'Radio Button',
        ]);
        FieldType::create([
            'name' => 'Switch',
        ]);
        FieldType::create([
            'name' => 'Dropdown',
        ]);
        FieldType::create([
            'name' => 'File Upload',
        ]);
 
        FieldType::create([
            'name' => 'Date Picker',
        ]);
        FieldType::create([
            'name' => 'Time Picker',
        ]);
        FieldType::create([
            'name' => 'Email Input',
        ]);
        FieldType::create([
            'name' => 'Password Input',
        ]);
        // FieldType::create([
        //     'name' => 'Range Slider',
        // ]);
        // FieldType::create([
        //     'name' => 'Hidden Input',
        // ]);
    }
}
