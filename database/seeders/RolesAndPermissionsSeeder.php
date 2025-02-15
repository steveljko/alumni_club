<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insertOrIgnore([
            ['name' => 'create post', 'guard_name' => 'web'],
            ['name' => 'edit any post', 'guard_name' => 'web'],
            ['nam ' => 'edit own post', 'guard_name' => 'web'],
            ['name' => 'delete any post', 'guard_name' => 'web'],
            ['name' => 'delete own post', 'guard_name' => 'web'],
        ]);

        Permission::insertOrIgnore([
            ['name' => 'create comment', 'guard_name' => 'web'],
            ['name' => 'edit any comment', 'guard_name' => 'web'],
            ['nam ' => 'edit own comment', 'guard_name' => 'web'],
            ['name' => 'delete any comment', 'guard_name' => 'web'],
            ['name' => 'delete own comment', 'guard_name' => 'web'],
        ]);

        Permission::insertOrIgnore([
            ['name' => 'create user', 'guard_name' => 'web'],
            ['name' => 'edit any user', 'guard_name' => 'web'],
            ['name' => 'delete any user', 'guard_name' => 'web'],
        ]);

        Permission::insertOrIgnore([
            ['name' => 'create work history', 'guard_name' => 'web'],
            ['name' => 'edit any work history', 'guard_name' => 'web'],
            ['name' => 'edit own work history', 'guard_name' => 'web'],
            ['name' => 'delete any work history', 'guard_name' => 'web'],
            ['name' => 'delete own work history', 'guard_name' => 'web'],
        ]);

        Role::create(['name' => 'alumni'])
            ->givePermissionTo([
                'create post',
                'create comment',
                'create work history',

                'edit own post',
                'edit own comment',
                'edit own work history',

                'delete own post',
                'delete own work history',
            ]);

        Role::create(['name' => 'admin'])
            ->givePermissionTo([
                'create user',
                'create post',
                'create comment',

                'edit any user',
                'edit any post',
                'edit any comment',
                'edit any work history',

                'delete any user',
                'delete any post',
                'delete any comment',
                'delete any work history',
            ]);
    }
}
