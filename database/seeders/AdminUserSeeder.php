<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan role admin ada
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $admin = User::firstOrCreate(
            ['email' => 'admin@fountainhead.com'],
            [
                'name' => 'Admin-Fountainhead',
                'password' => Hash::make('adminfountainhead123'),]
        );
        $admin->assignRole($adminRole);
        $operatorRole = Role::firstOrCreate(['name' => 'operator']);
        $operator = User::firstOrCreate(
            ['email' => 'operator@fountainhead.com'],
            [
                'name' => 'Operator-Fountainhead',
                'password' => Hash::make('operatorfountainhead123'),
            ]
        );
        $operator->assignRole($operatorRole);
    }
}
