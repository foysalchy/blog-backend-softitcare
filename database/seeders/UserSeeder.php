<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        $superAdmin->assignRole('Super Admin');

        // Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        $admin->assignRole('Admin');

        // Moderator
        $moderator = User::create([
            'name' => 'Moderator',
            'email' => 'moderator@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        $moderator->assignRole('Moderator');

        // Regular User
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        $user->assignRole('User');
    }
}
