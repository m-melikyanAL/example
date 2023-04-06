<?php

namespace Database\Seeders;

use Database\Factories\MagazineFactory;
use Illuminate\Database\Seeder;

class MagazineSeeder extends Seeder
{
    public function run(): void
    {
        (new MagazineFactory())->count(10)
            ->create();
    }
}
