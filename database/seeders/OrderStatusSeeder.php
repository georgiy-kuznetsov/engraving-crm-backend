<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('order_statuses')->insert([
            'name' => 'Новый',
            'description' => 'Заказ создан и ожидает обработки',
            'index' => 0,
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Ожидает обработки',
            'description' => 'Заказ подтвержден и ожидает обработки',
            'index' => 1,
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Ожидает предоплаты',
            'description' => 'Заказ обработан, ожидается поступление предоплаты',
            'index' => 2,
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Предоплачен',
            'description' => 'Внесена предоплата, ожидает изготовления',
            'index' => 3,
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Изготовлен',
            'description' => 'Заказ изготовлен',
            'index' => 4,
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Оплачен',
            'description' => 'Заказ оплачен',
            'index' => 5,
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Ожидает отправки',
            'description' => 'Заказ готов, ожидает отправки в соответствии с выбранным методом доставки',
            'index' => 6,
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Отпавлен',
            'description' => 'Заказ отправлен, ожидает получения',
            'index' => 7,
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Доставлен',
            'description' => 'Заказ доставлен покупателю',
            'index' => 8,
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Согласование возврата',
            'description' => 'Покупатель обратился за возвратом, ожидается согласование',
            'index' => 9,
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Ожидает возврата',
            'description' => 'Возврат заказа согласован, ожидается отправка покупателем',
            'index' => 9,
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Возвращен',
            'description' => 'Заказ возвращен',
            'index' => 10,
        ]);

        DB::table('order_statuses')->insert([
            'name' => 'Отменен',
            'description' => 'Заказ Отменен',
            'index' => 11,
        ]);
    }
}
