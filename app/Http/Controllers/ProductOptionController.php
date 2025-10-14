<?php

namespace App\Http\Controllers;

use App\Services\ProductOptionSearchFilterService;
use Illuminate\Http\Request;

class ProductOptionController extends Controller
{
    public function index(Request $request, ProductOptionSearchFilterService $service)
    {
        $productOptions = $service->handle($request);

        $products = \App\Models\Product::where('type', 'package')
            ->orderBy('name')
            ->pluck('name', 'id');

        $types = \App\Models\ProductOption::select('type')
            ->distinct()
            ->pluck('type');

        return view('dashboard.products-options.list', [
            'productOptions' => $productOptions,
            'products' => $products,
            'types' => $types,
            'currentProduct' => $request->product_id,
            'currentType' => $request->type,
            'route' => route('dashboard.products-options.index'),
        ]);
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
