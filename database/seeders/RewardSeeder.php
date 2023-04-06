<?php

namespace Database\Seeders;

use Database\Factories\RewardFactory;
use Illuminate\Database\Seeder;

class RewardSeeder extends Seeder
{
    public function run(): void
    {
        (new RewardFactory())->count(3)
            ->create();
    }
}
