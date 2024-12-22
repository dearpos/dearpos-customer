<?php

namespace DearPOS\DearPOSCustomer\Http\Requests;

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
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'discount_percentage' => ['numeric', 'min:0', 'max:100'],
            'is_active' => ['boolean'],
        ];

        if ($this->isMethod('POST')) {
            $rules['name'][] = 'unique:customer_groups,name';
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['name'][] = 'unique:customer_groups,name,'.$this->route('customer_group')->id;
        }

        return $rules;
    }
}
