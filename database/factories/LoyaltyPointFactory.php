<?php

namespace Database\Factories;
use App\Models\LoyaltyPoint;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LoyaltyPoint>
 */
class LoyaltyPointFactory extends Factory
{
    protected $model = LoyaltyPoint::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'points_earned' => $this->faker->numberBetween(10, 1000),
            'points_redeemed' => $this->faker->numberBetween(0, 500),
        ];
    }
}
