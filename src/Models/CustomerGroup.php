<?php

namespace DearPOS\DearPOSCustomer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;  
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
* @property string $id UUID of the customer group
* @property string $name Name of the group
* @property string $description Description of the group
* @property float $discount_percentage Discount percentage for the group
* @property bool $is_active Whether the group is active
* @property \Carbon\Carbon $created_at Creation timestamp
* @property \Carbon\Carbon $updated_at Update timestamp  
* @property \Carbon\Carbon|null $deleted_at Soft delete timestamp
*/

namespace DearPOS\DearPOSCustomer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerGroup extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'discount_percentage',
        'is_active',
    ];

    protected $casts = [
        'discount_percentage' => 'decimal:4',
        'is_active' => 'boolean',
    ];

    protected $attributes = [
        'discount_percentage' => 0,
        'is_active' => true,
    ];

    public function customers(): HasMany
    {
        return $this->hasMany(Customer::class, 'group_id');
    }
}
