<?php

namespace App\Services;

use App\Models\Bill;
use Illuminate\Http\Request;

class BillSearchFilterService
{
  protected $baseService;

  public function __construct(BaseSearchFilterService $baseService)
  {
    $this->baseService = $baseService;
  }

  public function handle(Request $request)
  {
    $query = Bill::query()
      ->leftJoin('customers', 'bills.customer_id', '=', 'customers.id')
      ->select('bills.*')
      ->with('customer')
      ->orderBy('issue_date', 'desc');

    if ($request->filled('type')) {
      $query->where('bills.type', $request->type);
    }

    if ($request->filled('status')) {
      $query->where('bills.status', $request->status);
    }

    if ($request->filled('from')) {
      $query->whereDate('bills.issue_date', '>=', $request->from);
    }

    if ($request->filled('to')) {
      $query->whereDate('bills.issue_date', '<=', $request->to);
    }

    return $this->baseService->handle(
      $request,
      $query,
      // sort
      ['bills.number', 'bills.type', 'bills.status', 'bills.total', 'bills.issue_date', 'bills.due_date', 'bills.created_at'],
      // search
      ['bills.number', 'bills.type', 'bills.status', 'customers.company_name']
    );
  }
}
