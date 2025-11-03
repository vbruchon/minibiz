<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductOption;
use App\Models\ProductOptionValue;

class ProductOptionsSeeder extends Seeder
{
  public function run(): void
  {
    $packages = Product::where('type', 'package')->get();

    if ($packages->isEmpty()) {
      return;
    }

    $sharedOptions = [
      [
        'name' => 'Hébergement',
        'type' => 'select',
        'values' => [
          ['value' => 'Basique (1 Go)', 'price' => 0],
          ['value' => 'Pro (10 Go)', 'price' => 50],
          ['value' => 'Premium (Illimité)', 'price' => 100],
        ],
      ],
      [
        'name' => 'Maintenance annuelle',
        'type' => 'select',
        'values' => [
          ['value' => 'Aucune', 'price' => 0],
          ['value' => 'Standard', 'price' => 120],
          ['value' => 'Premium', 'price' => 240],
        ],
      ],
      [
        'name' => 'Support technique',
        'type' => 'select',
        'values' => [
          ['value' => 'Email uniquement', 'price' => 0],
          ['value' => 'Email + Téléphone', 'price' => 60],
          ['value' => '24/7 Prioritaire', 'price' => 150],
        ],
      ],
    ];

    $vitrineOptions = [
      [
        'name' => 'Nombre de pages',
        'type' => 'select',
        'values' => [
          ['value' => '3 pages', 'price' => 0],
          ['value' => '5 pages', 'price' => 100],
          ['value' => '10 pages', 'price' => 200],
        ],
      ],
      [
        'name' => 'Optimisation SEO',
        'type' => 'select',
        'values' => [
          ['value' => 'Basique', 'price' => 0],
          ['value' => 'Avancée', 'price' => 150],
        ],
      ],
      [
        'name' => 'Design personnalisé',
        'type' => 'select',
        'values' => [
          ['value' => 'Standard', 'price' => 0],
          ['value' => 'Sur mesure', 'price' => 250],
        ],
      ],
    ];

    $ecommerceOptions = [
      [
        'name' => 'Nombre de produits',
        'type' => 'select',
        'values' => [
          ['value' => '50 produits', 'price' => 0],
          ['value' => '100 produits', 'price' => 200],
          ['value' => '500 produits', 'price' => 500],
        ],
      ],
      [
        'name' => 'Système de paiement',
        'type' => 'select',
        'values' => [
          ['value' => 'Stripe', 'price' => 0],
          ['value' => 'Stripe + PayPal', 'price' => 80],
          ['value' => 'Multi-paiements', 'price' => 150],
        ],
      ],
      [
        'name' => 'Livraison',
        'type' => 'select',
        'values' => [
          ['value' => 'Click & Collect', 'price' => 0],
          ['value' => 'Colissimo', 'price' => 50],
          ['value' => 'Colissimo + Mondial Relay', 'price' => 90],
        ],
      ],
    ];

    foreach ($packages as $product) {
      $optionsSet = collect($sharedOptions);

      if (str_contains(strtolower($product->name), 'vitrine')) {
        $optionsSet = $optionsSet->merge($vitrineOptions);
      }

      if (str_contains(strtolower($product->name), 'commerce') || str_contains(strtolower($product->name), 'e-commerce')) {
        $optionsSet = $optionsSet->merge($ecommerceOptions);
      }

      foreach ($optionsSet as $optData) {
        $option = ProductOption::firstOrCreate([
          'name' => $optData['name'],
          'type' => $optData['type'],
        ]);

        foreach ($optData['values'] as $val) {
          ProductOptionValue::firstOrCreate([
            'product_option_id' => $option->id,
            'value' => $val['value'],
            'price' => $val['price'],
          ]);
        }

        $pivotData = [];

        if (in_array($option->type, ['text', 'number'])) {
          $pivotData = [
            'default_value' => $option->values->first()->value ?? null,
            'default_price' => $option->values->first()->price ?? 0,
            'is_default_attached' => true,
          ];
        } else {
          $pivotData = [
            'default_value' => null,
            'default_price' => 0,
            'is_default_attached' => false,
          ];
        }

        $product->options()->syncWithoutDetaching([
          $option->id => $pivotData,
        ]);
      }
    }
  }
}
