<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => [
                'sometimes',
                'string',
                Rule::unique('users', 'username')
                    ->ignore($this->route('user')->id),
            ],
            'name' => ['sometimes', 'string', 'min:2', 'max:255'],
            'last_name' => ['sometimes', 'nullable', 'string', ''],
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($this->route('user')->id),
            ],
            'phone_number' => ['sometimes', 'nullable', 'string'],
            'phone_country_code' => ['sometimes', 'nullable', 'string'],
            'password' => ['sometimes', 'nullable', 'string', 'min:5'],
            'role' => ['sometimes', 'string'],
        ];
    }
}
