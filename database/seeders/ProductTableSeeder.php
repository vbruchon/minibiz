<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductOption;

class ProductTableSeeder extends Seeder
{
    public function run(): void
    {
        // --------------------------
        // 1️⃣ Produit : Heure
        // --------------------------
        $hour = Product::create([
            'name' => 'Heure',
            'description' => 'Prestation à l’heure pour interventions ponctuelles ou missions courtes.',
            'type' => 'time_unit',
            'base_price' => 50.00,
            'unit' => 'hour',
            'status' => 'active',
        ]);

        // --------------------------
        // 2️⃣ Produit : Journée
        // --------------------------
        $day = Product::create([
            'name' => 'Journée',
            'description' => 'Prestation à la journée pour missions ou projets plus conséquents.',
            'type' => 'time_unit',
            'base_price' => 400.00,
            'unit' => 'day',
            'status' => 'active',
        ]);

        // --------------------------
        // 3️⃣ Produit : Site vitrine
        // --------------------------
        $vitrine = Product::create([
            'name' => 'Site vitrine',
            'description' => 'Création d’un site vitrine moderne et responsive, optimisé pour le SEO et les conversions.',
            'type' => 'package',
            'base_price' => 800.00,
            'unit' => null,
            'status' => 'active',
        ]);

        // Options pour le site vitrine
        ProductOption::insert([
            [
                'product_id' => $vitrine->id,
                'name' => 'Nombre de pages',
                'type' => 'number',
                'default_value' => '3',
                'default_price' => 0,
                'values' => json_encode([
                    ['value' => '3', 'price' => 0],
                    ['value' => '5', 'price' => 100],
                    ['value' => '8', 'price' => 250],
                ]),
            ],
            [
                'product_id' => $vitrine->id,
                'name' => 'Design personnalisé',
                'type' => 'checkbox',
                'default_value' => '0',
                'default_price' => 0,
                'values' => json_encode([
                    ['value' => '1', 'label' => 'Oui', 'price' => 200],
                ]),
            ],
            [
                'product_id' => $vitrine->id,
                'name' => 'Livraison express',
                'type' => 'checkbox',
                'default_value' => '0',
                'default_price' => 0,
                'values' => json_encode([
                    ['value' => '1', 'label' => 'Oui', 'price' => 150],
                ]),
            ],
        ]);

        // --------------------------
        // 4️⃣ Produit : Site e-commerce
        // --------------------------
        $ecommerce = Product::create([
            'name' => 'Site e-commerce',
            'description' => 'Développement complet d’une boutique en ligne (Shopify, WooCommerce ou Laravel).',
            'type' => 'package',
            'base_price' => 2500.00,
            'unit' => null,
            'status' => 'active',
        ]);

        // Options pour le e-commerce
        ProductOption::insert([
            [
                'product_id' => $ecommerce->id,
                'name' => 'Nombre de produits initiaux',
                'type' => 'select',
                'default_value' => '10',
                'default_price' => 0,
                'values' => json_encode([
                    ['value' => '10', 'label' => '10 produits', 'price' => 0],
                    ['value' => '50', 'label' => '50 produits', 'price' => 200],
                    ['value' => '100', 'label' => '100 produits', 'price' => 400],
                ]),
            ],
            [
                'product_id' => $ecommerce->id,
                'name' => 'Intégration de paiement en ligne',
                'type' => 'checkbox',
                'default_value' => '1',
                'default_price' => 0,
                'values' => json_encode([
                    ['value' => '1', 'label' => 'Stripe', 'price' => 0],
                    ['value' => '2', 'label' => 'PayPal', 'price' => 50],
                    ['value' => '3', 'label' => 'Autre', 'price' => 100],
                ]),
            ],
            [
                'product_id' => $ecommerce->id,
                'name' => 'Maintenance mensuelle',
                'type' => 'checkbox',
                'default_value' => '0',
                'default_price' => 0,
                'values' => json_encode([
                    ['value' => '1', 'label' => 'Oui', 'price' => 150],
                ]),
            ],
        ]);
    }
}
