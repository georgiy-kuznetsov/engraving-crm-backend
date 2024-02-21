<?php

namespace App\Http\Requests\User;

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
            'login' => ['required', 'unique:users', 'min:7', 'max:50'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string', 'confirmed', 'min:6', 'max:50'],

            'first_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'Поле обязательно для заполнения',
            'login.unique' => 'Пользователь с таким логином уже существует',
            'login.min' => 'Логин должен быть длиннее 7 символов',
            'login.max' => 'Логин должен быть короче 50 символов',
            'email.unique' => 'Пользователь с таким email уже существует',
            'email.required' => 'Поле обязательно для заполнения',
            'email.email' => 'Некорректный email',
            'email.string' => 'Поле должно быть строкой',
            'password.required' => 'Пароль не может быть пустым',
            'password.min' => 'Пароль должен быть длиннее 6 символов',
            'password.max' => 'Пароль должен быть короче 50 символов',
            'password.string' => 'Поле должно быть строкой',
            'password.confirmed' => 'Пароли не совпадают',
            'first_name.string' => 'Поле должно быть строкой',
            'first_name.max' => 'Поле должно быть короче 100 символов',
            'last_name.string' => 'Поле должно быть строкой',
            'last_name.max' => 'Поле должно быть короче 100 символов',
        ];
    }
}
