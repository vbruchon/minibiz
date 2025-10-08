<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Services\CustomerSearchFilterService;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerSearchFilterServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CustomerSearchFilterService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CustomerSearchFilterService();
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_all_customers_when_no_filter_or_search()
    {
        Customer::factory()->count(5)->create();

        $request = new Request();
        $result = $this->service->handle($request);

        $this->assertCount(5, $result->items());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_empty_when_search_matches_nothing()
    {
        Customer::factory()->create(['company_name' => 'Upton BLX']);
        $request = new Request(['s' => 'tes']);
        $result = $this->service->handle($request);

        $this->assertCount(0, $result->items());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_falls_back_to_default_sort_for_invalid_sort_column()
    {
        Customer::factory()->create(['company_name' => 'Upton BLX']);
        Customer::factory()->create(['company_name' => 'Mocky']);

        $request = new Request(['sort' => 'invalid_column', 'dir' => 'asc']);
        $result = $this->service->handle($request);

        $this->assertCount(2, $result->items());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_falls_back_to_default_sort_for_invalid_direction()
    {
        Customer::factory()->create(['company_name' => 'Upton BLX']);
        Customer::factory()->create(['company_name' => 'Mocky']);

        $request = new Request(['sort' => 'company_name', 'dir' => 'invalid_dir']);
        $result = $this->service->handle($request);

        $this->assertCount(2, $result->items());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_sort_by_company_name_asc()
    {
        Customer::factory()->create(['company_name' => 'Upton BLX']);
        Customer::factory()->create(['company_name' => 'Mocky']);

        $request = new Request(['sort' => 'company_name', 'dir' => 'asc']);
        $result = $this->service->handle($request);

        $this->assertEquals('Mocky', $result->first()->company_name);
        $this->assertEquals('Upton BLX', $result->last()->company_name);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_sort_by_company_email_desc()
    {
        Customer::factory()->create(['company_name' => 'Mocky', 'company_email' => 'charlie@email.fr']);
        Customer::factory()->create(['company_name' => 'Upton BLX', 'company_email' => 'alice@email.fr']);

        $request = new Request(['sort' => 'company_email', 'dir' => 'desc']);
        $result = $this->service->handle($request);

        $this->assertEquals('Mocky', $result->first()->company_name);
        $this->assertEquals('Upton BLX', $result->last()->company_name);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_search_by_company_name()
    {
        Customer::factory()->create(['company_name' => 'Upton BLX']);
        Customer::factory()->create(['company_name' => 'Drizzle']);

        $request = new Request(['s' => 'Drizz']);
        $result = $this->service->handle($request);

        $this->assertCount(1, $result->items());
        $this->assertEquals('Drizzle', $result->first()->company_name);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_search_by_company_email()
    {
        Customer::factory()->create(['company_email' => 'john@test.com']);
        Customer::factory()->create(['company_email' => 'jane@test.com']);

        $request = new Request(['s' => 'john']);
        $result = $this->service->handle($request);

        $this->assertCount(1, $result->items());
        $this->assertEquals('john@test.com', $result->first()->company_email);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_search_by_company_phone()
    {
        Customer::factory()->create([
            'company_name' => 'Upton BLX',
            'company_phone' => '+33475903856',
        ]);

        Customer::factory()->create([
            'company_name' => 'Solup',
            'company_phone' => '+42659304390',
        ]);

        $request = new Request(['s' => '+33475903']);
        $result = $this->service->handle($request);

        $this->assertCount(1, $result->items());
        $this->assertEquals('+33475903856', $result->first()->company_phone);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_combine_search_and_sort()
    {
        Customer::factory()->create(['company_name' => 'Drizzle', 'company_email' => 'john@test.com']);
        Customer::factory()->create(['company_name' => 'Soleup', 'company_email' => 'abc@test.com']);
        Customer::factory()->create(['company_name' => 'Upton BLX', 'company_email' => 'alice@test.com']);

        $request = new Request(['s' => 'abc', 'sort' => 'company_email', 'dir' => 'asc']);
        $result = $this->service->handle($request);

        $this->assertCount(1, $result->items());
        $this->assertEquals('abc@test.com', $result->first()->company_email);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_filter_by_status_active()
    {
        Customer::factory()->create(['company_name' => 'Upton BLX', 'status' => 'active']);
        Customer::factory()->create(['company_name' => 'Drizzle', 'status' => 'inactive']);
        Customer::factory()->create(['company_name' => 'Soleup', 'status' => 'prospect']);

        $request = new Request(['status' => 'active']);
        $result = $this->service->handle($request);

        $this->assertCount(1, $result->items());
        $this->assertEquals('active', $result->first()->status);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_filter_by_status_inactive()
    {
        Customer::factory()->create(['company_name' => 'Upton BLX', 'status' => 'active']);
        Customer::factory()->create(['company_name' => 'Drizzle', 'status' => 'inactive']);
        Customer::factory()->create(['company_name' => 'Soleup', 'status' => 'prospect']);

        $request = new Request(['status' => 'inactive']);
        $result = $this->service->handle($request);

        $this->assertCount(1, $result->items());
        $this->assertEquals('inactive', $result->first()->status);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_filter_by_status_prospect()
    {
        Customer::factory()->create(['company_name' => 'Upton BLX', 'status' => 'active']);
        Customer::factory()->create(['company_name' => 'Drizzle', 'status' => 'inactive']);
        Customer::factory()->create(['company_name' => 'Soleup', 'status' => 'prospect']);

        $request = new Request(['status' => 'prospect']);
        $result = $this->service->handle($request);

        $this->assertCount(1, $result->items());
        $this->assertEquals('prospect', $result->first()->status);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_combine_status_filter_and_search()
    {
        Customer::factory()->create(['company_name' => 'Upton BLX', 'status' => 'active']);
        Customer::factory()->create(['company_name' => 'Drizzle', 'status' => 'inactive']);
        Customer::factory()->create(['company_name' => 'Soleup', 'status' => 'prospect']);

        $request = new Request(['status' => 'inactive', 's' => 'Drizz']);
        $result = $this->service->handle($request);

        $this->assertCount(1, $result->items());
        $this->assertEquals('Drizzle', $result->first()->company_name);
        $this->assertEquals('inactive', $result->first()->status);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_paginate_results()
    {
        Customer::factory()->count(15)->create();

        $request = new Request();
        $result = $this->service->handle($request);

        $this->assertEquals(10, $result->count());
        $this->assertEquals(2, $result->lastPage());
    }
}
