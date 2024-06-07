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
            'email' => 'admin@bumper.com',
        ]);
        $admin->assignRole('admin');

        $user = User::factory()->create([
            'name' => 'Admin 2',
            'email' => 'admin2@bumper.com',
        ]);
        $user->assignRole('admin');

        $user2 = User::factory()->create([
            'name' => 'Staff 1',
            'email' => 'staff1@bumper.com',
        ]);
        $user2->assignRole('user');
        $user->givePermissionTo('view user');

        User::factory()->count(10)->create();
    }
}
