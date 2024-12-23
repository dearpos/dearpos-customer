<?php

namespace DearPOS\DearPOSCustomer\Models;

use DearPOS\DearPOSCustomer\Observers\CustomerContactObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([CustomerContactObserver::class])]
class CustomerContact extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'name',
        'position',
        'phone',
        'mobile',
        'email',
        'is_primary',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
