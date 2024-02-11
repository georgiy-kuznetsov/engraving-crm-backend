<?php

namespace Database\Seeders\Initial;

use App\Models\Order\PaymentStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderPaymentSatusSeeder extends Seeder
{
    public function run(): void
    {
        PaymentStatus::factory()->state([
            'name' => 'Ожидает оплаты',
            'description' => null,
            'index' => 1,
        ])->create();

        PaymentStatus::factory()->state([
            'name' => 'Внесена предоплата',
            'description' => null,
            'index' => 2,
        ])->create();

        PaymentStatus::factory()->state([
            'name' => 'Оплачен',
            'description' => null,
            'index' => 3,
        ])->create();

        PaymentStatus::factory()->state([
            'name' => 'Ожидает возврата',
            'description' => null,
            'index' => 4,
        ])->create();

        PaymentStatus::factory()->state([
            'name' => 'Средства возвращены',
            'description' => null,
            'index' => 5,
        ])->create();
    }
}
