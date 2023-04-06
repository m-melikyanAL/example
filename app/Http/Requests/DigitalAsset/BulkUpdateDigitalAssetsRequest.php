<?php

namespace App\Http\Requests\DigitalAsset;

use App\Models\DigitalAsset;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BulkUpdateDigitalAssetsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['sometimes', 'string', Rule::in(DigitalAsset::STATUSES)],
            'category' => ['sometimes', 'nullable', 'string'],
            'tags' => ['sometimes', 'nullable', 'array', 'min:1'],
            'tags.*' => ['string'],
            'assets' => ['required', 'array', 'min:1'],
            'assets.*' => ['integer'],
        ];
    }
}
