<?php

namespace App\Services;

use App\Models\ProductOption;
use Illuminate\Http\Request;

class ProductOptionSearchFilterService
{
  protected $baseService;

  public function __construct(BaseSearchFilterService $baseService)
  {
    $this->baseService = $baseService;
  }

  public function handle(Request $request)
  {
    $query = ProductOption::query();

    if ($request->filled('product_id')) {
      $query->where('product_id', $request->product_id);
    }

    if ($request->filled('type')) {
      $query->where('type', $request->type);
    }

    if ($request->filled('name')) {
      $query->where('name', 'like', '%' . $request->name . '%');
    }

    return $this->baseService->handle(
      $request,
      $query,
      ['name', 'type', 'default_price', 'created_at'], // sort
      ['name', 'type'] // search
    );
  }
}
