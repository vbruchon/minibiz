<?php

namespace App\Http\Controllers;

use App\Helpers\ArrayHelper;
use App\Http\Requests\BillRequest;
use App\Models\Bill;
use App\Services\BillCreatorService;
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

    public function store(BillRequest $request, BillCreatorService $creator)
    {
        ArrayHelper::mergeFlattenedLines($request);

        $data = $request->validated();

        $creator->create($data);

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
