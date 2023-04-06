<?php

namespace App\Http\Requests\Discount;

use App\Models\Discount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDiscountRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('discounts', 'code'),
            ],
            'type' => [
                'required',
                'string',
                'max:50',
                Rule::in(Discount::DISCOUNT_TYPES),
            ],
            'value' => ['required', 'numeric', 'min:0'],
            'status' => [
                'required',
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
