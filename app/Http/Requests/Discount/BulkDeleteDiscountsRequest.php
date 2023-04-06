<?php

namespace App\Http\Requests\Discount;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeleteDiscountsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'discounts' => ['required', 'array', 'min:1'],
            'discounts.*' => ['integer'],
        ];
    }
}
