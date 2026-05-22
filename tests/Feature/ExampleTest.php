<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_home_redirects_to_menu_with_default_table(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('menu.index', ['table' => 1]));
    }

    public function test_removed_customer_placeholder_routes_return_not_found(): void
    {
        $this->get('/contact')->assertNotFound();
        $this->get('/customer/welcome')->assertNotFound();
    }
}
