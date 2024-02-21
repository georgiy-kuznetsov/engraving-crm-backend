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
            'website' => ['nullable', 'string', 'unique:providers', 'max:255'],
            'telegram' => ['nullable', 'string', 'unique:providers', 'max:255'],
            'vkontakte' => ['nullable', 'string', 'unique:providers', 'max:255'],
            'instagram' => ['nullable', 'string', 'unique:providers', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Такой поставщик уже существует',
            'name.required' => 'Поле обязательно для заполнения',
            'name.string' => 'Поле должно быть строкой',
            'name.max' => 'Поле должно быть не больше 255 символов',
            'email.unique' => 'Такая электронная почта указана у существующего поставщика',
            'email.email' => 'Введите корректный email',
            'email.required' => 'Поле обязательно для заполнения',
            'email.string' => 'Поле должно быть строкой',
            'country.string' => 'Поле должно быть строкой',
            'country.max' => 'Поле должно быть не больше 255 символов',
            'region.string' => 'Поле должно быть строкой',
            'region.max' => 'Поле должно быть не больше 255 символов',
            'city.string' => 'Поле должно быть строкой',
            'city.max' => 'Поле должно быть не больше 255 символов',
            'adress.string' => 'Поле должно быть строкой',
            'adress.max' => 'Поле должно быть не больше 255 символов',
            'postcode.int' => 'Поле должно быть числом',
            'postcode.max' => 'Поле должно быть не больше 100 символов',
            'store_link.string' => 'Поле должно быть строкой',
            'website.string' => 'Поле должно быть строкой',
            'website.max' => 'Поле должно быть не больше 255 символов',
            'telegram.string' => 'Поле должно быть строкой',
            'telegram.max' => 'Поле должно быть не больше 255 символов',
            'vkontakte.string' => 'Поле должно быть строкой',
            'vkontakte.max' => 'Поле должно быть не больше 255 символов',
            'instagram.string' => 'Поле должно быть строкой',
            'instagram.max' => 'Поле должно быть не больше 255 символов',
        ];
    }
}
