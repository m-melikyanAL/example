<?php

namespace App\Http\Requests\Reward;

use App\Models\Reward;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRewardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount_from' => ['required', 'min:0', 'numeric'],
            'amount_to' => ['required', 'min:0', 'numeric'],
            'type' => ['required', 'string', Rule::in(Reward::REWARD_TYPES)],
            'value' => ['required', 'min:0', 'numeric'],
        ];
    }
}
