<?php

namespace App\Http\Resources;

use App\Services\QrCodeService;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Voucher $resource
 */
class VoucherResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->id,
            'guest_id' => $this->resource->guest_id,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'tags' => $this->whenLoaded(
                'tags',
                TagResource::collection($this->resource->tags)
            ),
            'type' => $this->resource->type,
            'value' => $this->resource->value,
            'is_percentage' => $this->resource->is_percentage,
            'approved_by' => $this->whenLoaded(
                'approver',
                new UserResource($this->resource->approver)
            ),
            'room_number' => $this->resource->room_number,
            'expires_at' => $this->resource->expires_at?->format(config('crm.datetime_format')),
            'qr_image_path' => $this->resource->qr_image_path,
            'qr_image_url' => QrCodeService::getQrCodeUrl($this->resource->qr_image_path),
            'phone_number' => $this->resource->phone_number,
            'phone_country_code' => $this->resource->phone_country_code,
            'title' => $this->resource->title,
            'description' => $this->resource->description,
        ];
    }
}
