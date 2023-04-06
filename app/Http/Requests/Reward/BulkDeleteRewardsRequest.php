<?php

namespace App\Http\Requests\Reward;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeleteRewardsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rewards' => ['required', 'array', 'min:1'],
            'rewards.*' => ['integer'],
        ];
    }
}
