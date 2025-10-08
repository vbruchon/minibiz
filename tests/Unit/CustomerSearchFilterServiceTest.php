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

    /** @test */
    public function it_returns_all_customers_when_no_filter_or_search()
    {
        Customer::factory()->count(5)->create();

        $request = new Request();
        $result = $this->service->handle($request);

        $this->assertCount(5, $result->items());
    }

    /** @test */
    public function it_returns_empty_when_search_matches_nothing()
    {
        Customer::factory()->create(['name' => 'Alice']);
        $request = new Request(['s' => 'John']);
        $result = $this->service->handle($request);

        $this->assertCount(0, $result->items());
    }

    /** @test */
    public function it_falls_back_to_default_sort_for_invalid_sort_column()
    {
        Customer::factory()->create(['name' => 'Alice']);
        Customer::factory()->create(['name' => 'Bob']);

        $request = new Request(['sort' => 'invalid_column', 'dir' => 'asc']);
        $result = $this->service->handle($request);

        // Vérifie que ça retourne quand même les éléments
        $this->assertCount(2, $result->items());
    }

    /** @test */
    public function it_falls_back_to_default_sort_for_invalid_direction()
    {
        Customer::factory()->create(['name' => 'Alice']);
        Customer::factory()->create(['name' => 'Bob']);

        $request = new Request(['sort' => 'name', 'dir' => 'invalid_dir']);
        $result = $this->service->handle($request);

        $this->assertCount(2, $result->items());
    }

    /** @test */
    public function it_can_sort_by_name_asc()
    {
        Customer::factory()->create(['name' => 'Charlie']);
        Customer::factory()->create(['name' => 'Alice']);

        $request = new Request(['sort' => 'name', 'dir' => 'asc']);
        $result = $this->service->handle($request);

        $this->assertEquals('Alice', $result->first()->name);
        $this->assertEquals('Charlie', $result->last()->name);
    }

    /** @test */
    public function it_can_sort_by_email_desc()
    {
        Customer::factory()->create(['name' => 'Charlie', 'email' => 'charlie@email.fr']);
        Customer::factory()->create(['name' => 'Alice', 'email' => 'alice@email.fr']);

        $request = new Request(['sort' => 'name', 'dir' => 'desc']);
        $result = $this->service->handle($request);

        $this->assertEquals('Alice', $result->first()->name);
        $this->assertEquals('Charlie', $result->last()->name);
    }



    /** @test */
    public function it_can_search_by_name()
    {
        Customer::factory()->create(['name' => 'John Doe']);
        Customer::factory()->create(['name' => 'Jane Doe']);

        $request = new Request(['s' => 'John']);
        $result = $this->service->handle($request);

        $this->assertCount(1, $result->items());
        $this->assertEquals('John Doe', $result->first()->name);
    }

    /** @test */
    public function it_can_search_by_email()
    {
        Customer::factory()->create(['email' => 'john@test.com']);
        Customer::factory()->create(['email' => 'jane@test.com']);

        $request = new Request(['s' => 'john']);
        $result = $this->service->handle($request);

        $this->assertCount(1, $result->items());
        $this->assertEquals('john@test.com', $result->first()->email);
    }

    /** @test */
    public function it_can_search_by_phone()
    {
        Customer::factory()->create([
            'name' => 'John Doe',
            'phone' => '+33475903856',
        ]);

        Customer::factory()->create([
            'name' => 'Jane Smith',
            'phone' => '+42659304390',
        ]);

        $request = new Request(['s' => '+33475903']);
        $result = $this->service->handle($request);

        $this->assertCount(1, $result->items());
        $this->assertEquals('+33475903856', $result->first()->phone);
    }

    /** @test */
    public function it_can_combine_search_and_sort()
    {
        Customer::factory()->create(['name' => 'John', 'email' => 'john@test.com']);
        Customer::factory()->create(['name' => 'John', 'email' => 'abc@test.com']);
        Customer::factory()->create(['name' => 'Alice', 'email' => 'alice@test.com']);

        $request = new Request(['s' => 'John', 'sort' => 'email', 'dir' => 'asc']);
        $result = $this->service->handle($request);

        $this->assertCount(2, $result->items());
        $this->assertEquals('abc@test.com', $result->first()->email);
        $this->assertEquals('john@test.com', $result->last()->email);
    }

    /** @test */
    public function it_can_paginate_results()
    {
        Customer::factory()->count(15)->create();

        $request = new Request();
        $result = $this->service->handle($request);

        $this->assertEquals(10, $result->count());
        $this->assertEquals(2, $result->lastPage());
    }
}
