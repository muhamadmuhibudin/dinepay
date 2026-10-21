<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'id' => 1, 
                'cat_name' => 'Food', 
                'description' => 'Main courses, appetizers, and hearty meals.'
            ],
            [
                'id' => 2, 
                'cat_name' => 'Drink', 
                'description' => 'Refreshing cold beverages, juices, and hot drinks.'
            ],
            [
                'id' => 3, 
                'cat_name' => 'Dessert', 
                'description' => 'Sweet treats and pastries to finish your meal.'
            ],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['id' => $category['id']],
                $category
            );
        }
    }
}