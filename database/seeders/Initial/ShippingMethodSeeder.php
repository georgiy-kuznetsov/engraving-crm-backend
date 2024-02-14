<?php

namespace Database\Seeders\Initial;

use App\Models\ShippingMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingMethodSeeder extends Seeder
{
    public function run(): void
    {
        ShippingMethod::factory()->state([
            'name' => 'Почта России',
            'description' => null,
            'index' => 1,
        ])->create();
        
        ShippingMethod::factory()->state([
            'name' => 'СДЭК',
            'description' => null,
            'index' => 2,
        ])->create();

        ShippingMethod::factory()->state([
            'name' => 'Самовывоз',
            'description' => null,
            'index' => 3,
        ])->create();

        ShippingMethod::factory()->state([
            'name' => 'Яндекс.Доставка',
            'description' => null,
            'index' => 4,
        ])->create();

        ShippingMethod::factory()->state([
            'name' => 'Авито',
            'description' => null,
            'index' => 5,
        ])->create();
    }
}
