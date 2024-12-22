<?php

namespace DearPOS\DearPOSCustomer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'position' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'is_primary' => ['boolean'],
        ];

        // Setidaknya salah satu dari phone atau mobile harus diisi
        $rules['phone'][] = Rule::requiredIf(function () {
            return empty($this->mobile);
        });

        $rules['mobile'][] = Rule::requiredIf(function () {
            return empty($this->phone);
        });

        return $rules;
    }
}
