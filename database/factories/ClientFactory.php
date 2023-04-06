<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Client>
 */
class ClientFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->email,
            'salutation' => $this->faker->title,
            'gender' => $this->faker->randomElement([
                Client::GENDER_MALE,
                Client::GENDER_FEMALE,
            ]),
            'phone_number' => $this->faker->phoneNumber,
            'phone_country_code' => '+1',
            'status' => $this->faker->randomElement(Client::GUEST_TYPES),
            'born_at' => $this->faker->date,
        ];
    }
}
