<?php

namespace App\Services;

use App\Models\Customer;
use App\Services\BaseSearchFilterService;
use Illuminate\Http\Request;

class CustomerSearchFilterService
{
  protected $baseService;

  public function __construct(BaseSearchFilterService $baseService)
  {
    $this->baseService = $baseService;
  }

  public function handle(Request $request)
  {
    $query = Customer::query();

    if ($request->filled('status')) {
      $query->where('status', $request->status);
    }

    return $this->baseService->handle(
      $request,
      $query,
      ['company_name', 'company_email', 'created_at', 'city'], // allowedSorts
      ['company_name', 'company_email', 'city', 'company_phone', 'contact_name', 'contact_email', 'contact_phone'] // searchableColumns
    );
  }
}
