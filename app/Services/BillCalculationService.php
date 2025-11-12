<?php

namespace App\Services;

use App\Models\Bill;

class BillCalculationService
{
  public function calculate(Bill $bill): array
  {
    $lines = $bill->lines()->with(['product', 'selectedOptions'])->get();

    if ($lines->isEmpty()) {
      return [
        'subtotal' => 0,
        'discount_amount' => 0,
        'tax_total' => 0,
        'total' => 0,
      ];
    }

    $subtotal = 0;

    foreach ($lines as $line) {
      $lineTotal = $line->quantity * $line->unit_price;

      if ($line->selectedOptions->isNotEmpty()) {
        $optionsTotal = $line->selectedOptions->sum('price');
        $lineTotal += $optionsTotal;
      }

      $subtotal += $lineTotal;
    }

    $discountAmount = 0;
    if ($bill->discount_percentage > 0) {
      $discountAmount = round($subtotal * ($bill->discount_percentage / 100), 2);
    }

    $subtotalAfterDiscount = $subtotal - $discountAmount;

    $company = $bill->company;
    $hasVAT = !empty($company->vat_number) && $company->default_tax_rate > 0;
    $taxTotal = $hasVAT ? round($subtotalAfterDiscount * ($company->default_tax_rate / 100), 2) : 0;

    $total = round($subtotalAfterDiscount + $taxTotal, 2);

    return [
      'subtotal' => round($subtotal, 2),
      'discount_amount' => $discountAmount,
      'tax_total' => $taxTotal,
      'total' => $total,
    ];
  }
}
