<?php

namespace App\Http\Requests\Voucher;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVoucherRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'value' => ['sometimes', 'numeric', 'min:0'],
            'is_percentage' => ['sometimes', 'boolean'],
            'tags' => ['sometimes', 'array'],
            'tags.*' => ['string'],
            'expires_at' => ['sometimes', 'nullable', 'date'],
        ];
    }
}
