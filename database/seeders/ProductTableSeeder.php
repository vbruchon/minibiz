<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;

class ProductTableSeeder extends Seeder
{
    public function run(): void
    {
        // --------------------------
        // 1️⃣ Create products
        // --------------------------
        $products = [
            'hour' => [
                'name' => 'Hour',
                'description' => 'Hourly service for short interventions or missions.',
                'type' => 'time_unit',
                'base_price' => 50.00,
                'unit' => 'hour',
                'status' => 'active',
            ],
            'day' => [
                'name' => 'Day',
                'description' => 'Full-day service for longer missions or projects.',
                'type' => 'time_unit',
                'base_price' => 400.00,
                'unit' => 'day',
                'status' => 'active',
            ],
            'vitrine' => [
                'name' => 'Website Showcase',
                'description' => 'Modern, responsive showcase website optimized for SEO and conversions.',
                'type' => 'package',
                'base_price' => 800.00,
                'unit' => null,
                'status' => 'active',
            ],
            'ecommerce' => [
                'name' => 'E-commerce Website',
                'description' => 'Complete online store development (Shopify, WooCommerce or Laravel).',
                'type' => 'package',
                'base_price' => 2500.00,
                'unit' => null,
                'status' => 'active',
            ],
        ];

        $createdProducts = [];
        foreach ($products as $slug => $data) {
            $createdProducts[$slug] = Product::create($data);
        }

        // --------------------------
        // 2️⃣ Define reusable options
        // --------------------------
        $options = [
            'pages' => [
                'name' => 'Number of pages',
                'type' => 'select',
                'values' => [
                    ['value' => '3', 'price' => 0, 'is_default' => true],
                    ['value' => '5', 'price' => 100],
                    ['value' => '8', 'price' => 250],
                ],
            ],
            'custom_design' => [
                'name' => 'Custom design',
                'type' => 'checkbox',
                'values' => [
                    ['value' => '1', 'price' => 200],
                ],
            ],
            'express_delivery' => [
                'name' => 'Express delivery',
                'type' => 'checkbox',
                'values' => [
                    ['value' => '1', 'price' => 150],
                ],
            ],
            'initial_products' => [
                'name' => 'Initial product count',
                'type' => 'select',
                'values' => [
                    ['value' => '10', 'price' => 0, 'is_default' => true],
                    ['value' => '50', 'price' => 200],
                    ['value' => '100', 'price' => 400],
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
            ],
            'monthly_maintenance' => [
                'name' => 'Monthly maintenance',
                'type' => 'checkbox',
                'values' => [
                    ['value' => '1', 'price' => 150],
                ],
            ],
        ];

        // --------------------------
        // 3️⃣ Helper to attach options to product
        // --------------------------
        $addOptionToProduct = function (Product $product, string $optionKey, array $pivot) use ($options) {
            $optionData = $options[$optionKey];

            $option = ProductOption::firstOrCreate([
                'name' => $optionData['name'],
                'type' => $optionData['type'],
            ]);

            if (!empty($optionData['values'])) {
                foreach ($optionData['values'] as $valueData) {
                    ProductOptionValue::firstOrCreate(
                        ['product_option_id' => $option->id, 'value' => $valueData['value']],
                        ['price' => $valueData['price'] ?? 0, 'is_default' => $valueData['is_default'] ?? false]
                    );
                }
            }

            $product->options()->syncWithoutDetaching([
                $option->id => $pivot
            ]);
        };

        // --------------------------
        // 4️⃣ Attach options to products
        // --------------------------

        // Website Showcase
        $addOptionToProduct($createdProducts['vitrine'], 'pages', [
            'default_value' => '3',
            'default_price' => 0,
            'is_default_attached' => true
        ]);
        $addOptionToProduct($createdProducts['vitrine'], 'custom_design', [
            'default_value' => '0',
            'default_price' => 0,
            'is_default_attached' => true
        ]);
        $addOptionToProduct($createdProducts['vitrine'], 'express_delivery', [
            'default_value' => '0',
            'default_price' => 0,
            'is_default_attached' => false
        ]);

        // E-commerce Website
        $addOptionToProduct($createdProducts['ecommerce'], 'initial_products', [
            'default_value' => '10',
            'default_price' => 0,
            'is_default_attached' => true
        ]);
        $addOptionToProduct($createdProducts['ecommerce'], 'payment_integration', [
            'default_value' => '1',
            'default_price' => 0,
            'is_default_attached' => true
        ]);
        $addOptionToProduct($createdProducts['ecommerce'], 'monthly_maintenance', [
            'default_value' => '0',
            'default_price' => 0,
            'is_default_attached' => false
        ]);
    }
}
