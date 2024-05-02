<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Form;

class FormSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Form::create([
            'name' => 'Registration Form Test 1',
            'short_name' => 'FT-1',
            'created_by' => 1,
        ]);
        Form::create([
            'name' => 'Form Test 2',
            'short_name' => 'FT-2',
            'created_by' => 2,
        ]);
         Form::create([
            'name' => 'Form Test 3',
            'short_name' => 'FT-3',
            'created_by' => 2,
        ]);
    }
}
