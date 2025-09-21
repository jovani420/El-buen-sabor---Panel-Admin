<?php

namespace Database\Factories;
use App\Models\Addon;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Addon>
 */
class AddonFactory extends Factory
{

     protected $model = Addon::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'name' => $this->faker->unique()->word() . ' Extra',
            'price' => $this->faker->randomFloat(2, 1, 10),
        ];
    }
}
