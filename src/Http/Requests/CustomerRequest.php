<?php

namespace DearPOS\DearPOSCustomer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'group_id' => ['nullable', 'uuid', 'exists:customer_groups,id'],
            'code' => ['required', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'tax_number' => ['nullable', 'string', 'max:50'],
            'credit_limit' => ['numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
            'status' => ['string', 'in:active,inactive,blocked'],
        ];

        if ($this->isMethod('POST')) {
            $rules['code'][] = 'unique:customers,code';
            $rules['email'][] = 'unique:customers,email';
        }

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['code'][] = 'unique:customers,code,'.$this->route('customer')->id;
            $rules['email'][] = 'unique:customers,email,'.$this->route('customer')->id;
        }

        return $rules;
    }
}
