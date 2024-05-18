<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $adminRole->givePermissionTo(
            'view user', 'create user', 'edit user', 'delete user',
            'view role', 'create role', 'edit role', 'delete role',
            'view permission', 'create permission', 'edit permission', 'delete permission',
            'view form', 'create form', 'edit form', 'delete form',
            'view process', 'create process', 'edit process', 'delete process',
            'view datalist', 'create datalist', 'edit datalist', 'delete datalist'
        );
        
        $userRole->givePermissionTo('view form');

    }
}
