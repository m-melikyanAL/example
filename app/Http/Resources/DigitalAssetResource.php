<?php

namespace App\Http\Resources;

use App\Services\DigitalAssetService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\DigitalAsset $resource
 */
class DigitalAssetResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'path' => $this->resource->path,
            'url' => DigitalAssetService::getAssetUrl($this->resource),
            'extension' => $this->resource->extension,
            'type' => $this->resource::TYPE_NAMES[$this->resource->type],
            'status' => $this->resource->status,
            'created_at' => $this->resource->created_at->format(config('crm.date_format')),
            'updated_at' => $this->resource->updated_at->format(config('crm.date_format')),
            'category' => $this->whenLoaded('categories', $this->resource->categories->first()?->name),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'tags' => CategoryResource::collection($this->whenLoaded('tags')),
        ];
    }
}
