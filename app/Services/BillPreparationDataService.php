<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Product;
use App\Models\CompanySetting;

class BillPreparationDataService
{
  public function prepareData()
  {
    $customers = Customer::all();
    $products = Product::with('options.values')->get();
    $companySettings = CompanySetting::first();

    return [
      'customers' => $customers,
      'products' => $products,
      'prices' => $products->pluck('base_price', 'id'),
      'productOptions' => $this->mapProductOptions($products),
      'hasVAT' => $companySettings && $companySettings->vat_number,
      'vatRate' => $companySettings->default_tax_rate ?? 0,
    ];
  }

  private function mapProductOptions($products)
  {
    return $products->mapWithKeys(function ($product) {
      return [
        $product->id => [
          'type' => $product->type,
          'options' => $product->options->map(function ($option) {
            return [
              'name' => $option->name,
              'values' => $option->values->map(fn($v) => [
                'id' => $v->id,
                'value' => $v->value,
                'price' => $v->price,
                'is_default' => $v->is_default,
              ])->values(),
            ];
          })->values(),
        ],
      ];
    });
  }
}
