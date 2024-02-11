<?php

namespace Database\Seeders\Initial;

use App\Models\Order\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        Status::factory()->state([
            'name' => 'Создан',
            'description' => null,
            'index' => 1,
        ])->create();
        
        Status::factory()->state([
            'name' => 'В обработке',
            'description' => null,
            'index' => 2,
        ])->create();

        Status::factory()->state([
            'name' => 'Эскиз согласован',
            'description' => null,
            'index' => 3,
        ])->create();

        Status::factory()->state([
            'name' => 'Изготовлен',
            'description' => null,
            'index' => 4,
        ])->create();

        Status::factory()->state([
            'name' => 'Собран',
            'description' => null,
            'index' => 5,
        ])->create();

        Status::factory()->state([
            'name' => 'Передан в доставку',
            'description' => null,
            'index' => 6,
        ])->create();

        Status::factory()->state([
            'name' => 'Отправлен',
            'description' => null,
            'index' => 7,
        ])->create();

        Status::factory()->state([
            'name' => 'Доставлен',
            'description' => null,
            'index' => 8,
        ])->create();

        Status::factory()->state([
            'name' => 'Претензия',
            'description' => null,
            'index' => 9,
        ])->create();

        Status::factory()->state([
            'name' => 'Отменен',
            'description' => null,
            'index' => 10,
        ])->create();

        Status::factory()->state([
            'name' => 'Возвращен',
            'description' => null,
            'index' => 11,
        ])->create();
    }
}
