<?php

namespace DearPOS\DearPOSCustomer\Observers;

use DearPOS\DearPOSCustomer\Models\CustomerContact;

class CustomerContactObserver
{
    public function creating(CustomerContact $customerContact): void
    {
        // If this is the first contact, set as primary
        if (!$customerContact->exists()) {
            $customerContact->is_primary = true;
        }
    }

    public function saved(CustomerContact $customerContact): void
    {
        // If set as primary, update other contacts
        if ($customerContact->is_primary) {
            $customerContact
                ->where('id', '!=', $customerContact->id)
                ->update(['is_primary' => false]);
        }
    }
}
