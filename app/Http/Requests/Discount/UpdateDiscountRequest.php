<?php

namespace App\Http\Requests\Discount;

use App\Models\Discount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDiscountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:100'],
            'code' => [
                'sometimes',
                'string',
                'max:50',
                Rule::unique('discounts', 'code')
                    ->ignore($this->route('discount')->id),
            ],
            'type' => [
                'sometimes',
                'string',
                'max:50',
                Rule::in(Discount::DISCOUNT_TYPES),
            ],
            'value' => ['sometimes', 'numeric', 'min:0'],
            'status' => [
                'sometimes',
                'string',
                'max:50',
                Rule::in([
                    Discount::STATUS_ACTIVE,
                    Discount::STATUS_INACTIVE,
                ]),
            ],
            'started_at' => ['sometimes', 'nullable', 'date'],
            'ended_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
