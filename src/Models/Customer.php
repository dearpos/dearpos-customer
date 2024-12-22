<?php

namespace DearPOS\DearPOSCustomer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'group_id',
        'code',
        'name',
        'email',
        'phone',
        'mobile',
        'tax_number',
        'credit_limit',
        'current_balance',
        'notes',
        'status',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:4',
        'current_balance' => 'decimal:4',
        'status' => 'string',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(CustomerGroup::class, 'group_id');
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(CustomerAddress::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(CustomerContact::class);
    }

    public function creditHistory(): HasMany
    {
        return $this->hasMany(CustomerCreditHistory::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            if (empty($customer->status)) {
                $customer->status = 'active';
            }
        });
    }
}
