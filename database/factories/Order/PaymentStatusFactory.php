<?php

namespace Database\Factories\Order;

use App\Models\Order\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
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
