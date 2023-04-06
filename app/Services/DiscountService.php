<?php

namespace App\Services;

use App\Models\Discount;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class DiscountService
{
    public function createFrom(array $data): Discount
    {
        return Discount::create([
            'name' => Arr::get($data, 'name'),
            'code' => Arr::get($data, 'code'),
            'type' => Arr::get($data, 'type'),
            'value' => Arr::get($data, 'value'),
            'status' => Arr::get($data, 'status'),
            'started_at' => Arr::get($data, 'started_at'),
            'ended_at' => Arr::get($data, 'ended_at'),
        ]);
    }

    public function updateWith(array $data, Discount $discount): Discount
    {
        $discount->fill($data);
        $discount->save();

        return $discount;
    }

    /**
     * @throws \Throwable
     */
    public function delete(Discount $discount): void
    {
        $discount->deleteOrFail();
    }

    public function bulkDelete(Collection $discountIds): void
    {
        Discount::destroy($discountIds);
    }
}
