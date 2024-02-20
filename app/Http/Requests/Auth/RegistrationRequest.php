<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'login.required' => 'Логин не может быть пустым',
            'login.unique' => 'Такой логин уже занят',
            'login.min' => 'Логин должен быть не менее 7 символов',
            'login.max' => 'Логин должен быть не более 50 символов',
            'email.unique' => 'Такой email уже используется',
            'email.required' => 'Email не может быть пустым',
            'email.string' => 'Email должен быть строкой',
            'email.email' => 'Некорректный email',
            'password.required' => 'Пароль обязателен',
            'password.confirmed' => 'Пароли не совпадают',
            'password.min' => 'Пароль должен быть не менее 6 символов',
            'password.max' => 'Пароль должен быть не более 50 символов',
            'password.string' => 'Пароль должен быть строкой',
            'first_name.max' => 'Имя должно быть не более 100 символов',
            'first_name.string' => 'Имя должно быть строкой',
            'first_name.max' => 'Имя должно быть не более 100 символов',
            'last_name.max' => 'Фамилия должна быть не более 100 символов',
            'last_name.string' => 'Фамилия должна быть строкой',
            'last_name.max' => 'Фамилия должна быть не более 100 символов',

        ];
    }
}
