<?php

namespace App\Services;

use App\Models\Bill;

class BillCalculationService
{
  public function calculate(Bill $bill): array
  {
    $lines = $bill->lines;
    if ($lines->isEmpty()) {
      return [
        'subtotal' => 0,
        'tax_total' => 0,
        'total' => 0,
      ];
    }

    $subtotal = 0;

    foreach ($lines as $line) {
      $product = $line->product;
      $lineTotal = $line->quantity * $line->unit_price;

      if ($product && $product->type === 'package' && $line->selectedOptions->isNotEmpty()) {
        $optionsTotal = $line->selectedOptions->sum('price');
        $lineTotal += $optionsTotal;
      }

      $subtotal += $lineTotal;
    }

    $discount = $bill->discount_percentage ?? 0;

    if ($discount > 0) {
      $subtotal -= $subtotal * ($discount / 100);
    }

    $company = $bill->company;
    $hasVAT = !empty($company->vat_number) && $company->default_tax_rate > 0;

    $taxTotal = $hasVAT
      ? round($subtotal * ($company->default_tax_rate / 100), 2)
      : 0;

    $total = round($subtotal + $taxTotal, 2);

    $discount = $bill->discount_percentage ?? 0;

    return [
      'subtotal' => round($subtotal, 2),
      'tax_total' => $taxTotal,
      'total' => $total,
    ];
  }
}
