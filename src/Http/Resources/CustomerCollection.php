<?php

namespace DearPOS\DearPOSCustomer\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerCollection extends ResourceCollection
{
    public $collects = CustomerResource::class;
}
