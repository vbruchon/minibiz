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
        'subtotal',
        'tax_total',
        'total',
        'notes',
        'footer_note',
        'signature_path',
        'converted_from_id',
    ];

    protected $casts = [
        'status' => BillStatus::class,
        'issue_date' => 'date',
        'due_date' => 'date',
        'subtotal' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'total' => 'decimal:2',
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
}
