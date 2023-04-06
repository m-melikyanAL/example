<?php

namespace App\Http\Requests\Voucher;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'phone_country_code' => ['sometimes', 'string', 'max:5'],
            'phone_number' => ['sometimes', 'string', 'max:15'],
            'room_number' => ['sometimes', 'integer'],
            'first_name' => ['sometimes', 'string', 'nullable', 'max:255'],
            'last_name' => ['sometimes', 'string', 'nullable', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'value' => ['required', 'numeric', 'min:0'],
            'is_percentage' => ['sometimes', 'boolean'],
            'description' => ['sometimes', 'string', 'nullable'],
            'tags' => ['sometimes', 'array'],
            'tags.*' => ['string'],
            'expires_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
