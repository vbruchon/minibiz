<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'address_line1',
        'address_line2',
        'postal_code',
        'city',
        'country',
        'siren',
        'siret',
        'vat_number',
        'website',
        'logo_path',
        'currency',
        'default_tax_rate',
        'footer_note',
    ];

    protected $casts = [
        'default_tax_rate' => 'float',
    ];

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }


    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address_line1,
            $this->address_line2,
            trim(($this->postal_code ?? '') . ' ' . ($this->city ?? '')),
            $this->country,
        ]);

        return implode(', ', $parts);
    }
}
