<?php

namespace Database\Factories\Order;

use App\Models\Order\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatusFactory extends Factory
{
    protected $model = Status::class;
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
