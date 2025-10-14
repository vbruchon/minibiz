<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
  protected $fillable = ['name', 'type'];

  public function products()
  {
    return $this->belongsToMany(Product::class, 'product_product_option')
      ->withPivot(['default_value', 'default_price', 'is_default_attached'])
      ->withTimestamps();
  }

  public function values()
  {
    return $this->hasMany(ProductOptionValue::class);
  }
}
