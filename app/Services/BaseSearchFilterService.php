<?php

namespace App\Services;

use Illuminate\Http\Request;

class BaseSearchFilterService
{
  public function handle(Request $request, $query, array $allowedSorts, array $searchableColumns)
  {
    if ($request->filled('sort') && $request->filled('dir')) {
      $sort = in_array($request->sort, $allowedSorts) ? $request->sort : $allowedSorts[0];
      $dir = in_array($request->dir, ['asc', 'desc']) ? $request->dir : 'asc';
      $query->orderBy($sort, $dir);
    }

    if ($request->filled('s')) {
      $query->where(function ($q) use ($request, $searchableColumns) {
        foreach ($searchableColumns as $col) {
          $q->orWhere($col, 'like', "%{$request->s}%");
        }
      });
    }

    return $query->paginate(10);
  }
}
