<?php

namespace DearPOS\DearPOSCustomer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($address) {
            // If this is the first address, set as default
            if (! $address->customer->addresses()->exists()) {
                $address->is_default = true;
            }
        });

        static::saved(function ($address) {
            // If set as default, update other addresses with the same type
            if ($address->is_default) {
                $address->customer->addresses()
                    ->where('id', '!=', $address->id)
                    ->where('address_type', $address->address_type)
                    ->update(['is_default' => false]);
            }
        });
    }
}
