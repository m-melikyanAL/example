<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Category $resource
 */
class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'description' => $this->resource->description,
            'is_active' => $this->resource->is_active,
            'created_at' => $this->resource->created_at->format('m/d/Y H:i'),
            'updated_at' => $this->resource->updated_at->format('m/d/Y H:i'),
        ];
    }
}
