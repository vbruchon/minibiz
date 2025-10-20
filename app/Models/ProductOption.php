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

  public function getDefaultValueAttribute()
  {
    if (in_array($this->type, ['text', 'number'])) {
      return $this->pivot->default_value ?? '-';
    }

    return optional($this->values->firstWhere('is_default', true))->value ?? '-';
  }

  public function getDefaultPriceAttribute()
  {
    if (in_array($this->type, ['text', 'number'])) {
      return $this->pivot->default_price ?? 0;
    }

    return optional($this->values->firstWhere('is_default', true))->price ?? 0;
  }
}
