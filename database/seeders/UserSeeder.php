<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('admin');

        $user = User::factory()->create([
            'name' => 'Admin 2',
            'email' => 'admin2@example.com',
        ]);
        $user->assignRole('admin');

        $user2 = User::factory()->create([
            'name' => 'Staff 1',
            'email' => 'staff@example.com',
        ]);
        $user2->assignRole('user');
        $user->givePermissionTo('view user');

        User::factory()->count(10)->create();
    }
}
