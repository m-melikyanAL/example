<?php

namespace App\Console\Commands\Temp;

use App\Models\Client;
use Illuminate\Console\Command;

class MigrateClientTypes extends Command
{
    protected $signature = 'temp:clients:migrate-types';

    public function handle(): int
    {
        $bar = $this->output->createProgressBar(Client::count());
        $bar->start();

        Client::lazy(400)
            ->each(function (Client $client) use ($bar) {
                $bar->advance();
                $client->update([
                    'type' => $this->matchType($client->status),
                ]);
            });

        $bar->finish();

        return Command::SUCCESS;
    }

    public function matchType(string|null $status): string
    {
        return match ($status) {
            'local', 'is_local' => Client::TYPE_VISITOR,
            'previous_guest' => Client::TYPE_PREVIOUS,
            'in_house' => Client::TYPE_IN_HOUSE,
            default => Client::TYPE_GUEST,
        };
    }
}
