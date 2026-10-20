<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'id' => 1, 
                'role_name' => 'Admin', 
                'description' => 'Full access to system settings, employee management, and financial analytics.'
            ],
            [
                'id' => 2, 
                'role_name' => 'Cashier', 
                'description' => 'Handles customer transactions, manual payment confirmations, and order monitoring.'
            ],
            [
                'id' => 3, 
                'role_name' => 'Chef', 
                'description' => 'Manages kitchen workflows, order queues, and cooking status updates.'
            ],
            [
                'id' => 4, 
                'role_name' => 'Customer', 
                'description' => 'End-user access for browsing menus, cart management, and checkout.'
            ],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->updateOrInsert(
                ['id' => $role['id']], 
                $role
            );
        }
    }
}
