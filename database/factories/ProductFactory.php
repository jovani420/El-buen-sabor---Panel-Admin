<?php

namespace Database\Factories;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
              'category_id' => Category::factory(),
            'name' => $this->faker->unique()->sentence(3),
            'description' => $this->faker->paragraph(2),
            'price' => $this->faker->randomFloat(2, 5, 50),
            'is_featured' => $this->faker->boolean(20),
            'is_daily_deal' => $this->faker->boolean(10),
            'allergens' => $this->faker->randomElements(['milk', 'nuts', 'gluten', 'soy'], $this->faker->numberBetween(0, 3)),
        ];
    }
}
