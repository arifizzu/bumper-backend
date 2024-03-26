<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Process;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Process::create([
            'name' => 'Process Test 1',
            'short_name' => 'PT-1',
        ]);
        Process::create([
            'name' => 'Process Test 2',
            'short_name' => 'PT-2',
        ]);
         Process::create([
            'name' => 'Process Test 3',
            'short_name' => 'PT-3',
        ]);
    }
}
