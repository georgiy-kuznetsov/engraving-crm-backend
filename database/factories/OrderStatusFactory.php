<?php

namespace Database\Factories;

use App\Models\OrderStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderStatusFactory extends Factory
{
    protected $model = OrderStatus::class;
    public function definition(): array
    {
        $index = fake()->numberBetween(1, 10);
        return [
            'name' => 'Статус ' . $index,
            'description' => fake()->sentence(5),
            'index' => $index,
        ];
    }
}
