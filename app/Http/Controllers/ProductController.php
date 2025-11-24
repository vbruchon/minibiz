<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductOption;
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
            ->with('success', 'Produit ajouté avec succès !');
    }


    public function show(string $id)
    {
        $product = Product::with(['options.values'])->findOrFail($id);

        $productOptions = $product->options()->with('values')->paginate(5);

        $allOptions = ProductOption::all();
        $packageProducts = Product::where('type', 'package')
            ->orderBy('name')
            ->pluck('name', 'id');

        return view('dashboard.products.show', [
            'product' => $product,
            'allOptions' => $allOptions,
            'productOptions' => $productOptions,

            'packageProducts' => $packageProducts,
        ]);
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
            ->with('success', 'Produit modifié avec succès !');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('dashboard.products.index')
            ->with('success', 'Produit supprimer avec succès !');
    }
}
