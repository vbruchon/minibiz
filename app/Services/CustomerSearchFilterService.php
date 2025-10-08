<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerSearchFilterService
{
  public function handle(Request $request)
  {
    $query = Customer::query();

    // Étape 2 — Si un filtre est présent
    if ($request->filled('sort') && $request->filled('dir')) {
      $allowedSorts = ['name', 'email', 'created_at'];
      $allowedDirs = ['asc', 'desc'];

      $sort = in_array($request->sort, $allowedSorts) ? $request->sort : 'created_at';
      $dir = in_array($request->dir, $allowedDirs) ? $request->dir : 'asc';

      $query->orderBy($sort, $dir);
    }

    if ($request->filled('s')) {
      $query->where(function ($q) use ($request) {
        $q->where('name', 'like', "%{$request->s}%")
          ->orWhere('email', 'like', "%{$request->s}%")
          ->orWhere('address', 'like', "%{$request->s}%")
          ->orWhere('phone', 'like', "%{$request->s}%");
      });
    }


    return $query->latest()->paginate(10);
  }
}
