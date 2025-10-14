<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductOptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'exists:products,id'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:choose,text,number,checkbox,select'],

            // text/number
            'default_value' => ['nullable', 'string', 'max:255'],
            'default_price' => ['nullable', 'numeric', 'min:0'],

            // select/checkbox
            'values' => ['nullable', 'array'],
            'values.*.value' => ['required_with:values|string|max:255'],
            'values.*.price' => ['nullable', 'numeric', 'min:0'],
            'default_index' => [
                'nullable',
                'integer',
            ],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $values = $this->input('values', []);
            $defaultIndex = $this->input('default_index');

            if (!empty($values)) {
                if ($defaultIndex === null) {
                    return;
                }

                if (!array_key_exists($defaultIndex, $values)) {
                    $validator->errors()->add('default_index', 'The selected default value is invalid.');
                    return;
                }

                $countDefault = 0;
                foreach ($values as $index => $value) {
                    if (isset($value['is_default']) && $value['is_default']) {
                        $countDefault++;
                    }
                }
                if ($countDefault > 1) {
                    $validator->errors()->add('values', 'Only one value can be set as default.');
                }
            } elseif ($defaultIndex !== null) {
                $validator->errors()->add('default_index', 'Default index cannot be set when there are no values.');
            }
        });
    }
}
