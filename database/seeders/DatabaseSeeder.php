<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(FormSeeder::class);
        $this->call(FieldTypeSeeder::class);
        $this->call(FieldSeeder::class);
        $this->call(ProcessSeeder::class);
        $this->call(ConditionSeeder::class);
        $this->call(ActivitySeeder::class);
        $this->call(ActivityRelationSeeder::class);
        $this->call(ParticipantSeeder::class);
        // $this->call(AllFieldFormSeeder::class);
    }
}

