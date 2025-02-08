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

        Role::create(['name' => 'alumni'])
            ->givePermissionTo([
                'create post',
                'create comment',

                'edit own post',
                'edit own comment',

                'delete own post',
                'delete own comment',
            ]);

        Role::create(['name' => 'admin'])
            ->givePermissionTo([
                'create post',
                'create comment',

                'edit any post',
                'edit any comment',

                'delete any post',
                'delete any comment',
            ]);
    }
}
