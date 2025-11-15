<?php

namespace App\Services;

use App\Enums\BillStatus;
use App\Enums\PaymentTermsEnum;
use App\Helpers\ArrayHelper;
use App\Models\Bill;
use App\Models\CompanySetting;
use App\Models\ProductOptionValue;
use Illuminate\Support\Carbon;

class BillLifecycleService
{
  public function __construct(
    protected BillNumberService $numberService,
    protected BillCalculationService $calcService
  ) {}

  public function create(array $data, string $type = 'quote'): Bill
  {
    $number = $this->numberService->generate($type);

    $bill = Bill::create([
      'type' => $type,
      'number' => $number,
      'status' => BillStatus::Draft,

      'customer_id' => $data['customer_id'],
      'company_setting_id' => CompanySetting::first()->id,

      'discount_percentage' => $data['discount_percentage'] ?? 0,
      'issue_date' => now(),
      'due_date' => $this->resolveDueDate($data),

      'footer_note' => $data['footer_note'] ?? null,
      'payment_terms' => $data['payment_terms'] ?? null,
      'interest_rate' => $data['interest_rate'] ?? 0,

      'payment_method' =>
      $type === 'invoice'
        ? ($data['payment_method'] ?? null)
        : null,
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
      'payment_terms' => $data['payment_terms'] ?? null,
      'interest_rate' => $data['interest_rate'] ?? 0,
    ]);

    $bill->lines()->each(function ($line) {
      $line->selectedOptions()->detach();
      $line->delete();
    });

    $this->syncLines($bill, $data['lines']);

    $bill->load(['lines.selectedOptions', 'lines.product', 'company']);
    $totals = $this->calcService->calculate($bill);
    $bill->update($totals);

    if ($bill->type === 'invoice') {
      $bill->update([
        'payment_method' => $data['payment_method'] ?? $bill->payment_method,
        'payment_details' => null,
      ]);
    }

    return $bill;
  }

  public function convert(Bill $quote, string $paymentMethod, ?string $note = null): Bill
  {
    $quote->update(['status' => BillStatus::Accepted]);

    $company = $quote->company;

    $paymentDetails = null;
    if ($paymentMethod === 'bank_transfer') {
      $paymentDetails = [
        'iban' => $company->bank_iban,
        'bic'  => $company->bank_bic,
      ];
    }

    $issueDate = now();
    $dueDate = $this->resolveDueDateFromTerms($quote->payment_terms, $issueDate);

    $invoice = Bill::create([
      'type' => 'invoice',
      'number' => $this->numberService->generate("invoice"),
      'status' => BillStatus::Sent,
      'customer_id' => $quote->customer_id,
      'company_setting_id' => $quote->company_setting_id,

      'issue_date' => $issueDate,
      'due_date' => $dueDate,

      'payment_terms' => $quote->payment_terms,
      'interest_rate' => $quote->interest_rate,
      'discount_percentage' => $quote->discount_percentage,
      'discount_amount' => $quote->discount_amount,

      'subtotal' => $quote->subtotal,
      'tax_total' => $quote->tax_total,
      'total' => $quote->total,

      'payment_method' => $paymentMethod,
      'payment_details' => $paymentDetails,

      'footer_note' => $quote->footer_note,
      'notes' => $note ?? $quote->notes,

      'converted_from_id' => $quote->id,
    ]);

    $quote->load('lines.selectedOptions');

    foreach ($quote->lines as $line) {
      $newLine = $invoice->lines()->create([
        'product_id' => $line->product_id,
        'description' => $line->description,
        'quantity' => $line->quantity,
        'unit_price' => $line->unit_price,
        'tax_rate' => $line->tax_rate,
        'total' => $line->total,
      ]);

      $newLine->selectedOptions()->sync(
        $line->selectedOptions->pluck('id')->toArray()
      );
    }

    return $invoice;
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

  public function resolveDueDateFromTerms(string $paymentTerms, Carbon $issueDate): Carbon
  {
    return match ($paymentTerms) {
      PaymentTermsEnum::UPON_RECEIPT->value =>
      $issueDate,

      PaymentTermsEnum::NET_15->value =>
      $issueDate->clone()->addDays(15),

      PaymentTermsEnum::NET_30->value =>
      $issueDate->clone()->addDays(30),

      PaymentTermsEnum::END_OF_MONTH_30->value =>
      $issueDate->clone()->endOfMonth()->addDays(30),

      PaymentTermsEnum::END_OF_MONTH_45->value =>
      $issueDate->clone()->endOfMonth()->addDays(45),

      default => $issueDate->clone()->addDays(30), // fallback
    };
  }
}
