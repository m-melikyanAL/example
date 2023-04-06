<?php

namespace App\Services;

use App\Models\Reward;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class RewardService
{
    public function createFrom(array $data): Reward
    {
        return Reward::create([
            'amount_from' => Arr::get($data, 'amount_from'),
            'amount_to' => Arr::get($data, 'amount_to'),
            'type' => Arr::get($data, 'type'),
            'value' => Arr::get($data, 'value'),
        ]);
    }

    public function updateWith(array $data, Reward $reward): Reward
    {
        $reward->fill($data);
        $reward->save();

        return $reward;
    }

    /**
     * @throws \Throwable
     */
    public function delete(Reward $category): void
    {
        $category->deleteOrFail();
    }

    public function bulkDelete(Collection $rewardIds): void
    {
        Reward::destroy($rewardIds);
    }
}
