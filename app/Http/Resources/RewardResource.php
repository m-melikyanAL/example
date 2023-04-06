<?php

namespace App\Http\Resources;

use App\Models\Reward;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Reward $resource
 */
class RewardResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'amount_from' => $this->resource->amount_from,
            'amount_to' => $this->resource->amount_to,
            'value' => $this->resource->value,
            'type' => $this->resource->type,
        ];
    }
}
