<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderSourceFactory extends Factory
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
