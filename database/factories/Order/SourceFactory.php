<?php

namespace Database\Factories\Order;

use Illuminate\Database\Eloquent\Factories\Factory;

class SourceFactory extends Factory
{
    public function definition(): array
    {
        $index = fake()->numberBetween(1, 10);
        return [
            'name' => 'Источник ' . $index,
            'description' => fake()->sentence(5),
            'index' => $index,
        ];
    }
}
