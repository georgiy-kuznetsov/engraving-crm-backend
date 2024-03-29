<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            Initial\RoleSeeder::class,
            Initial\UserSeeder::class,
            Initial\OrderStatusSeeder::class,
            Initial\OrderPaymentSatusSeeder::class,
            Initial\OrderSourceSeeder::class,
            Initial\ShippingMethodSeeder::class,
            Initial\OrderPaymentMethodSeeder::class,
        ]);
    }
}
