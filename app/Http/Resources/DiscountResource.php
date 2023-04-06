<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Discount $resource
 */
class DiscountResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'code' => $this->resource->code,
            'type' => $this->resource->type,
            'value' => $this->resource->value,
            'display_value' => $this->resource->getDisplayValue(),
            'status' => $this->resource->status,
            'started_at' => $this->resource->started_at?->format(config('crm.date_format')),
            'ended_at' => $this->resource->ended_at?->format(config('crm.date_format')),
            'created_at' => $this->resource->created_at->format(config('crm.date_format')),
            'updated_at' => $this->resource->updated_at->format(config('crm.date_format')),
        ];
    }
}
