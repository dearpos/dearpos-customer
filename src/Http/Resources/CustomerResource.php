<?php

namespace DearPOS\DearPOSCustomer\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $tax_number
 * @property float $credit_limit
 * @property float $current_balance
 * @property string|null $notes
 * @property string $status
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'group' => new CustomerGroupResource($this->whenLoaded('group')),
            'code' => $this->code,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'tax_number' => $this->tax_number,
            'credit_limit' => $this->credit_limit,
            'current_balance' => $this->current_balance,
            'notes' => $this->notes,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
