<?php

namespace DearPOS\DearPOSCustomer\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerCreditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transaction_type' => ['required', 'string', 'in:increase,decrease,adjustment'],
            'amount' => ['required', 'numeric', 'min:0'],
            'reference_type' => ['required', 'string', 'in:sales_order,payment,credit_note,manual'],
            'reference_id' => ['nullable', 'uuid'],
            'notes' => ['nullable', 'string'],
        ];
    }
}
