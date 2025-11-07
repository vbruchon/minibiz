<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\CompanySetting;
use App\Models\ProductOptionValue;
use Illuminate\Support\Carbon;
use App\Services\BillNumberService;
use App\Services\BillCalculationService;

class BillCreatorService
{
  public function __construct(
    protected BillNumberService $numberService,
    protected BillCalculationService $calcService
  ) {}

  public function create(array $data): Bill
  {
    $number = $this->numberService->generate('quote');

    $bill = Bill::create([
      'type' => 'quote',
      'number' => $number,
      'status' => 'draft',
      'customer_id' => $data['customer_id'],
      'company_setting_id' => CompanySetting::first()->id,
      'discount_percentage' => $data['discount_percentage'] ?? 0,
      'issue_date' => now(),
      'due_date' => isset($data['due_date'])
        ? Carbon::parse($data['due_date'])
        : now()->addDays(30),
      'footer_note' => $data['footer_note'] ?? null,
    ]);

    foreach ($data['lines'] as $lineData) {
      $this->addLine($bill, $lineData);
    }

    $bill->load(['lines.selectedOptions', 'lines.product', 'company']);
    $totals = $this->calcService->calculate($bill);
    $bill->update($totals);

    return $bill;
  }

  protected function addLine(Bill $bill, array $lineData): void
  {
    $lineTotal = $lineData['quantity'] * $lineData['unit_price'];

    $billLine = $bill->lines()->create([
      'product_id' => $lineData['product_id'],
      'description' => $lineData['description'] ?? '',
      'quantity' => $lineData['quantity'],
      'unit_price' => $lineData['unit_price'],
      'tax_rate' => $bill->company->default_tax_rate ?? 0,
      'total' => $lineTotal,
    ]);

    if (!empty($lineData['selected_options'])) {
      $this->attachOptions($billLine, $lineData['selected_options'], $lineTotal);
    }
  }

  protected function attachOptions($billLine, array $optionIds, float $lineTotal): void
  {
    $optionsTotal = ProductOptionValue::whereIn('id', $optionIds)->sum('price');

    $billLine->selectedOptions()->attach($optionIds);

    $billLine->update([
      'total' => $lineTotal + $optionsTotal,
    ]);
  }
}
