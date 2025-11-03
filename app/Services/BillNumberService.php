<?php

namespace App\Services;

use App\Models\Bill;

class BillNumberService
{
  public function generate(string $type = 'quote'): string
  {
    $year = now()->year;
    $prefix = $type === "quote" ? "D" : "F";


    $lastNumber = Bill::query()
      ->where('type', $type)
      ->where('number', 'like', "{$prefix}{$year}-%")
      ->orderByDesc('number')
      ->value('number');

    if (!$lastNumber) {
      return "{$prefix}{$year}-0001";
    }

    //Catch the 4 last number 
    preg_match('/-(\d{4})$/', $lastNumber, $matches);
    $lastSeq = isset($matches[1]) ? (int)$matches[1] : 0;

    $nextSeq = str_pad($lastSeq + 1, 4, '0', STR_PAD_LEFT);

    return "{$prefix}{$year}-{$nextSeq}";
  }
}
