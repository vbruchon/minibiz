<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'base_price',
        'unit',
        'status',
    ];

    public function options()
    {
        return $this->belongsToMany(ProductOption::class, 'product_product_option')
            ->withPivot(['default_value', 'default_price', 'is_default_attached'])
            ->withTimestamps();
    }

    public function defaultOptions()
    {
        return $this->options()->wherePivot('is_default_attached', true);
    }
}
