<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiftCertificateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number' => ['nullable', 'string', 'max:255', 'unique:girt_certificates,number'],
            'balance' => ['required', 'decimal:2', 'max:99999999.99'],
            'expires_at' => ['required', 'date'],
        ];
    }
}
