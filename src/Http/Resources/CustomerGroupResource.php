<?php

namespace DearPOS\DearPOSCustomer\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
* @property int $id
* @property string $name
* @property string|null $description
* @property float $discount_percentage
* @property bool $is_active
* @property \DateTime $created_at
* @property \DateTime $updated_at
* @method \Illuminate\Database\Eloquent\Relations\HasMany customers()
*/
class CustomerGroupResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'discount_percentage' => $this->discount_percentage,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'customers_count' => $this->when($request->routeIs('customer-groups.index'),
                fn () => $this->customers()->count()
            ),
        ];
    }
}
