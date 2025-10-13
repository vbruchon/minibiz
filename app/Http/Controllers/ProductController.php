<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductSearchFilterService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request, ProductSearchFilterService $service)
    {
        $products = $service->handle($request);
        return view('dashboard.products.list', ['products' => $products]);
    }

    public function create()
    {
        return view('dashboard.products.create');
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['status'] = 'active';

        Product::create($data);

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product successfully added!');
    }


    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $product = Product::find($id);
        return view('dashboard.products.edit', ['product' => $product]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $product->update($data);

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Product updated successfully !');
    }

    public function destroy(string $id)
    {
        //
    }
}
