<?php

namespace Database\Factories;

use App\Models\MessageTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<MessageTemplate>
 */
class MessageTemplateFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->unique()->slug,
            'message' => $this->faker->text,
            'status' => $this->faker->randomElement([
                MessageTemplate::STATUS_ACTIVE,
                MessageTemplate::STATUS_INACTIVE,
            ]),
        ];
    }
}
