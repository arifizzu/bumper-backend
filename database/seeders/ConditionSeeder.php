<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Condition;

class ConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Condition::create([
            'label' => "Staff?",
            'condition_variable' => "email",
            'condition_operator' => "equal to",
            'condition_value' => "staff@example.com",
        ]);

        Condition::create([
            'label' => "Office hour?",
            'condition_variable' => "time",
            'condition_operator' => "less than",
            'condition_value' => "18:00",
        ]);
    }
}
