<?php

namespace Database\Factories;

use App\Models\Campaign;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Campaign>
 */
class CampaignFactory extends Factory
{
    public function definition(): array
    {
        return [
            'created_by' => (new UserFactory())->create(),
            'promotion_id' => (new PromotionFactory())->create(),
            'client_types' => [Client::GUEST_TYPE_LOCAL],
            'channels' => [Campaign::CHANNEL_EMAIL],
            'message' => $this->faker->text,
            'sent_at' => now(),
        ];
    }
}
