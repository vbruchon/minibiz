<?php

namespace Tests\Support;

use App\Models\Bill;
use App\Models\BillLine;
use App\Models\Product;
use App\Models\Customer;
use App\Models\CompanySetting;

trait BillTestHelper
{
  /**
   * Crée un devis simple sans lignes
   */
  protected function createQuote(string $number, ?Customer $customer = null, ?CompanySetting $company = null): Bill
  {
    $customer = $customer ?? $this->customer;
    $company  = $company  ?? $this->company;

    preg_match('/D(\d{4})-/', $number, $matches);
    $year = $matches[1] ?? now()->year;

    $issueDate = ($year == now()->year)
      ? now()
      : now()->copy()->setDate($year, 6, 15);

    return Bill::create([
      'type' => 'quote',
      'number' => $number,
      'status' => 'draft',
      'subtotal' => 0,
      'tax_total' => 0,
      'total' => 0,
      'issue_date' => $issueDate,
      'customer_id' => $customer->id,
      'company_setting_id' => $company->id,
    ]);
  }

  /**
   * Create quote with one or more products 
   *
   * @param string $number
   * @param array<Product> $products Liste de produits à attacher (facultatif)
   * @param Customer|null $customer
   * @param CompanySetting|null $company
   */
  protected function createQuoteWithProducts(
    string $number,
    array $products = [],
    ?Customer $customer = null,
    ?CompanySetting $company = null
  ): Bill {
    $bill = $this->createQuote($number, $customer, $company);

    if (empty($products)) {
      $products = [
        Product::factory()->timeUnit()->create(),
      ];
    }

    foreach ($products as $product) {
      $unitPrice = $product->base_price ?? 100;

      BillLine::create([
        'bill_id' => $bill->id,
        'product_id' => $product->id,
        'description' => $product->name,
        'quantity' => 1,
        'unit_price' => $unitPrice,
        'tax_rate' => 20,
        'total' => $unitPrice,
      ]);
    }

    $bill->subtotal = $bill->lines()->sum('total');
    $bill->tax_total = round($bill->subtotal * 0.2, 2);
    $bill->total = $bill->subtotal + $bill->tax_total;
    $bill->save();

    return $bill;
  }
}
