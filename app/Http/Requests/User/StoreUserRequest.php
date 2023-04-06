<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                Rule::unique('users', 'username'),
            ],
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'last_name' => ['sometimes', 'nullable', 'string', ''],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email'),
            ],
            'phone_number' => ['sometimes', 'nullable', 'numeric'],
            'phone_country_code' => ['sometimes', 'nullable', 'string'],
            'password' => ['required', 'string', 'min:5'],
        ];
    }
}
