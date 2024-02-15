<?php

namespace App\Http\Requests\Provider;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:providers,name,' . $this->provider],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'unique:providers,email,' . $this->provider],

            'country' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'adress' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'int', 'max:100'],

            'store_link' => ['nullable', 'string'],
            'website' => ['nullable', 'string', 'max:256', 'unique:providers,website,' . $this->provider],
            'telegram' => ['nullable', 'string', 'max:256', 'unique:providers,telegram,' . $this->provider],
            'vkontakte' => ['nullable', 'string', 'max:256', 'unique:providers,vkontakte,' . $this->provider],
            'instagram' => ['nullable', 'string', 'max:256', 'unique:providers,instagram,' . $this->provider],
        ];
    }
}
