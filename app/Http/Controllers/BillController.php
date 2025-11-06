<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\CompanySetting;
use App\Models\ProductOptionValue;
use App\Services\BillCalculationService;
use App\Services\BillNumberService;
use App\Services\BillPreparationDataService;
use App\Services\BillSearchFilterService;
use App\Services\BillStatusService;
use Carbon\Carbon;
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

    public function store(Request $request, BillNumberService $numberService, BillCalculationService $calcService)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'lines' => 'required|array|min:1',
            'lines.*.product_id' => 'required|exists:products,id',
            'lines.*.quantity' => 'required|numeric|min:1',
            'lines.*.unit_price' => 'required|numeric|min:0',
            'lines.*.description' => 'nullable|string|max:255',
            'lines.*.selected_options' => 'nullable|array',
            'lines.*.selected_options.*' => 'exists:product_option_values,id',
            'footer_note' => 'nullable|string',
        ]);

        $number = $numberService->generate('quote');

        $bill = Bill::create([
            'type' => 'quote',
            'number' => $number,
            'status' => 'draft',
            'customer_id' => $data['customer_id'],
            'company_setting_id' => CompanySetting::first()->id,
            'discount_percentage' => $data['discount_percentage'] ?? 0,
            'issue_date' => now(),
            'due_date' => $data['due_date']
                ? Carbon::parse($data['due_date'])
                : now()->addDays(30),
            'footer_note' => $data['footer_note'] ?? null,
        ]);

        foreach ($data['lines'] as $lineData) {
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
                $optionsTotal = ProductOptionValue::whereIn('id', $lineData['selected_options'])->sum('price');

                $billLine->selectedOptions()->attach($lineData['selected_options']);

                $billLine->update([
                    'total' => $lineTotal + $optionsTotal,
                ]);
            }
        }

        $bill->load(['lines.selectedOptions', 'lines.product', 'company']);
        $totals = $calcService->calculate($bill);
        $bill->update($totals);

        return redirect()
            ->route('dashboard.bills.index')
            ->with('success', 'Devis créé avec succès !');
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


    public function destroy(Bill $bill)
    {
        if (!$bill->isQuote() || $bill->status->value !== 'draft') {
            abort(403, 'Seuls les devis en brouillon peuvent être supprimés.');
        }

        foreach ($bill->lines as $line) {
            $line->selectedOptions()->detach();
            $line->delete();
        }

        $bill->delete();

        return redirect()
            ->route('dashboard.bills.index')
            ->with('success', 'Devis supprimé avec succès !');
    }
}
