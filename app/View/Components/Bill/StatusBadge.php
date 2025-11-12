<?php

namespace App\View\Components\Bill;

use App\Models\Bill;
use Illuminate\View\Component;
use App\Services\BillStatusService;

class StatusBadge extends Component
{
    public Bill $bill;
    public bool $isShow;

    public string $status;
    public array $allowedStatuses;
    public string $statusColor;
    public string $hoverColor;

    public function __construct(Bill $bill, bool $isShow = false)
    {
        $this->bill = $bill;
        $this->isShow = $isShow;

        $this->status = $bill->status->value;
        $this->allowedStatuses = app(BillStatusService::class)->allowedNextStatuses($bill);

        $this->statusColor = $this->resolveStatusColor($this->status);
        $this->hoverColor = $this->resolveHoverColor($this->status);
    }

    private function resolveStatusColor(string $status): string
    {
        return match ($status) {
            'draft'     => 'bg-gray-600/10 text-gray-400 border-gray-500/30',
            'sent'      => 'bg-blue-600/10 text-blue-400 border-blue-500/30',
            'accepted'  => 'bg-green-600/10 text-green-400 border-green-500/30',
            'rejected'  => 'bg-red-600/10 text-red-400 border-red-500/30',
            'converted' => 'bg-yellow-600/10 text-yellow-400 border-yellow-500/30',
            'paid'      => 'bg-emerald-600/10 text-emerald-400 border-emerald-500/30',
            'overdue'   => 'bg-orange-600/10 text-orange-400 border-orange-500/30',
            'cancelled' => 'bg-red-600/10 text-red-400 border-red-500/30',
            default     => 'bg-gray-600/10 text-gray-400 border-gray-500/30',
        };
    }

    private function resolveHoverColor(string $status): string
    {
        return match ($status) {
            'draft'     => 'hover:bg-gray-700',
            'sent'      => 'hover:bg-blue-700/40',
            'accepted'  => 'hover:bg-green-700/40',
            'rejected'  => 'hover:bg-red-700/40',
            'converted' => 'hover:bg-yellow-700/40',
            'paid'      => 'hover:bg-emerald-700/40',
            'overdue'   => 'hover:bg-orange-700/40',
            'cancelled' => 'hover:bg-red-700/40',
            default     => 'hover:bg-gray-700',
        };
    }

    public function render()
    {
        return view('components.bill.status-badge');
    }
}
