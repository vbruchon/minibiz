<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillLineOptionValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'bill_line_id',
        'product_option_value_id',
    ];

    public function billLine()
    {
        return $this->belongsTo(BillLine::class);
    }

    public function productOptionValue()
    {
        return $this->belongsTo(ProductOptionValue::class);
    }
}
