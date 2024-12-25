<?php

namespace DearPOS\DearPOSCustomer\Models;

/**
* @property string $id
* @property string $group_id
* @property string $code
* @property string $name
* @property string $email
* @property string $phone
* @property string $mobile
* @property string $tax_number
* @property float $credit_limit
* @property float $current_balance
* @property string $notes
* @property string $status
* @property \Carbon\Carbon $created_at
* @property \Carbon\Carbon $updated_at
* @property \Carbon\Carbon|null $deleted_at
*/

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
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
        'credit_limit' => 'decimal:2',
        'current_balance' => 'decimal:2',
    ];

    protected $attributes = [
        'credit_limit' => 0,
        'current_balance' => 0,
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
}
