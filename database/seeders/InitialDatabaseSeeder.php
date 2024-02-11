<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            Initial\UserSeeder::class,
            Initial\OrderStatusSeeder::class,
            Initial\OrderPaymentSatusSeeder::class,
        ]);
    }
}
