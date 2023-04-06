<?php

namespace Database\Seeders;

use Database\Factories\BlacklistPhoneFactory;
use Illuminate\Database\Seeder;

class BlacklistPhoneSeeder extends Seeder
{
    public function run(): void
    {
        (new BlacklistPhoneFactory())
            ->count(50)
            ->create();
    }
}
