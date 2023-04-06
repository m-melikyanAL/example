<?php

namespace Database\Factories;

use App\Models\Discount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discount>
 */
class DiscountFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'code' => $this->faker->unique()->word,
            'type' => $this->faker->randomElement(Discount::DISCOUNT_TYPES),
            'value' => $this->faker->randomFloat(2, 0.1, 1500),
            'status' => $this->faker->randomElement([
                Discount::STATUS_ACTIVE,
                Discount::STATUS_INACTIVE,
            ]),
            'started_at' => $this->faker->date,
            'ended_at' => $this->faker->date,
        ];
    }
}
