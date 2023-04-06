<?php

namespace App\Http\Requests\MessageTemplate;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeleteMessageTemplatesRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'messageTemplates' => ['required', 'array', 'min:1'],
            'messageTemplates.*' => ['integer'],
        ];
    }
}
