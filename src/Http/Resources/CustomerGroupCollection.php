<?php

namespace DearPOS\DearPOSCustomer\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerGroupCollection extends ResourceCollection
{
    public $collects = CustomerGroupResource::class;
}
