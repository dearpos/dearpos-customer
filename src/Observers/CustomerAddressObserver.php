<?php

namespace DearPOS\DearPOSCustomer\Observers;

use DearPOS\DearPOSCustomer\Models\CustomerAddress;

class CustomerAddressObserver
{
    public function creating(CustomerAddress $customerAddress): void
    {
        if (!$customerAddress->exists()) {
            $customerAddress->is_default = true;
        }
    }

    public function saved(CustomerAddress $customerAddress): void
    {
        if ($customerAddress->is_default) {
            $customerAddress
                ->where('id', '!=', $customerAddress->id)
                ->where('address_type', $customerAddress->address_type)
                ->update(['is_default' => false]);
        }
    }
}
