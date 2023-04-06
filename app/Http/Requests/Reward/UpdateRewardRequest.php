<?php

namespace App\Http\Requests\Reward;

use App\Models\Reward;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRewardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount_from' => ['sometimes', 'min:0', 'numeric'],
            'amount_to' => ['sometimes', 'min:0', 'numeric'],
            'type' => ['sometimes', 'string', Rule::in(Reward::REWARD_TYPES)],
            'value' => ['sometimes', 'min:0', 'numeric'],
        ];
    }
}
