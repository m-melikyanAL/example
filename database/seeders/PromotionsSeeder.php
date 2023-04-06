<?php

namespace Database\Seeders;

use Database\Factories\PromotionFactory;
use Illuminate\Database\Seeder;

class PromotionsSeeder extends Seeder
{
    public function run(): void
    {
        (new PromotionFactory())->count(20)
            ->create();
    }
}
