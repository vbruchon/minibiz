<?php

namespace App\Services;

use App\Helpers\ArrayHelper;
use App\Models\Bill;
use App\Models\CompanySetting;
use App\Models\ProductOptionValue;
use Illuminate\Support\Carbon;

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
      'due_date' => $this->resolveDueDate($data),
      'footer_note' => $data['footer_note'] ?? null,
    ]);

    $this->syncLines($bill, $data['lines']);

    $bill->load(['lines.selectedOptions', 'lines.product', 'company']);
    $totals = $this->calcService->calculate($bill);
    $bill->update($totals);

    return $bill;
  }

  public function update(Bill $bill, array $data): Bill
  {
    $bill->update([
      'customer_id' => $data['customer_id'],
      'discount_percentage' => $data['discount_percentage'] ?? 0,
      'due_date' => $this->resolveDueDate($data),
      'footer_note' => $data['footer_note'] ?? null,
    ]);

    $bill->lines()->each(function ($line) {
      $line->selectedOptions()->detach();
      $line->delete();
    });

    $this->syncLines($bill, $data['lines']);

    $bill->load(['lines.selectedOptions', 'lines.product', 'company']);
    $totals = $this->calcService->calculate($bill);
    $bill->update($totals);

    return $bill;
  }

  private function syncLines(Bill $bill, array $lines): void
  {
    foreach ($lines as $lineData) {
      $this->addLine($bill, $lineData);
    }
  }

  private function addLine(Bill $bill, array $lineData): void
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

  private function attachOptions($billLine, array $optionIds, float $lineTotal): void
  {
    $flatIds = ArrayHelper::flattenOptions($optionIds);

    if (empty($flatIds)) {
      return;
    }

    $optionsTotal = ProductOptionValue::whereIn('id', $flatIds)->sum('price');

    $billLine->selectedOptions()->attach($flatIds);

    $billLine->update([
      'total' => $lineTotal + $optionsTotal,
    ]);
  }
  private function resolveDueDate(array $data): Carbon
  {
    if (!isset($data['due_date']) || $data['due_date'] === null) {
      return now()->addDays(30);
    }

    if (is_numeric($data['due_date'])) {
      return now()->addDays((int) $data['due_date']);
    }

    return Carbon::parse($data['due_date']);
  }
}
