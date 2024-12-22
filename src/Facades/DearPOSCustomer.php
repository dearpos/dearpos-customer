<?php

namespace DearPOS\DearPOSCustomer\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \DearPOS\DearPOSCustomer\DearPOSCustomer
 */
class DearPOSCustomer extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \DearPOS\DearPOSCustomer\DearPOSCustomer::class;
    }
}
