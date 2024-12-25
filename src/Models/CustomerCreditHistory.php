<?php

namespace DearPOS\DearPOSCustomer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
* @property string $id UUID of the credit history entry
* @property string $customer_id UUID of the associated customer
* @property string $transaction_type Type of credit transaction
* @property float $amount Transaction amount
* @property string $reference_type Type of reference document
* @property string $reference_id UUID of reference document
* @property string|null $notes Additional notes
* @property string $created_by UUID of user who created the entry
* @property \Carbon\Carbon $created_at Creation timestamp
* @property \Carbon\Carbon $updated_at Update timestamp
* @property \Carbon\Carbon|null $deleted_at Soft delete timestamp
*/

namespace DearPOS\DearPOSCustomer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
* @property string $id UUID of the credit history entry
* @property string $customer_id UUID of the associated customer
* @property string $transaction_type Type of credit transaction
* @property float $amount Transaction amount
* @property string $reference_type Type of reference document
* @property string $reference_id UUID of reference document
* @property string|null $notes Additional notes
* @property string $created_by UUID of user who created the entry
* @property \Carbon\Carbon $created_at Creation timestamp
* @property \Carbon\Carbon $updated_at Update timestamp
* @property \Carbon\Carbon|null $deleted_at Soft delete timestamp
*/
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
