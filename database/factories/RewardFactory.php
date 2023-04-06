<?php

namespace Database\Factories;

use App\Models\Reward;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reward>
 */
class RewardFactory extends Factory
{
    public function definition(): array
    {
        return [
            'amount_from' => $this->faker->randomFloat(2, 0.1, 200000.99),
            'amount_to' => $this->faker->randomFloat(2, 300000, 999999.99),
            'type' => $this->faker->randomElement([
                Reward::TYPE_PERCENTAGE,
                Reward::TYPE_AMOUNT,
            ]),
            'value' => $this->faker->randomFloat(2, 0.1, 1500),
        ];
    }
}
