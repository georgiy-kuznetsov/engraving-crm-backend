<?php

namespace Database\Factories\Order;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingMethodFactory extends Factory
{
    public function definition(): array
    {
        $index = fake()->numberBetween(1, 10);
        return [
            'name' => 'Способ доставки ' . $index,
            'description' => fake()->sentence(5),
            'index' => $index,
        ];
    }
}
