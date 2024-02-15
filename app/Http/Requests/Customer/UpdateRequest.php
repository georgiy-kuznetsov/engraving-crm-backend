<?php

namespace App\Http\Requests\Customer;

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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255', 'unique:customers,phone,' . $this->id, 'max:100'],
            'email' => ['required', 'string', 'email', 'unique:customers,email,' . $this->id, 'max:100'],

            'country' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'adress' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'max:20'],

            'store_link' => ['nullable', 'string'],
            'website' => ['nullable', 'string', 'unique:customers,website,' . $this->id, 'max:255'],
            'telegram' => ['nullable', 'string', 'unique:customers,telegram,' . $this->id, 'max:255'],
            'vkontakte' => ['nullable', 'string', 'unique:customers,vkontakte,' . $this->id, 'max:255'],
            'instagram' => ['nullable', 'string', 'unique:customers,instagram,' . $this->id, 'max:255'],
        ];
    }
}
