<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo_path',
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
        'currency',
        'default_tax_rate',
        'footer_note',
        'payment_methods',
        'bank_iban',
        'bank_bic',
    ];

    protected $casts = [
        'default_tax_rate' => 'float',
        'payment_methods' => 'array',
    ];

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function getFullAddressAttribute(): ?string
    {
        $parts = array_filter([
            $this->address_line1,
            $this->address_line2 . ', ',
            trim(($this->postal_code ?? '') . ' ' . ($this->city ?? '')),
            $this->country,
        ]);

        return $parts ? implode("\n", $parts) : null;
    }

    public function logoPathForPdf()
    {
        if (!$this->logo_path) {
            return null;
        }

        $relative = str_replace('storage/', '', $this->logo_path);
        $path = public_path('storage/' . $relative);

        if (!file_exists($path)) {
            return null;
        }

        $data = base64_encode(file_get_contents($path));
        $mime = mime_content_type($path);

        return "data:$mime;base64,$data";
    }
}
