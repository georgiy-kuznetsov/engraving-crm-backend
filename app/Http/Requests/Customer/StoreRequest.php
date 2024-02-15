<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'unique:customers', 'max:100'],
            'phone' => ['nullable', 'string', 'max:255', 'unique:customers', 'max:100'],
            
            'country' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'adress' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'max:20'],

            'website' => ['nullable', 'string', 'unique:customers', 'max:256'],
            'telegram' => ['nullable', 'string', 'unique:customers', 'max:256'],
            'vkontakte' => ['nullable', 'string', 'unique:customers', 'max:256'],
            'instagram' => ['nullable', 'string', 'unique:customers', 'max:256'],
            'whatsapp' => ['nullable', 'string', 'unique:customers', 'max:256'],
        ];
    }
}
