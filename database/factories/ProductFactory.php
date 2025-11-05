<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => 'Generic Product',
            'description' => $this->faker->sentence(),
            'type' => 'time_unit',
            'base_price' => 100.00,
            'unit' => 'hour',
            'status' => 'active',
        ];
    }

    public function timeUnit(): static
    {
        return $this->state(fn() => [
            'name' => 'Day',
            'description' => 'Full-day service for missions or projects.',
            'type' => 'time_unit',
            'base_price' => 400.00,
            'unit' => 'day',
        ]);
    }

    public function packageEcommerce(): static
    {
        return $this->state(fn() => [
            'name' => 'E-commerce Website',
            'description' => 'Complete online store (Shopify, WooCommerce or Laravel).',
            'type' => 'package',
            'base_price' => 2500.00,
            'unit' => null,
        ])->afterCreating(function (Product $product) {
            $options = [
                'initial_products' => [
                    'name' => 'Initial product count',
                    'type' => 'select',
                    'values' => [
                        ['value' => '10', 'price' => 0, 'is_default' => true],
                        ['value' => '50', 'price' => 200],
                        ['value' => '100', 'price' => 400],
                    ],
                    'pivot' => [
                        'default_value' => '10',
                        'default_price' => 0,
                        'is_default_attached' => true,
                    ],
                ],
                'payment_integration' => [
                    'name' => 'Online payment integration',
                    'type' => 'checkbox',
                    'values' => [
                        ['value' => '1', 'price' => 0],
                        ['value' => '2', 'price' => 50],
                        ['value' => '3', 'price' => 100],
                    ],
                    'pivot' => [
                        'default_value' => '1',
                        'default_price' => 0,
                        'is_default_attached' => true,
                    ],
                ],
                'monthly_maintenance' => [
                    'name' => 'Monthly maintenance',
                    'type' => 'checkbox',
                    'values' => [
                        ['value' => '1', 'price' => 150],
                    ],
                    'pivot' => [
                        'default_value' => '0',
                        'default_price' => 0,
                        'is_default_attached' => false,
                    ],
                ],
            ];

            foreach ($options as $key => $data) {
                $option = ProductOption::firstOrCreate([
                    'name' => $data['name'],
                    'type' => $data['type'],
                ]);

                foreach ($data['values'] as $valueData) {
                    ProductOptionValue::firstOrCreate(
                        [
                            'product_option_id' => $option->id,
                            'value' => $valueData['value'],
                        ],
                        [
                            'price' => $valueData['price'] ?? 0,
                            'is_default' => $valueData['is_default'] ?? false,
                        ]
                    );
                }

                $product->options()->syncWithoutDetaching([
                    $option->id => $data['pivot'],
                ]);
            }
        });
    }
}
