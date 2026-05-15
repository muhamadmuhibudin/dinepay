<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\Order;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_checkout_stores_order_with_pending_payment_status(): void
    {
        $this->seedRoles();

        $category = Category::create([
            'cat_name' => 'Food',
            'description' => 'Main dishes',
        ]);

        $item = Item::create([
            'name' => 'Sushi Platter',
            'description' => 'Fresh sushi selection',
            'price' => 25000,
            'category_id' => $category->id,
            'img' => null,
            'is_active' => true,
        ]);

        $cart = [
            $item->id => [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'image' => $item->img,
                'qty' => 2,
                'category' => $category->cat_name,
            ],
        ];

        $response = $this
            ->withSession([
                'cart' => $cart,
                'tableNumber' => 7,
            ])
            ->post(route('checkout.store'), [
                'fullname' => 'Jane Customer',
                'phone' => '+15551234567',
                'payment_method' => Order::PAYMENT_METHOD_CASH,
                'note' => 'No onions',
            ]);

        $response->assertRedirect(route('menu.index'));

        $this->assertDatabaseHas('orders', [
            'subtotal' => 50000,
            'tax' => 5000,
            'grand_total' => 55000,
            'status' => Order::STATUS_PENDING,
            'table_number' => 7,
            'payment_method' => Order::PAYMENT_METHOD_CASH,
            'payment_status' => Order::PAYMENT_STATUS_PENDING,
            'note' => 'No onions',
        ]);

        $this->assertDatabaseHas('order_items', [
            'item_id' => $item->id,
            'quantity' => 2,
            'price' => 50000,
            'tax' => 5000,
            'total_price' => 55000,
        ]);
    }

    public function test_checkout_rejects_unsupported_payment_method(): void
    {
        $response = $this
            ->withSession([
                'cart' => [
                    1 => [
                        'id' => 1,
                        'name' => 'Sushi Platter',
                        'price' => 25000,
                        'image' => null,
                        'qty' => 1,
                        'category' => 'Food',
                    ],
                ],
                'tableNumber' => 7,
            ])
            ->from(route('checkout'))
            ->post(route('checkout.store'), [
                'fullname' => 'Jane Customer',
                'phone' => '+15551234567',
                'payment_method' => 'crypto',
            ]);

        $response->assertRedirect(route('checkout'));
        $response->assertSessionHas('error');
        $this->assertDatabaseCount('orders', 0);
    }

    private function seedRoles(): void
    {
        Role::insert([
            ['role_name' => 'Admin', 'description' => 'Administrator'],
            ['role_name' => 'Cashier', 'description' => 'Cashier'],
            ['role_name' => 'Chef', 'description' => 'Chef'],
            ['role_name' => 'Customer', 'description' => 'Customer'],
        ]);
    }
}
