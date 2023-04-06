<?php

namespace Database\Seeders;

use Database\Factories\ClientFactory;
use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    public function run(): void
    {
        (new ClientFactory())->count(30)
            ->create();
    }
}
