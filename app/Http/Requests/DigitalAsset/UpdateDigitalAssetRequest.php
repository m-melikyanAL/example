<?php

namespace App\Http\Requests\DigitalAsset;

use App\Models\DigitalAsset;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDigitalAssetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'min:1', 'max:255'],
            'categories' => ['sometimes', 'array', 'min:1'],
            'categories.*' => ['integer'],
            'tags' => ['sometimes', 'array'],
            'tags.*' => ['string'],
            'status' => ['sometimes', 'string', Rule::in(DigitalAsset::STATUSES)],
        ];
    }
}
