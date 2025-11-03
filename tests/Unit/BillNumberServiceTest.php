<?php

namespace Tests\Unit\Services;

use App\Models\Bill;
use App\Models\CompanySetting;
use App\Models\Customer;
use Tests\TestCase;
use App\Services\BillNumberService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class BillNumberServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BillNumberService $service;
    protected Customer $customer;
    protected CompanySetting $company;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(BillNumberService::class);
        $this->customer = Customer::factory()->create();
        $this->company = CompanySetting::factory()->create();
    }

    #[Test]
    public function it_respects_the_format_dyyyy_xxxx()
    {
        $number = $this->service->generate('quote');

        $currentYear = now()->year;

        $this->assertMatchesRegularExpression(
            "/^D{$currentYear}-\d{4}$/",
            $number,
            "The generated number does not match the expected format DYYYY-XXXX."
        );
    }

    #[Test]
    public function it_generates_the_first_number_when_no_quote_exists_yet(): void
    {
        $this->assertDatabaseCount('bills', 0);

        $number = $this->service->generate('quote');

        $this->assertEquals("D" . now()->year . "-0001", $number);
    }



    #[Test]
    public function it_increments_the_number_based_on_the_last_existing_quote()
    {
        $this->createQuote('D' . now()->year . '-0001');

        $number = $this->service->generate('quote');

        $this->assertEquals("D" . now()->year . "-0002", $number);
    }

    #[Test]
    public function it_resets_to_0001_when_the_year_changes(): void
    {
        $this->createQuote('D2024-0001');

        $number = $this->service->generate('quote');

        $this->assertEquals("D" . now()->year . "-0001", $number);
    }


    #[Test]
    public function it_does_not_skip_any_number_between_consecutive_generations(): void
    {
        $this->createQuote('D' . now()->year . '-0001');

        $numbers = [];

        for ($i = 0; $i < 3; $i++) {
            $next = $this->service->generate('quote');
            $this->createQuote($next);
            $numbers[] = $next;
        }

        $expected = [
            'D' . now()->year . '-0002',
            'D' . now()->year . '-0003',
            'D' . now()->year . '-0004',
        ];

        $this->assertEquals($expected, $numbers);
    }



    #[Test]
    public function it_keeps_continuity_when_multiple_years_of_quotes_exist(): void
    {
        $this->createQuote('D2024-0002');

        $this->createQuote('D' . now()->year . '-0012');

        $number = $this->service->generate('quote');

        $this->assertEquals("D" . now()->year . "-0013", $number);
    }


    #[Test]
    public function it_never_generates_duplicate_numbers_even_with_concurrent_calls(): void
    {
        $numbers = collect(range(1, 10))
            ->map(function () {
                $next = $this->service->generate('quote');
                $this->createQuote($next);
                return $next;
            })
            ->toArray();

        $this->assertCount(10, $numbers);
        $this->assertCount(10, array_unique($numbers));
    }




    #[Test]
    public function it_pads_the_sequence_number_with_leading_zeros_correctly(): void
    {
        $this->createQuote('D' . now()->year . '-0009');

        $number = $this->service->generate('quote');

        $this->assertEquals("D" . now()->year . "-0010", $number);
    }


    #[Test]
    public function it_returns_the_correct_next_number_even_if_previous_quotes_were_deleted(): void
    {
        for ($i = 1; $i < 5; $i++) {
            $this->createQuote('D' . now()->year . '-000' . $i);
        }

        Bill::where('number', 'D2025-0003')->delete();

        $number = $this->service->generate('quote');

        $this->assertEquals("D" . now()->year . "-0005", $number);
    }

    protected function createQuote(string $number): Bill
    {
        // Extract year
        preg_match('/D(\d{4})-/', $number, $matches);
        $year = $matches[1] ?? now()->year;

        $issueDate = ($year == now()->year)
            ? now()
            : now()->copy()->setDate($year, 6, 15);

        return Bill::create([
            'type' => 'quote',
            'number' => $number,
            'status' => 'draft',
            'subtotal' => 100,
            'tax_total' => 0,
            'total' => 100,
            'issue_date' => $issueDate,
            'customer_id' => $this->customer->id,
            'company_setting_id' => $this->company->id,
        ]);
    }
}
