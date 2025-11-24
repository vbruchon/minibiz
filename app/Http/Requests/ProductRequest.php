<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   */
  public function rules(): array
  {
    $productId = $this->route('product')?->id;

    return [
      'name' => ['required', 'string', 'max:255'],
      'type' => ['required', Rule::in(['time_unit', 'package'])],
      'unit' => ['nullable', 'string', 'max:50'],
      'base_price' => ['required', 'numeric', 'min:0'],
      'status' => [
        $this->isMethod('PUT') || $this->isMethod('PATCH') ? 'required' : 'nullable',
        Rule::in(['active', 'inactive', 'archived']),
      ],
    ];
  }
}
