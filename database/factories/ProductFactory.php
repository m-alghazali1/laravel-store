<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->text(50),
            'price' => fake()->numberBetween(1, 1000),
            'quantity' => fake()->numberBetween(1, 1000),
            'category_id' => fake()->numberBetween(1, 20),
        ];
    }
    public function configure()
    {
        
    }

}
