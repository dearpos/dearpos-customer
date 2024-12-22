<?php

namespace DearPOS\DearPOSCustomer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerCreditHistory extends Model
{
    use HasUuids;

    protected $fillable = [
        'customer_id',
        'transaction_type',
        'amount',
        'reference_type',
        'reference_id',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'transaction_type' => 'string',
        'amount' => 'decimal:4',
        'reference_type' => 'string',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.model'), 'created_by');
    }
}
