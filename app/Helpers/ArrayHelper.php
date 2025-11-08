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

    foreach ($lines as $i => &$line) {
      if (!isset($line['selected_options'])) continue;

      $flat = [];

      foreach ($line['selected_options'] as $group) {
        if (is_array($group)) {
          foreach ($group as $id) {
            $flat[] = $id;
          }
        } else {
          $flat[] = $group;
        }
      }

      $line['selected_options'] = $flat;
    }

    $request->merge(['lines' => $lines]);
  }
}
