<?php

namespace Database\Factories;

use App\Models\Promotion;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Promotion>
 */
class PromotionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
            'message' => $this->faker->word,
            'type' => $this->faker->randomElement([
                Promotion::TYPE_EVENT,
                Promotion::TYPE_SPECIAL,
                Promotion::TYPE_OFFER,
            ]),
            'status' => $this->faker->randomElement([
                Promotion::STATUS_ACTIVE,
                Promotion::STATUS_INACTIVE,
            ]),
            'started_at' => $this->faker->date,
            'ended_at' => $this->faker->date,
            'description' => $this->faker->text,
        ];
    }
}
