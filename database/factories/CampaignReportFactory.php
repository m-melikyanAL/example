<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\CampaignReport;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<CampaignReport>
 */
class CampaignReportFactory extends Factory
{
    public function definition(): array
    {
        return [
            'campaign_id' => (new CampaignFactory())->create(),
            'guest_id' => (new ClientFactory())->create(),
            'delivery_status' => $this->faker->randomElement([
                CampaignReport::STATUS_DELIVERED,
                CampaignReport::STATUS_VIEWED,
            ]),
            'channel' => Campaign::CHANNEL_EMAIL,
        ];
    }
}
