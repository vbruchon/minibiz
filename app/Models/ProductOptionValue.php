<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
    protected $fillable = ['product_option_id', 'value', 'price', 'is_default'];

    protected $casts = [
        'price' => 'decimal:2',
        'is_default' => 'boolean',
    ];

    public function option()
    {
        return $this->belongsTo(ProductOption::class, 'product_option_id');
    }

    public function billLines()
    {
        return $this->belongsToMany(
            BillLine::class,
            'bill_line_option_values'
        );
    }
}
