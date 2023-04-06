<?php

namespace App\Http\Requests\DigitalAsset;

use Illuminate\Foundation\Http\FormRequest;

class UploadDigitalAssetRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'asset' => ['required', 'file', 'mimes:png,jpg,jpeg,mp4,pdf', 'max:51200'],
        ];
    }
}
