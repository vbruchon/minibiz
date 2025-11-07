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
      $line['selected_options'] = self::flattenOptions($line['selected_options'] ?? []);
    }
    unset($line);

    $request->merge(['lines' => $lines]);
  }
}
