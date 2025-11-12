<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Customer;
use App\Models\Product;
use App\Models\CompanySetting;
use App\Enums\PaymentTermsEnum;
use App\Enums\InterestRateEnum;

class BillPreparationDataService
{
  public function prepareData(?Bill $bill = null)
  {
    $customers = Customer::all();
    $products = Product::with('options.values')->get();
    $companySettings = CompanySetting::first();

    if ($bill) {
      $bill->load('lines.selectedOptions');

      $bill->formatted_lines = $bill->lines->map(function ($line) {
        return [
          'id' => $line->id,
          'product_id' => $line->product_id,
          'quantity' => $line->quantity,
          'unit_price' => $line->unit_price,
          'selected_options' => $line->selectedOptions->pluck('id'),
        ];
      })->values();
    }

    return [
      'customers' => $customers,
      'products' => $products,
      'prices' => $products->pluck('base_price', 'id'),
      'productOptions' => $this->mapProductOptions($products),

      'hasVAT' => $companySettings && $companySettings->vat_number,
      'vatRate' => $companySettings->default_tax_rate ?? 0,

      'paymentTermsOptions' => PaymentTermsEnum::cases(),
      'interestRateOptions' => InterestRateEnum::cases(),
      'defaultPaymentTerms' => $companySettings->default_payment_terms ?? PaymentTermsEnum::UPON_RECEIPT->value,
      'defaultInterestRate' => $companySettings->default_interest_rate ?? InterestRateEnum::FIVE->value,

      'bill' => $bill,
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
