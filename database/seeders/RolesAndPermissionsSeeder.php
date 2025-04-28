<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'manage users',
            'manage posts',
            'manage categories',
            'manage comments',
            'moderate comments',
            'create posts',
            'comment on posts'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $superAdmin = Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $moderator = Role::create(['name' => 'Moderator']);
        $user = Role::create(['name' => 'User']);

        $superAdmin->givePermissionTo(Permission::all());
        $admin->givePermissionTo(['manage posts', 'manage comments']);
        $moderator->givePermissionTo(['moderate comments']);
        $user->givePermissionTo(['create posts', 'comment on posts']);
    }
}