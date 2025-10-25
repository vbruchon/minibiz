<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductOptionRequest;
use App\Models\Product;
use App\Models\ProductOption;
use App\Services\ProductOptionSearchFilterService;
use Illuminate\Http\Request;

class ProductOptionController extends Controller
{
    public function index(Request $request, ProductOptionSearchFilterService $service)
    {
        $productOptions = $service->handle($request);

        $products = Product::where('type', 'package')
            ->orderBy('name')
            ->pluck('name', 'id');

        $types = ProductOption::select('type')
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
        $products = Product::where('type', 'package')
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();


        return view('dashboard.products-options.create', ['products' => $products]);
    }
    public function store(ProductOptionRequest $request)
    {
        $data = $request->validated();

        $option = ProductOption::create([
            'name' => $data['name'],
            'type' => $data['type'],
        ]);

        foreach ($data['product_id'] as $productId) {
            $pivotData = [];

            if (in_array($data['type'], ['text', 'number'])) {
                $pivotData = [
                    'default_value' => $data['default_value'] ?? null,
                    'default_price' => $data['default_price'] ?? 0,
                    'is_default_attached' => true,
                ];
            }

            $option->products()->attach($productId, $pivotData);
        }

        if (in_array($data['type'], ['select', 'checkbox']) && isset($data['values'])) {
            foreach ($data['values'] as $index => $value) {
                $option->values()->create([
                    'value' => $value['value'],
                    'price' => $value['price'] ?? 0,
                    'is_default' => isset($data['default_index']) && $data['default_index'] == $index,
                ]);
            }
        }

        $redirectTo = $request->input('redirect_to', route('dashboard.products-options.index'));

        return redirect($redirectTo)
            ->with('success', 'Product option successfully added!');
    }



    public function show(string $id)
    {
        $productOption = ProductOption::with([
            'products',
            'values'
        ])->findOrFail($id);

        return view('dashboard.products-options.show', [
            'productOption' => $productOption,
        ]);
    }



    public function edit(string $id)
    {
        $productOption = ProductOption::find($id);
        $products = Product::where('type', 'package')
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();

        return view('dashboard.products-options.edit', ['products' => $products, 'productOption' => $productOption]);
    }

    public function update(ProductOptionRequest $request, string $id)
    {
        $data = $request->validated();
        $option = ProductOption::findOrFail($id);

        $option->update([
            'name' => $data['name'],
            'type' => $data['type'],
        ]);

        $option->products()->detach();

        foreach ($data['product_id'] as $productId) {
            $pivotData = [];

            if (in_array($data['type'], ['text', 'number'])) {
                $pivotData = [
                    'default_value' => $data['default_value'] ?? null,
                    'default_price' => $data['default_price'] ?? 0,
                    'is_default_attached' => true,
                ];
            }

            $option->products()->attach($productId, $pivotData);
        }

        $option->values()->delete();
        if (in_array($data['type'], ['select', 'checkbox']) && isset($data['values'])) {
            foreach ($data['values'] as $index => $value) {
                $option->values()->create([
                    'value' => $value['value'],
                    'price' => $value['price'] ?? 0,
                    'is_default' => isset($data['default_index']) && $data['default_index'] == $index,
                ]);
            }
        }

        $redirectTo = $request->input('redirect_to', route('dashboard.products-options.index'));

        return redirect($redirectTo)
            ->with('success', 'Product option successfully added!');
    }



    public function destroy(string $id)
    {
        $option = ProductOption::with('products', 'values')->findOrFail($id);

        if ($option->products()->exists()) {
            $option->products()->detach();
        }

        $option->values()->delete();

        $option->delete();

        return redirect()
            ->route('dashboard.products-options.index')
            ->with('success', 'Product option successfully deleted!');
    }

    public function syncOptions(Request $request, Product $product)
    {
        $optionIds = $request->input('options', []);

        $product->options()->sync($optionIds);

        return redirect()->back()->with('success', 'Options updated successfully!');
    }
}
