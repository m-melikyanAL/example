<?php

namespace Database\Factories;

use App\Models\DigitalAsset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<DigitalAsset>
 */
class DigitalAssetFactory extends Factory
{
    public function definition(): array
    {
        $type = $this->faker->randomElement(DigitalAsset::TYPES);
        $extension = $type === DigitalAsset::TYPE_IMAGE
            ? $this->faker->randomElement(DigitalAsset::IMAGE_EXTENSIONS)
            : $this->faker->randomElement(DigitalAsset::VIDEO_EXTENSIONS);

        return [
            'name' => $this->faker->word,
            'path' => $this->faker->word,
            'extension' => $extension,
            'type' => $type,
            'status' => $this->faker->randomElement(DigitalAsset::STATUSES),
        ];
    }
}
