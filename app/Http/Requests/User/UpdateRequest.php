<?php

namespace App\Http\Requests\User;

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
            'email' => ['sometimes', 'required', 'string', 'email', 'unique:users,email,' . $this->user],
            'last_name' => ['nullable', 'string', 'max:100'],
            'first_name' => ['nullable', 'string', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'login.required' => 'Поле обязательно для заполнения',
            'login.unique' => 'Такой логин уже занят другим пользователем',
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
