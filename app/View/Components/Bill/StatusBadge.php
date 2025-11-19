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
        $this->hoverColor = count($this->allowedStatuses) > 0
            ? $this->resolveHoverColor($this->status)
            : '';
    }

    private function resolveStatusColor(string $status): string
    {
        if ($this->isShow) {
            return match ($status) {
                'draft'     => 'bg-gray-200 text-gray-800 border-gray-300',
                'sent'      => 'bg-blue-100 text-blue-700 border-blue-300',
                'accepted'  => 'bg-green-100 text-green-700 border-green-300',
                'rejected'  => 'bg-red-100 text-red-700 border-red-300',
                'converted' => 'bg-amber-100 text-amber-700 border-amber-300',
                'paid'      => 'bg-emerald-100 text-emerald-700 border-emerald-300',
                'overdue'   => 'bg-orange-100 text-orange-700 border-orange-300',
                'cancelled' => 'bg-red-200 text-red-800 border-red-400',
                default     => 'bg-gray-200 text-gray-800 border-gray-300',
            };
        }

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
        if ($this->isShow) {
            return match ($status) {
                'draft'     => 'hover:bg-gray-300/60 hover:ring-1',
                'sent'      => 'hover:bg-blue-200/60 hover:ring-1',
                'accepted'  => 'hover:bg-green-200/60 hover:ring-1',
                'rejected'  => 'hover:bg-red-200/60 hover:ring-1',
                'converted' => 'hover:bg-amber-200/60 hover:ring-1',
                'paid'      => 'hover:bg-emerald-200/60 hover:ring-1',
                'overdue'   => 'hover:bg-orange-200/60 hover:ring-1',
                'cancelled' => 'hover:bg-red-300/60 hover:ring-1',
                default     => 'hover:bg-gray-300/60 hover:ring-1',
            };
        }

        return match ($status) {
            'draft'     => 'hover:bg-gray-700/30 hover:ring-1',
            'sent'      => 'hover:bg-blue-700/30 hover:ring-1',
            'accepted'  => 'hover:bg-green-900/30 hover:ring-1',
            'rejected'  => 'hover:bg-red-700/30 hover:ring-1',
            'converted' => 'hover:bg-amber-700/30 hover:ring-1',
            'paid'      => 'hover:bg-emerald-700/30 hover:ring-1',
            'overdue'   => 'hover:bg-orange-700/30 hover:ring-1',
            'cancelled' => 'hover:bg-red-800/30 hover:ring-1',
            default     => 'hover:bg-gray-700/30 hover:ring-1',
        };
    }




    public function render()
    {
        return view('components.bill.status-badge');
    }
}
