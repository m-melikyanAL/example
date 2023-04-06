<?php

namespace Database\Seeders;

use Database\Factories\DiscountFactory;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        (new DiscountFactory())->count(3)
            ->create();
    }
}
