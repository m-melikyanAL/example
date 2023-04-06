<?php

namespace Database\Seeders;

use Database\Factories\TagFactory;
use Database\Factories\VoucherFactory;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        (new VoucherFactory())
            ->has(
                (new TagFactory())
                    ->state([
                        'is_active' => true,
                    ]),
                'tags'
            )
            ->count(15)
            ->create();
    }
}
