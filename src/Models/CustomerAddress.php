<?php

namespace DearPOS\DearPOSCustomer\Models;

use DearPOS\DearPOSCustomer\Observers\CustomerAddressObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([CustomerAddressObserver::class])]
class CustomerAddress extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'address_type',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'is_default',
    ];

    protected $casts = [
        'address_type' => 'string',
        'is_default' => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
