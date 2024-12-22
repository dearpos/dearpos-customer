<?php

namespace DearPOS\DearPOSCustomer\Http\Requests;

use DearPOS\DearPOSCustomer\Models\CustomerGroup;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerGroupRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => [
                'required', 
                'string', 
                'max:255',
                Rule::unique('customer_groups')->ignore($this->route('customerGroup')),
            ],
            'description' => ['nullable', 'string'],
            'discount_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'is_active' => ['required', 'boolean'],
        ];

        return $rules;
    }
}
