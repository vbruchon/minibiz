<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerSearchFilterService
{
  public function handle(Request $request)
  {
    $query = Customer::query();

    if ($request->filled('sort') && $request->filled('dir')) {
      $allowedSorts = ['company_name', 'company_email', 'created_at', 'city'];
      $allowedDirs = ['asc', 'desc'];

      $sort = in_array($request->sort, $allowedSorts) ? $request->sort : 'created_at';
      $dir = in_array($request->dir, $allowedDirs) ? $request->dir : 'asc';

      $query->orderBy($sort, $dir);
    }

    if ($request->filled('s')) {
      $query->where(function ($q) use ($request) {
        $q->where('company_name', 'like', "%{$request->s}%")
          ->orWhere('company_email', 'like', "%{$request->s}%")
          ->orWhere('city', 'like', "%{$request->s}%")
          ->orWhere('company_phone', 'like', "%{$request->s}%")
          ->orWhere('contact_name', 'like', "%{$request->s}%")
          ->orWhere('contact_email', 'like', "%{$request->s}%")
          ->orWhere('contact_phone', 'like', "%{$request->s}%")
          ->orWhere('city', 'like', "%{$request->s}%");
      });
    }


    return $query->latest()->paginate(10);
  }
}
