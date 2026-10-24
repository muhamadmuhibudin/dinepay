<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class RoleAuthorizationFeatureTest extends TestCase
{
    use RefreshDatabase;

    private function seedRoles(): void
    {
        Role::insert([
            ['id' => 1, 'role_name' => 'Admin', 'description' => 'Administrator'],
            ['id' => 2, 'role_name' => 'Cashier', 'description' => 'Cashier'],
            ['id' => 3, 'role_name' => 'Chef', 'description' => 'Chef'],
            ['id' => 4, 'role_name' => 'Customer', 'description' => 'Customer'],
        ]);
    }

    private function createUser(int $roleId)
    {
        return User::create([
            'username' => 'testuser_' . Str::random(5),
            'fullname' => 'Test User',
            'phone' => '0812' . rand(1000000, 9999999),
            'password' => bcrypt('password123'),
            'role_id' => $roleId,
        ]);
    }

    public function test_customer_cannot_access_admin_orders_page()
    {
        $this->seedRoles();
        $customer = $this->createUser(4);

        // Act as Customer and attempt to access the Admin page
        $response = $this->actingAs($customer)->get(route('admin.orders.index'));

        // Ensure access is denied.
        // Change 403 to 302 if your middleware uses redirection when access is denied.
        $response->assertStatus(403); 
    }

    public function test_admin_can_access_admin_orders_page()
    {
        $this->seedRoles();
        $admin = $this->createUser(1);

        // Act as Admin
        $response = $this->actingAs($admin)->get(route('admin.orders.index'));

        // Ensure successful access (HTTP 200)
        $response->assertStatus(200);
    }
}