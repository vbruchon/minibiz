<?php

namespace App\Helpers;

class ArrayHelper
{
  /**
   * Flattens a nested options structure such as:
   * ['group_0' => '19', 'group_1' => ['34', '36']]
   * into a simple array: [19, 34, 36].
   */
  public static function flattenOptions(?array $options): array
  {
    if (empty($options)) {
      return [];
    }

    return collect($options)
      ->flatten()
      ->filter()
      ->unique()
      ->values()
      ->all();
  }

  /**
   * Merges them back into the Request instance.
   */
  public static function mergeFlattenedLines($request): void
  {
    $lines = $request->input('lines', []);

    foreach ($lines as &$line) {
      $groups = collect($line)
        ->filter(fn($value, $key) => str_starts_with($key, 'selected_group_'))
        ->values()
        ->flatten()
        ->all();

      $selected = collect($line['selected_options'] ?? [])
        ->merge($groups)
        ->flatten()
        ->filter(fn($v) => is_numeric($v))
        ->unique()
        ->values()
        ->all();

      $line['selected_options'] = $selected;
    }

    unset($line);
    $request->merge(['lines' => $lines]);
  }
}
