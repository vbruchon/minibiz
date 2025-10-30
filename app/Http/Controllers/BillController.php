<?php

namespace App\Http\Controllers;

use App\Services\BillSearchFilterService;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index(Request $request, BillSearchFilterService $service)
    {
        $bills = $service->handle($request);

        return view('dashboard.bills.list', ['bills' => $bills]);
    }

    public function create()
    {
        //
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

    public function destroy(string $id)
    {
        //
    }
}
