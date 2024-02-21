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
            'phone' => ['nullable', 'string', 'max:255', 'unique:customers'],
            'country' => ['nullable', 'string', 'max:255'],
            'region' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'adress' => ['nullable', 'string', 'max:255'],
            'postcode' => ['nullable', 'string', 'max:20'],
            'website' => ['nullable', 'string', 'unique:customers', 'max:255'],
            'telegram' => ['nullable', 'string', 'unique:customers', 'max:255'],
            'vkontakte' => ['nullable', 'string', 'unique:customers', 'max:255'],
            'instagram' => ['nullable', 'string', 'unique:customers', 'max:255'],
            'whatsapp' => ['nullable', 'string', 'unique:customers', 'max:255'],
        ];
    }


    public function messages(): array
    {
        return [
            'first_name.required' => 'Имя не может быть пустым',
            'first_name.string' => 'Имя должно быть строкой',
            'first_name.max' => 'Имя не может быть больше 255 символов',
            'last_name.string' => 'Фамилия должна быть строкой',
            'last_name.max' => 'Фамилия не может быть больше 255 символов',
            'email.unique' => 'Покупатель с таким email уже существует',
            'email.string' => 'Email должен быть строкой',
            'email.email' => 'Введен некорректный email',
            'email.max' => 'Email не может быть больше 100 символов',
            'phone.string' => 'Телефон должен быть строкой',
            'phone.max' => 'Телефон не может быть больше 100 символов',
            'phone.unique' => 'Такой телефон уже существует',
            'country.string' => 'Страна должна быть строкой',
            'country.max' => 'Страна не может быть больше 255 символов',
            'region.string' => 'Регион должен быть строкой',
            'region.max' => 'Регион не может быть больше 255 символов',
            'city.string' => 'Город должен быть строкой',
            'city.max' => 'Город не может быть больше 255 символов',
            'adress.string' => 'Адрес должен быть строкой',
            'adress.max' => 'Адрес не может быть больше 255 символов',
            'postcode.string' => 'Почтовый индекс должен быть строкой',
            'postcode.max' => 'Почтовый индекс не может быть больше 20 символов',
            'website.string' => 'Сайт должен быть строкой',
            'website.string' => 'Покупатель с таким сайтом уже существует',
            'website.max' => 'Сайт не может быть больше 255 символов',
            'telegram.string' => 'Телеграм должен быть строкой',
            'telegram.string' => 'Покупатель с таким Telegram уже существует',
            'telegram.max' => 'Телеграм не может быть больше 255 символов',
            'vkontakte.string' => 'Вконтакте должен быть строкой',
            'vkontakte.string' => 'Покупатель с таким id Вконтакте уже существует',
            'vkontakte.max' => 'Вконтакте не может быть больше 255 символов',
            'instagram.string' => 'Инстаграм должен быть строкой',
            'instagram.string' => 'Покупатель с таким id Инстаграм уже существует',
            'instagram.max' => 'Инстаграм не может быть больше 255 символов',
            'whatsapp.string' => 'Whatsapp должен быть строкой',
            'whatsapp.unique' => 'Покупатель с таким Whatsapp уже существует',
            'whatsapp.max' => 'Whatsapp не может быть больше 255 символов',
        ];
    }
}
