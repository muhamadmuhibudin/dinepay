<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartFeatureTest extends TestCase
{
    // RefreshDatabase is required to reset the in-memory database before each test runs
    use RefreshDatabase; 

    public function test_customer_can_add_item_to_cart()
    {
        // 1. Arrange
        // Since the controller uses the $menu->category->cat_name relationship, create the category first
        $category = Category::create([
            'cat_name' => 'Food',
            'description' => 'Main course'
        ]);

        $item = Item::create([
            'name' => 'Chicken Noodle',
            'description' => 'Delicious chicken noodle',
            'price' => 12,
            'img' => 'chicken-noodle.jpg',
            'is_active' => 1,
            'category_id' => $category->id,
        ]);

        // 2. Act
        // Replace '/add-to-cart' with your actual route URL in routes/web.php
        $response = $this->postJson(route('cart.add'), [
            'id' => $item->id
        ]);

        // 3. Assert
        // Ensure the response is successful (HTTP 200)
        $response->assertStatus(200);
        
        // Ensure the 'cart' session is created
        $this->assertTrue(session()->has('cart'));
        
        // Ensure the session contains the expected data (especially the 'img' key that had a bug previously)
        $cart = session('cart');
        $this->assertEquals('chicken-noodle.jpg', $cart[$item->id]['img']);
        $this->assertEquals(1, $cart[$item->id]['qty']);
        $this->assertEquals('Food', $cart[$item->id]['category']);
    }
}