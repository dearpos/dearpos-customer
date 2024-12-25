<?php

namespace DearPOS\DearPOSCustomer\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
* @property int $id
* @property int $customer_id
* @property string $transaction_type
* @property float $amount
* @property string $reference_type
* @property int $reference_id
* @property string|null $notes
* @property int $created_by
* @property object|null $createdBy
* @property \DateTime $created_at
* @property \DateTime $updated_at
*/
class CustomerCreditResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'transaction_type' => $this->transaction_type,
            'amount' => $this->amount,
            'reference_type' => $this->reference_type,
            'reference_id' => $this->reference_id,
            'notes' => $this->notes,
            'created_by' => $this->created_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by_user' => $this->whenLoaded('createdBy', function () {
                return [
                    'id' => $this->createdBy->id,
                    'name' => $this->createdBy->name,
                ];
            }),
        ];
    }
}
