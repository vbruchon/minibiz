<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Client;
use App\Models\Customer;
use App\Services\CustomerSearchFilterService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected CustomerSearchFilterService $service;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CustomerSearchFilterService $service)
    {
        $customers = $service->handle($request);
        return view('dashboard.customers.list', ['customers' => $customers]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        Customer::create($request->validated());

        return redirect()->route('dashboard.customers.index')
            ->with('success', 'Customer successfully added !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::with([
            'bills' => fn($q) => $q->latest()
        ])->findOrFail($id);

        return view('dashboard.customers.show', ['customer' => $customer]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::find($id);
        return view('dashboard.customers.edit', ['customer' => $customer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $data = $request->validated();

        $customer->update($data);

        return redirect()->route('dashboard.customers.index')
            ->with('success', 'Customer updated successfully !');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('dashboard.customers.index')
            ->with('success', 'Customer deleted successfully !');
    }
}
