<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillRequest;
use App\Models\Bill;
use App\Services\BillLifecycleService;
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

    public function create(Request $request, BillPreparationDataService $service)
    {
        $type = $request->get('type');

        if (!$type || !in_array($type, ['quote', 'invoice'])) {
            abort(404);
        }

        $data = $service->prepareData(type: $type);

        return view('dashboard.bills.create', $data);
    }

    public function store(BillRequest $request, BillLifecycleService $lifecycle)
    {
        $type = $request->get('type', 'quote');

        $data = $request->validated();

        $bill = $lifecycle->create($data, $type);

        return redirect()
            ->route('dashboard.bills.show', $bill->id)
            ->with('success', 'Devis créé avec succès !');
    }

    public function show(Bill $bill)
    {
        $bill->load([
            'company',
            'customer',
            'lines.product',
            'lines.selectedOptions',
        ]);

        if ($path = $bill->company->logo_path) {
            $bill->company->logo_path = str_starts_with($path, 'http')
                ? $path
                : asset($path);
        }

        $hasPackages = $bill->lines->contains(fn($line) => $line->product->type === 'package');
        $hasNonPackages = $bill->lines->contains(fn($line) => $line->product->type !== 'package');

        if ($hasPackages && $hasNonPackages) {
            $optionsHeader = 'Description / Options';
        } elseif ($hasPackages) {
            $optionsHeader = 'Options';
        } else {
            $optionsHeader = 'Description';
        }

        $type = $bill->type === "quote" ? "Devis" : "Facture";

        $paymentLabels = [
            'bank_transfer' => 'Virement bancaire',
            'cash' => 'Espèces',
            'cheque' => 'Chèque',
        ];

        return view('dashboard.bills.show', [
            'bill' => $bill,
            'optionsHeader' => $optionsHeader,
            'type' => $type,
            'paymentLabels' => $paymentLabels,
        ]);
    }


    public function edit(Bill $bill, BillPreparationDataService $service)
    {
        $data = $service->prepareData($bill);
        return view('dashboard.bills.edit', $data);
    }

    public function update(BillRequest $request, BillLifecycleService $lifecycle, Bill $bill)
    {
        $this->ensureEditableQuote($bill);

        $data = $request->validated();

        $bill = $lifecycle->update($bill, $data);

        return redirect()
            ->route('dashboard.bills.show', $bill->id)
            ->with('success', 'Devis modifier avec succès !');
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
        $this->ensureEditableQuote($bill);

        foreach ($bill->lines as $line) {
            $line->selectedOptions()->detach();
            $line->delete();
        }

        $bill->delete();

        return redirect()
            ->route('dashboard.bills.index')
            ->with('success', 'Devis supprimé avec succès !');
    }

    private function ensureEditableQuote(Bill $bill): void
    {
        if ($bill->type !== 'quote' || $bill->status->value !== 'draft') {
            abort(403, 'Seuls les devis en brouillon peuvent être modifiés ou supprimés.');
        }
    }

    public function convertQuoteToInvoice(Request $request, Bill $bill, BillLifecycleService $lifecycle)
    {
        if (!$bill->isQuote()) {
            abort(403, 'Seuls les devis peuvent être convertis.');
        }

        $data = $request->validate([
            'payment_method' => 'required|in:bank_transfer,cash,cheque',
            'conversion_note' => 'nullable|string|max:1000',
        ]);

        $invoice = $lifecycle->convert(
            $bill,
            $data['payment_method'],
            $data['conversion_note'] ?? null
        );

        return redirect()
            ->route('dashboard.bills.show', $invoice->id)
            ->with('success', 'Devis converti en facture avec succès !');
    }
}
