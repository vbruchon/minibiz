<?php

namespace App\Http\Requests;

use App\Helpers\ArrayHelper;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PaymentTermsEnum;
use App\Enums\InterestRateEnum;

class BillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        ArrayHelper::mergeFlattenedLines($this);

        $this->merge([
            'payment_terms' => $this->mergeHybridField(
                'payment_terms',
                'payment_terms_custom',
                PaymentTermsEnum::OTHER->value
            ),
            'interest_rate' => $this->mergeHybridField(
                'interest_rate',
                'interest_rate_custom',
                InterestRateEnum::OTHER->value
            ),
        ]);
    }

    private function mergeHybridField(string $field, string $customField, string $trigger): mixed
    {
        $value = $this->input($field);
        $customValue = $this->input($customField);

        if ($value === $trigger && filled($customValue)) {
            return $customValue;
        }

        return $value;
    }

    public function rules(): array
    {
        $paymentTermsValues = array_column(PaymentTermsEnum::cases(), 'value');

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
            'lines.*.selected_options.*' => ['integer', 'exists:product_option_values,id'],
            'footer_note' => ['nullable', 'string'],

            'payment_terms' => [
                'nullable',
                'string',
                function ($attr, $value, $fail) use ($paymentTermsValues) {
                    if (!in_array($value, $paymentTermsValues, true) && mb_strlen((string) $value) > 255) {
                        $fail('Les conditions de règlement sont trop longues (max 255 caractères).');
                    }
                },
            ],
            'payment_terms_custom' => [
                'nullable',
                'string',
                'max:255',
                function ($attr, $value, $fail) {
                    if ($this->input('payment_terms') === PaymentTermsEnum::OTHER->value && blank($value)) {
                        $fail('Veuillez saisir vos conditions de règlement personnalisées.');
                    }
                },
            ],

            'interest_rate' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'interest_rate_custom' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100',
                function ($attr, $value, $fail) {
                    if ($this->input('interest_rate') === InterestRateEnum::OTHER->value && blank($value)) {
                        $fail('Veuillez saisir un taux d’intérêt personnalisé.');
                    }
                },
            ],
        ];
    }
}
