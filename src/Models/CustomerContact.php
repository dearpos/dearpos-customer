<?php

namespace DearPOS\DearPOSCustomer\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contact) {
            // Jika ini kontak pertama, set sebagai primer
            if (! $contact->customer->contacts()->exists()) {
                $contact->is_primary = true;
            }
        });

        static::saved(function ($contact) {
            // Jika diset sebagai primer, update kontak lain
            if ($contact->is_primary) {
                $contact->customer->contacts()
                    ->where('id', '!=', $contact->id)
                    ->update(['is_primary' => false]);
            }
        });
    }
}
