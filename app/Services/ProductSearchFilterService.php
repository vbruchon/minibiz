<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductSearchFilterService
{
  protected $baseService;

  public function __construct(BaseSearchFilterService $baseService)
  {
    $this->baseService = $baseService;
  }

  public function handle(Request $request)
  {
    $query = Product::query();

    if ($request->filled('status')) {
      $allowedStatus = ['active', 'inactive'];
      $status = in_array($request->status, $allowedStatus) ? $request->status : null;

      if ($status) {
        $query->where('status', $status);
      }
    }

    return $this->baseService->handle(
      $request,
      $query,
      ['name', 'base_price', 'created_at', 'status'], // sorts
      ['name', 'type'] // search
    );
  }
}
