<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'discount_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'due_date' => ['nullable'],
            'lines' => ['required', 'array', 'min:1'],
            'lines.*.product_id' => ['required', 'exists:products,id'],
            'lines.*.quantity' => ['required', 'numeric', 'min:1'],
            'lines.*.unit_price' => ['required', 'numeric', 'min:0'],
            'lines.*.description' => ['nullable', 'string', 'max:255'],
            'lines.*.selected_options' => ['nullable', 'array'],
            'lines.*.selected_options.*' => ['exists:product_option_values,id'],
            'footer_note' => ['nullable', 'string'],
        ];
    }
}
