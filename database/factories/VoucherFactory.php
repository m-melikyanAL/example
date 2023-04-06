<?php

namespace Database\Factories;

use App\Models\Voucher;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoucherFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(Voucher::VOUCHER_TYPES),
            'value' => number_format(
                $this->faker->randomFloat(2, 0.1, 1500),
                2,
                '.',
                ''
            ),
            'is_percentage' => false,
            'room_number' => (string) $this->faker->randomNumber(3),
            'qr_data' => $this->faker->text(50),
            'qr_image_path' => ('/' . implode('/', $this->faker->words($this->faker->numberBetween(0, 4)))),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone_number' => $this->faker->numerify('###########'),
            'phone_country_code' => (string) $this->faker->randomNumber(3),
            'title' => $this->faker->title,
            'description' => $this->faker->text,
        ];
    }
}
