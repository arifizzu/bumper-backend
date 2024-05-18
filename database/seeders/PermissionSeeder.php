<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'view user']);
        Permission::create(['name' => 'create user']);
        Permission::create(['name' => 'edit user']);
        Permission::create(['name' => 'delete user']);

        Permission::create(['name' => 'view role']);
        Permission::create(['name' => 'create role']);
        Permission::create(['name' => 'edit role']);
        Permission::create(['name' => 'delete role']);

        Permission::create(['name' => 'view permission']);
        Permission::create(['name' => 'create permission']);
        Permission::create(['name' => 'edit permission']);
        Permission::create(['name' => 'delete permission']);

        Permission::create(['name' => 'view form']);
        Permission::create(['name' => 'create form']);
        Permission::create(['name' => 'edit form']);
        Permission::create(['name' => 'delete form']);

        Permission::create(['name' => 'view process']);
        Permission::create(['name' => 'create process']);
        Permission::create(['name' => 'edit process']);
        Permission::create(['name' => 'delete process']);

        Permission::create(['name' => 'view datalist']);
        Permission::create(['name' => 'create datalist']);
        Permission::create(['name' => 'edit datalist']);
        Permission::create(['name' => 'delete datalist']);
    }
}
