<?php

namespace Database\Factories;

use App\Models\BlacklistPhone;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<BlacklistPhone>
 */
class BlacklistPhoneFactory extends Factory
{
    public function definition(): array
    {
        return [
            'phone_number' => $this->faker->phoneNumber,
            'reason' => $this->faker->text,
            'status' => $this->faker->randomElement([
                BlacklistPhone::STATUS_ACTIVE,
                BlacklistPhone::STATUS_INACTIVE,
            ]),
        ];
    }
}
