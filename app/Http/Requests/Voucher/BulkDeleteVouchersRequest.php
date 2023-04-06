<?php

namespace App\Http\Requests\Voucher;

use Illuminate\Foundation\Http\FormRequest;

class BulkDeleteVouchersRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'vouchers' => ['required', 'array', 'min:1'],
            'vouchers.*' => ['integer'],
        ];
    }
}
