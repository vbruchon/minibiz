<?php

namespace App\Services;

use App\Models\Bill;
use Illuminate\Validation\ValidationException;

class BillStatusService
{
  /**
   * Update a bill's status while enforcing business rules.
   */
  public function updateStatus(Bill $bill, string $newStatus): Bill
  {
    $current = $bill->status->value;
    $type = $bill->type;

    if (! $this->isTransitionAllowed($type, $current, $newStatus)) {
      throw ValidationException::withMessages([
        'status' => "Transition from [$current] to [$newStatus] is not allowed for a $type.",
      ]);
    }

    $bill->update(['status' => $newStatus]);

    return $bill;
  }

  /**
   * Defines all allowed transitions per type.
   */
  protected function isTransitionAllowed(string $type, string $current, string $next): bool
  {
    $rules = [
      'quote' => [
        'draft'     => ['sent'],
        'sent'      => ['accepted', 'rejected'],
        'accepted'  => [],
        'rejected'  => [],
      ],
      'invoice' => [
        'draft'     => ['sent', 'cancelled'],
        'sent'      => ['paid', 'overdue', 'cancelled'],
        'paid'      => [],
        'overdue'   => ['paid', 'cancelled'],
        'cancelled' => [],
      ],
    ];

    return in_array($next, $rules[$type][$current] ?? []);
  }

  /**
   * returns allowed next statuses for a given bill.
   */
  public function allowedNextStatuses(Bill $bill): array
  {
    $type = $bill->type;
    $current = $bill->status->value;

    $rules = [
      'quote' => [
        'draft'     => ['sent'],
        'sent'      => ['accepted', 'rejected'],
        'accepted'  => [],
        'rejected'  => [],
      ],
      'invoice' => [
        'draft'     => ['sent', 'cancelled'],
        'sent'      => ['paid', 'overdue', 'cancelled'],
        'paid'      => [],
        'overdue'   => ['paid', 'cancelled'],
        'cancelled' => [],
      ],
    ];

    return $rules[$type][$current] ?? [];
  }
}
