<?php

namespace App\Http\Requests\MessageTemplate;

use App\Models\MessageTemplate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMessageTemplateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'message' => ['sometimes', 'nullable', 'string'],
            'type' => [
                'sometimes',
                'nullable',
                'string',
                Rule::in([
                    MessageTemplate::TYPE_PUSH,
                    MessageTemplate::TYPE_EMAIL,
                    MessageTemplate::TYPE_SMS,
                ]),
            ],
            'is_automated' => ['sometimes', 'boolean'],
            'auto_send' => ['sometimes', 'boolean'],
            'status' => [
                'sometimes',
                Rule::in([
                    MessageTemplate::STATUS_ACTIVE,
                    MessageTemplate::STATUS_INACTIVE,
                ]),
            ],
            'date' => ['sometimes', 'nullable', 'date'],
            'time' => ['sometimes', 'nullable', 'date_format:H:i'],
            'days' => ['sometimes', 'nullable', 'string'],
            'number_of_days' => ['sometimes', 'nullable', 'string'],
        ];
    }
}
