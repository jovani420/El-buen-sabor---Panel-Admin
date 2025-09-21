<?php

namespace Database\Factories;
use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{

       protected $model = Discount::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['percentage', 'fixed']);
        return [
               'code' => $this->faker->unique()->regexify('[A-Z0-9]{8}'),
            'value' => ($type === 'percentage') ? $this->faker->numberBetween(5, 50) : $this->faker->randomFloat(2, 1, 20),
            'type' => $type,
            'expires_at' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
