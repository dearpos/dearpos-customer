<?php

namespace DearPOS\DearPOSCustomer\Http\Requests;

use DearPOS\DearPOSCustomer\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'code' => [
                'required', 
                'string', 
                'max:255',
                Rule::unique('customers')->ignore($this->route('customer')),
            ],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:255'],
            'tax_number' => ['nullable', 'string', 'max:255'],
            'credit_limit' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:active,inactive'],
            'group_id' => ['nullable', 'exists:customer_groups,id'],
        ];

        return $rules;
    }
}
