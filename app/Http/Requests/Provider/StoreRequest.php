<?php

namespace App\Http\Requests\Provider;

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
            'name' => ['required', 'string', 'max:255', 'unique:providers'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:providers'],

            'country' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'adress' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'int', 'max:100'],

            'store_link' => ['nullable', 'string'],
            'website' => ['nullable', 'string', 'unique:providers', 'max:256'],
            'telegram' => ['nullable', 'string', 'unique:providers', 'max:256'],
            'vkontakte' => ['nullable', 'string', 'unique:providers', 'max:256'],
            'instagram' => ['nullable', 'string', 'unique:providers', 'max:256'],
        ];
    }
}
