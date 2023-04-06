<?php

namespace Database\Seeders;

use Database\Factories\MessageTemplateFactory;
use Illuminate\Database\Seeder;

class MessageTemplateSeeder extends Seeder
{
    public function run(): void
    {
        (new MessageTemplateFactory())->count(30)->create();
    }
}
