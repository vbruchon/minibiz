<?php

namespace Database\Factories;

use App\Models\{BillLine, Product};

use Illuminate\Database\Eloquent\Factories\Factory;

class BillLineFactory extends Factory
{
    protected $model = BillLine::class;

    public function definition(): array
    {
        $product = Product::inRandomOrder()->first() ?? Product::factory()->create();
        $quantity = rand(1, 3);
        $unitPrice = $product->base_price ?? $this->faker->randomFloat(2, 50, 200);
        $taxRate = $this->faker->randomElement([0, 5.5, 10, 20]);
        $total = $quantity * $unitPrice * (1 + $taxRate / 100);

        return [
            'product_id' => $product->id,
            'description' => $product->name,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'tax_rate' => $taxRate,
            'total' => $total,
        ];
    }
}
