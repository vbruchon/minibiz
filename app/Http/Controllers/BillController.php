<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\CompanySetting;
use App\Models\Customer;
use App\Models\Product;
use App\Services\BillPreparationDataService;
use App\Services\BillSearchFilterService;
use App\Services\BillStatusService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BillController extends Controller
{
    public function index(Request $request, BillSearchFilterService $service)
    {
        $bills = $service->handle($request);

        return view('dashboard.bills.list', ['bills' => $bills]);
    }

    public function create(BillPreparationDataService $service)
    {
        $data = $service->prepareData();
        return view('dashboard.bills.create', $data);
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function updateStatus(Request $request, Bill $bill, BillStatusService $service)
    {
        $validated = $request->validate([
            'status' => ['required', 'string'],
        ]);

        try {
            $service->updateStatus($bill, $validated['status']);
        } catch (ValidationException $e) {
            return back()->with('error', $e->errors()['status'][0] ?? 'Invalid transition.');
        }

        return back()->with('success', 'Bill status updated successfully.');
    }


    public function destroy(string $id)
    {
        //
    }
}
