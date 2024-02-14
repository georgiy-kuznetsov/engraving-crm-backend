<?php

namespace Database\Seeders\Initial;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderPaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        PaymentMethod::factory()->state([
            'name' => 'Безналичная оплата',
            'description' => null,
            'index' => 1,
        ])->create();

        PaymentMethod::factory()->state([
            'name' => 'Наличные',
            'description' => null,
            'index' => 2,
        ])->create();

        PaymentMethod::factory()->state([
            'name' => 'Смешанная оплата',
            'description' => null,
            'index' => 3,
        ])->create();

        PaymentMethod::factory()->state([
            'name' => 'Подарочный сертификат',
            'description' => null,
            'index' => 4,
        ])->create();
    }
}
