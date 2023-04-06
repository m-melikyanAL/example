<?php

namespace App\Http\Requests\DigitalAsset;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeleteDigitalAssetsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'assets' => ['required', 'array', 'min:1'],
            'assets.*' => ['integer'],
        ];
    }
}
