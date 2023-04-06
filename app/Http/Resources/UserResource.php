<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\User $resource
 */
class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'last_name' => $this->resource->last_name,
            'username' => $this->resource->username,
            'email' => $this->resource->email,
            'phone_number' => $this->resource->phone_number,
            'phone_country_code' => $this->resource->phone_country_code,
            'role' => $this->whenLoaded(
                'roles',
                $this->resource->roles->first()?->name
            ),
        ];
    }
}
