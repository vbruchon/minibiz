<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_email',
        'company_phone',
        'website',
        'address_line1',
        'address_line2',
        'postal_code',
        'city',
        'country',
        'siren',
        'siret',
        'ape_code',
        'vat_number',
        'contact_name',
        'contact_email',
        'contact_phone',
        'status',
    ];

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function getFullAddressAttribute(): ?string
    {
        $parts = array_filter([
            $this->address_line1,
            $this->address_line2,
            trim(($this->postal_code ?? '') . ' ' . ($this->city ?? '')),
            $this->country,
        ]);

        return $parts ? implode("\n", $parts) : null;
    }
}
