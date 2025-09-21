<?php

namespace Database\Factories;
use App\Models\User;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
     protected $model = Order::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         $status = ['pending', 'processing', 'ready', 'completed'];
        return [
              'user_id' => User::factory(),
            'status' => $this->faker->randomElement($status),
            'total_price' => $this->faker->randomFloat(2, 10, 200),
            'delivery_option' => $this->faker->randomElement(['pickup', 'delivery']),
            'delivery_address' => $this->faker->address(),
            'pickup_time' => $this->faker->time(),
            'tracking_code' => $this->faker->unique()->uuid(),
        ];
    }
}
