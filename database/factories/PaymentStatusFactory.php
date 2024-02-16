<?php

namespace Database\Factories;

use App\Models\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentStatusFactory extends Factory
{
    protected $model = PaymentStatus::class;

    public function definition(): array
    {
        $index = fake()->numberBetween(1, 10);
        return [
            'name' => 'Статус оплаты ' . $index,
            'description' => fake()->sentence(5),
            'index' => $index,
        ];
    }
}
