<?php

namespace DearPOS\DearPOSCustomer\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property int $customer_id
 * @property string $name
 * @property string|null $position
 * @property string|null $phone
 * @property string|null $mobile
 * @property string $email
 * @property bool $is_primary
 * @property \DateTime $created_at
 * @property \DateTime $updated_at
 */
class CustomerContactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'name' => $this->name,
            'position' => $this->position,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'is_primary' => $this->is_primary,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
