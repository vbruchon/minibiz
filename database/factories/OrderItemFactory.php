<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = \App\Models\OrderItem::class;

    public function definition(): array
    {
        return [
            'quantity' => $this->faker->numberBetween(1, 3),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'subtotal' => 0,
        ];
    }
}
