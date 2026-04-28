<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            ['cat_name' => 'Food', 'description' => 'Healthy and delicious meals'],
            ['cat_name' => 'Drink', 'description' => 'Refreshing and tasty beverages'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->updateOrInsert(
                ['cat_name' => $category['cat_name']], 
                ['description' => $category['description']]
            );
        }
    }
}
