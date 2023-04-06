<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\CampaignSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<CampaignSchedule>
 */
class CampaignScheduleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'campaign_id' => (new CampaignFactory())->create(),
            'scheduled_by' => (new UserFactory())->create(),
            'frequency' => $this->faker->randomElement(Campaign::FREQUENCIES),
            'day' => $this->faker->numberBetween(1, 31),
            'time' => $this->faker->time('H:i'),
        ];
    }
}
