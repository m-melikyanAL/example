<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Tag $resource
 */
class TagResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'is_active' => $this->resource->is_active,
            'created_at' => $this->resource->created_at->format(config('crm.date_format')),
            'updated_at' => $this->resource->updated_at->format(config('crm.date_format')),
        ];
    }
}
