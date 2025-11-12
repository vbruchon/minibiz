<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Tests\Support\BillTestHelper;
use App\Models\CompanySetting;
use App\Models\Customer;
use App\Models\Product;
use App\Services\BillCalculationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class BillCalculationServiceTest extends TestCase
{
    use RefreshDatabase;
    use BillTestHelper;

    protected BillCalculationService $service;
    protected Customer $customer;
    protected CompanySetting $company;
    protected Product $productDay;
    protected Product $productEcommerce;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(BillCalculationService::class);
        $this->customer = Customer::factory()->create();
        $this->company = CompanySetting::factory()->create();
        $this->productDay = Product::factory()->timeUnit()->create();
        $this->productEcommerce = Product::factory()->packageEcommerce()->create();
    }

    #[Test]
    public function it_returns_zero_when_no_lines_are_present(): void
    {
        $bill = $this->createQuote('D' . now()->year . '-0001', $this->customer, $this->company);

        $result = $this->service->calculate($bill);

        $this->assertEquals(0, $result['subtotal']);
        $this->assertEquals(0, $result['tax_total']);
        $this->assertEquals(0, $result['total']);
    }



    #[Test]
    public function it_calculates_subtotal_from_bill_lines_with_a_one_simple_product(): void
    {
        $bill = $this->createQuoteWithProducts('D' . now()->year . '-0001', [$this->productDay]);

        $result = $this->service->calculate($bill);

        $this->assertEquals(400, $result['subtotal']);
    }

    #[Test]
    public function it_calculates_subtotal_from_bill_lines_with_multiple_simple_products(): void
    {
        $products = [$this->productDay, $this->productDay, $this->productDay];
        $bill = $this->createQuoteWithProducts('D' . now()->year . '-0002', $products);

        $result = $this->service->calculate($bill);

        $this->assertEquals(1200, $result['subtotal']);
    }

    #[Test]
    public function it_calculates_subtotal_from_package_product_with_default_options(): void
    {
        $bill = $this->createQuoteWithProducts('D' . now()->year . '-0003', [$this->productEcommerce]);

        $result = $this->service->calculate($bill);

        $this->assertEquals(2500, $result['subtotal']);
    }

    #[Test]
    public function it_calculates_subtotal_with_package_product_and_paid_options(): void
    {
        $optionValues = $this->productEcommerce->options()->with('values')->get();
        $paidOptionValues = [];

        foreach ($optionValues as $option) {
            if ($option->name === 'Initial product count') {
                $paidOptionValues[] = $option->values->firstWhere('value', '100');
            }
            if ($option->name === 'Online payment integration') {
                $paidOptionValues[] = $option->values->firstWhere('value', '3');
            }
        }

        $bill = $this->createQuoteWithProducts('D' . now()->year . '-0004', [$this->productEcommerce]);

        $billLine = $bill->lines()->first();

        // ✅ On attache les options payantes à la ligne de facture
        foreach ($paidOptionValues as $value) {
            $billLine->selectedOptions()->attach($value->id);
        }

        $result = $this->service->calculate($bill);

        $optionTotal = collect($paidOptionValues)->sum('price');
        $expectedSubtotal = $this->productEcommerce->base_price + $optionTotal;

        $this->assertEquals($expectedSubtotal, $result['subtotal']);
    }


    #[Test]
    public function it_calculates_subtotal_from_package_and_simple_products(): void
    {
        $bill = $this->createQuoteWithProducts('D' . now()->year . '-0005', [$this->productEcommerce, $this->productDay]);

        $result = $this->service->calculate($bill);

        $this->assertEquals(2900, $result['subtotal']);
    }

    #[Test]
    public function it_calculates_totals_with_zero_quantity_lines(): void
    {
        $bill = $this->createQuoteWithProducts('D' . now()->year . '-0006', [$this->productDay, $this->productDay]);

        $bill->lines()->first()->update(['quantity' => 0]);

        $result = $this->service->calculate($bill);

        $this->assertEquals(400, $result['subtotal']);
    }


    #[Test]
    public function it_applies_tax_correctly_when_vat_is_enabled(): void
    {
        $bill = $this->createQuoteWithProducts('D' . now()->year . '-0007', [$this->productDay]);

        $result = $this->service->calculate($bill);
        $expectedTax = $result['subtotal'] * ($this->company->default_tax_rate / 100);

        $this->assertEquals($expectedTax, $result['tax_total']);
    }

    #[Test]
    public function it_does_not_apply_tax_when_vat_is_disabled(): void
    {
        $this->company->update(['vat_number' => 0, 'default_tax_rate' => 0]);

        $bill = $this->createQuoteWithProducts('D' . now()->year . '-0008', [$this->productDay]);

        $result = $this->service->calculate($bill);

        $this->assertEquals(0, $result['tax_total']);
        $this->assertEquals($result['subtotal'], $result['total']);
    }

    #[Test]
    public function it_calculates_grand_total_as_subtotal_plus_tax(): void
    {
        $this->company->update(['default_tax_rate' => 20]);

        $bill = $this->createQuoteWithProducts('D' . now()->year . '-0009', [$this->productDay]);

        $result = $this->service->calculate($bill);

        $expectedTax = round($result['subtotal'] * 0.20, 2);
        $expectedTotal = round($result['subtotal'] + $expectedTax, 2);

        $this->assertEquals($expectedTax, $result['tax_total']);
        $this->assertEquals($expectedTotal, $result['total']);
    }


    #[Test]
    public function it_applies_global_discount_correctly(): void
    {
        $bill = $this->createQuoteWithProducts('D' . now()->year . '-0010', [$this->productDay]);
        $bill->update(['discount_percentage' => 10]);

        $result = $this->service->calculate($bill);

        $expectedSubtotal = 400;
        $expectedDiscount = $expectedSubtotal * 0.10;
        $expectedTax = ($expectedSubtotal - $expectedDiscount) * ($this->company->default_tax_rate / 100);
        $expectedTotal = ($expectedSubtotal - $expectedDiscount) + $expectedTax;

        $this->assertEquals(round($expectedSubtotal, 2), $result['subtotal']);
        $this->assertEquals(round($expectedDiscount, 2), $result['discount_amount']);
        $this->assertEquals(round($expectedTax, 2), $result['tax_total']);
        $this->assertEquals(round($expectedTotal, 2), $result['total']);
    }


    #[Test]
    public function it_applies_discount_and_tax_on_package_product_combination(): void
    {
        $this->company->update(['default_tax_rate' => 20]);

        $bill = $this->createQuoteWithProducts('D' . now()->year . '-0011', [$this->productEcommerce, $this->productDay]);
        $bill->update(['discount_percentage' => 10]);

        $result = $this->service->calculate($bill);

        $expectedSubtotal = 2900;
        $expectedDiscount = $expectedSubtotal * 0.10;
        $expectedTax = ($expectedSubtotal - $expectedDiscount) * 0.20;
        $expectedTotal = ($expectedSubtotal - $expectedDiscount) + $expectedTax;

        $this->assertEquals(round($expectedSubtotal, 2), $result['subtotal']);
        $this->assertEquals(round($expectedDiscount, 2), $result['discount_amount']);
        $this->assertEquals(round($expectedTax, 2), $result['tax_total']);
        $this->assertEquals(round($expectedTotal, 2), $result['total']);
    }



    #[Test]
    public function it_rounds_totals_to_two_decimals(): void
    {
        $bill = $this->createQuote('D' . now()->year . '-0012', $this->customer, $this->company);

        $bill->lines()->createMany([
            ['description' => 'Service 1', 'quantity' => 1, 'unit_price' => 19.995, 'tax_rate' => 20, 'total' => 19.995],
            ['description' => 'Service 2', 'quantity' => 2, 'unit_price' => 33.333, 'tax_rate' => 20, 'total' => 66.666],
        ]);

        $result = $this->service->calculate($bill);

        $this->assertEquals(round($result['subtotal'], 2), $result['subtotal']);
        $this->assertEquals(round($result['tax_total'], 2), $result['tax_total']);
        $this->assertEquals(round($result['total'], 2), $result['total']);
    }

    #[Test]
    public function it_does_not_mutate_original_bill_data_during_calculation(): void
    {
        $bill = $this->createQuoteWithProducts('D' . now()->year . '-0013', [$this->productDay]);
        $bill->update([
            'subtotal' => 999.99,
            'tax_total' => 99.99,
            'total' => 1099.98,
        ]);

        $originalData = $bill->only(['subtotal', 'tax_total', 'total']);

        $this->service->calculate($bill);
        $bill->refresh();

        $this->assertEquals($originalData['subtotal'], $bill->subtotal);
        $this->assertEquals($originalData['tax_total'], $bill->tax_total);
        $this->assertEquals($originalData['total'], $bill->total);
    }
}
