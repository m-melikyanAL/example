<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'last_name' => $this->faker->lastName,
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->email,
            'phone_number' => $this->faker->phoneNumber,
            'phone_country_code' => '',
            'password' => Hash::make('password'),
        ];
    }
}
