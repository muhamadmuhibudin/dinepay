<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Item;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(2),
            'category_id' => Category::inRandomOrder()->value('id'),
            'price' => $this->faker->randomFloat(2, 10, 200),
            'description' => $this->faker->sentence(),
            'img' => $this->faker->imageUrl(),
            'is_active' => true,
        ];
    }
}
