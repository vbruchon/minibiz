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
        'address_line1',
        'address_line2',
        'postal_code',
        'city',
        'website',
        'vat_number',
        'contact_name',
        'contact_email',
        'contact_phone',
        'status',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
