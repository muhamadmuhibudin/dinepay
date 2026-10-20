<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@dinepay.com'],
            [
                'name' => 'Admin DinePay',
                'password' => Hash::make('password'),
                'role_id' => 1,
            ]
        );

        User::updateOrCreate(
            ['email' => 'cashier@dinepay.com'],
            [
                'name' => 'Cashier DinePay',
                'password' => Hash::make('password'),
                'role_id' => 2,
            ]
        );

        User::updateOrCreate(
            ['email' => 'chef@dinepay.com'],
            [
                'name' => 'Chef DinePay',
                'password' => Hash::make('password'),
                'role_id' => 3,
            ]
        );
    }
}