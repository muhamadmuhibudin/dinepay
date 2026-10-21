<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            // --- CATEGORY 1: FOOD ---
            [
                'name' => 'Chicken Noodle',
                'description' => 'Classic homemade chicken noodle with rich broth and fresh herbs.',
                'price' => 12.00,
                'category_id' => 1, 
                'img' => 'chicken-noodle.jpg', 
            ],
            [
                'name' => 'Wagyu Beef Burger',
                'description' => 'Premium wagyu beef patty with melted cheddar and caramelized onions.',
                'price' => 15.50,
                'category_id' => 1, 
                'img' => 'wagyu-burger.jpg',
            ],
            [
                'name' => 'Grilled Salmon Steak',
                'description' => 'Fresh Atlantic salmon grilled to perfection, served with asparagus.',
                'price' => 22.00,
                'category_id' => 1, 
                'img' => 'salmon-steak.jpg',
            ],
            [
                'name' => 'Margherita Pizza',
                'description' => 'Wood-fired pizza with San Marzano tomato sauce, fresh mozzarella, and basil.',
                'price' => 14.00,
                'category_id' => 1, 
                'img' => 'margherita-pizza.jpg',
            ],

            // --- CATEGORY 2: DRINK ---
            [
                'name' => 'Orange Juice',
                'description' => 'Freshly squeezed sweet orange juice served cold.',
                'price' => 5.00,
                'category_id' => 2, 
                'img' => 'orange-juice.jpg',
            ],
            [
                'name' => 'Iced Matcha Latte',
                'description' => 'Premium Japanese matcha blended with fresh milk and ice.',
                'price' => 6.50,
                'category_id' => 2, 
                'img' => 'matcha-latte.jpg',
            ],
            [
                'name' => 'Classic Lemonade',
                'description' => 'Sweet and tangy homemade lemonade with a hint of mint.',
                'price' => 4.50,
                'category_id' => 2, 
                'img' => 'lemonade.jpg',
            ],
            [
                'name' => 'Vanilla Iced Coffee',
                'description' => 'Cold brew coffee mixed with vanilla syrup and a splash of cream.',
                'price' => 5.50,
                'category_id' => 2, 
                'img' => 'vanilla-coffee.jpg',
            ],

            // --- CATEGORY 3: DESSERT ---
            [
                'name' => 'Chocolate Lava Cake',
                'description' => 'Warm chocolate cake with a gooey molten center.',
                'price' => 8.00,
                'category_id' => 3, 
                'img' => 'lava-cake.jpg',
            ],
            [
                'name' => 'Strawberry Cheesecake',
                'description' => 'Creamy New York style cheesecake topped with fresh strawberry glaze.',
                'price' => 7.50,
                'category_id' => 3, 
                'img' => 'strawberry-cheesecake.jpg',
            ],
        ];

        foreach ($items as $item) {
            Item::updateOrCreate(
                ['name' => $item['name']], 
                $item
            );
        }
    }
}
