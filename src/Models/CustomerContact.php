<?php

namespace DearPOS\DearPOSCustomer\Models;

/**
 * @property string $id UUID of the contact
 * @property string $customer_id UUID of the associated customer
 * @property string $name Full name of the contact person
 * @property string $position Job position/title of the contact
 * @property string $phone Office/landline phone number
 * @property string $mobile Mobile phone number
 * @property string $email Email address
 * @property bool $is_primary Whether this is the primary contact
 * @property \Carbon\Carbon $created_at Creation timestamp
 * @property \Carbon\Carbon $updated_at Update timestamp
 * @property \Carbon\Carbon|null $deleted_at Soft delete timestamp
 */

namespace DearPOS\DearPOSCustomer\Models;

use DearPOS\DearPOSCustomer\Observers\CustomerContactObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id UUID of the contact
 * @property string $customer_id UUID of the associated customer
 * @property string $name Full name of the contact
 * @property string $position Job position/title
 * @property string $phone Office/landline phone number
 * @property string $mobile Mobile phone number
 * @property string $email Email address
 * @property bool $is_primary Whether this is the primary contact
 * @property \Carbon\Carbon $created_at Creation timestamp
 * @property \Carbon\Carbon $updated_at Update timestamp
 * @property \Carbon\Carbon|null $deleted_at Soft delete timestamp
 */
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
