<?php

namespace App\Models;

use App\Enums\BillStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'number',
        'status',
        'customer_id',
        'company_setting_id',
        'issue_date',
        'due_date',
        'payment_terms',
        'interest_rate',
        'subtotal',
        'tax_total',
        'total',
        'discount_amount',
        'discount_percentage',
        'notes',
        'footer_note',
        'signature_path',
        'converted_from_id',
        'payment_method',
        'payment_details',
    ];

    protected $casts = [
        'status' => BillStatus::class,
        'interest_rate' => 'decimal:2',
        'issue_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'total' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'payment_details' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function company()
    {
        return $this->belongsTo(CompanySetting::class, 'company_setting_id');
    }

    public function lines()
    {
        return $this->hasMany(BillLine::class);
    }

    public function source()
    {
        return $this->belongsTo(self::class, 'converted_from_id');
    }

    public function isQuote(): bool
    {
        return $this->type === 'quote';
    }

    public function isInvoice(): bool
    {
        return $this->type === 'invoice';
    }

    public function isDraft(): bool
    {
        return $this->status === BillStatus::Draft;
    }

    public function isSent(): bool
    {
        return $this->status === BillStatus::Sent;
    }

    public function isAccepted(): bool
    {
        return $this->status === BillStatus::Accepted;
    }

    public function isRejected(): bool
    {
        return $this->status === BillStatus::Rejected;
    }

    public function isConverted(): bool
    {
        return $this->status === BillStatus::Converted;
    }

    public function isPaid(): bool
    {
        return $this->status === BillStatus::Paid;
    }

    public function isOverdue(): bool
    {
        return $this->status === BillStatus::Overdue;
    }

    public function isCancelled(): bool
    {
        return $this->status === BillStatus::Cancelled;
    }

    public function canBeEdited(): bool
    {
        return in_array($this->status, [
            BillStatus::Draft,
        ]);
    }

    public function getPaymentLabelAttribute()
    {
        return [
            'bank_transfer' => 'Virement bancaire',
            'cash' => 'Espèces',
            'cheque' => 'Chèque',
        ][$this->payment_method] ?? ucfirst($this->payment_method);
    }

    public function convertedInvoice()
    {
        return $this->hasOne(Bill::class, 'converted_from_id');
    }

    public function canBeConverted(): bool
    {
        return $this->isQuote()
            && !$this->isRejected()
            && !$this->convertedInvoice;
    }

    public function type(): string
    {
        return $this->input('type', 'quote');
    }
}
