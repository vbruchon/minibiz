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
                'draft'     => 'bg-muted text-muted-foreground border-muted/40',
                'sent'      => 'bg-info/20 text-info border-info/40',
                'accepted'  => 'bg-success/20 text-success border-success/40',
                'rejected'  => 'bg-destructive/20 text-destructive border-destructive/40',
                'converted' => 'bg-warning/20 text-warning border-warning/40',
                'paid' => 'bg-primary text-primary-foregournd border-prymary',
                'overdue'   => 'bg-orange-200 text-orange-800 dark:bg-orange-500/20 dark:text-orange-300 border-orange-300',
                'cancelled' => 'bg-red-200 text-red-800 dark:bg-red-600/20 dark:text-red-300 border-red-400',
                'default'     => 'bg-muted text-muted-foreground border-muted/40',
            };
        }

        return match ($status) {
            'draft'     => 'bg-muted/20 text-muted-foreground border-muted/30',
            'sent'      => 'bg-info/20 text-info border-info/30',
            'accepted'  => 'bg-success/20 text-success border-success/30',
            'paid' => 'bg-primary/20 text-success border-primary',
            'rejected'  => 'bg-destructive/20 text-destructive border-destructive/30',
            'converted' => 'bg-warning/20 text-warning border-warning/30',
            'overdue'   => 'bg-orange-500/20 text-orange-500 border-orange-500/30',
            'cancelled' => 'bg-red-600/20 text-red-300 border-red-600/30',
            'default'     => 'bg-muted/20 text-muted-foreground border-muted/30',
        };
    }



    private function resolveHoverColor(string $status): string
    {
        if ($this->isShow) {
            return match ($status) {
                'draft'     => 'hover:bg-muted/40 hover:ring-1',
                'sent'      => 'hover:bg-info/30 hover:ring-1',
                'accepted'  => 'hover:bg-success/30 hover:ring-1',
                'paid'      => 'hover:bg-primary/40 hover:ring-1',
                'rejected'  => 'hover:bg-destructive/30 hover:ring-1',
                'converted' => 'hover:bg-warning/30 hover:ring-1',
                'overdue'   => 'hover:bg-orange-300/40 hover:ring-1',
                'cancelled' => 'hover:bg-red-400/40 hover:ring-1',
                'default'     => 'hover:bg-muted/40 hover:ring-1',
            };
        }

        return match ($status) {
            'draft'     => 'hover:bg-muted/30 hover:ring-1',
            'sent'      => 'hover:bg-info/30 hover:ring-1',
            'accepted'  => 'hover:bg-success/30 hover:ring-1',
            'paid'      => 'hover:bg-primary/40 hover:ring-1',
            'rejected'  => 'hover:bg-destructive/30 hover:ring-1',
            'converted' => 'hover:bg-warning/30 hover:ring-1',
            'overdue'   => 'hover:bg-orange-500/30 hover:ring-1',
            'cancelled' => 'hover:bg-red-700/30 hover:ring-1',
            'default'     => 'hover:bg-muted/30 hover:ring-1',
        };
    }





    public function render()
    {
        return view('components.bill.status-badge');
    }
}
