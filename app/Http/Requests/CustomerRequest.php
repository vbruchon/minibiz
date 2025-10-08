<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Récupère l'ID du client depuis la route (update) ou null pour create
        $customerId = $this->route('customer')?->id;

        return [
            'company_name' => 'required|string|max:255',
            'company_email' => [
                'required',
                'email',
                Rule::unique('customers', 'company_email')->ignore($customerId),
            ],
            'company_phone' => 'nullable|string|max:20',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'vat_number' => 'nullable|string|max:20',
            'contact_name' => 'nullable|string|max:255',
            'contact_email' => [
                'nullable',
                'email',
                Rule::unique('customers', 'contact_email')->ignore($customerId),
            ],
            'contact_phone' => 'nullable|string|max:20',
            'status' => ['required', Rule::in(['active', 'inactive', 'prospect'])],
        ];
    }
}
