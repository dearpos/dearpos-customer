<?php

namespace DearPOS\DearPOSCustomer\Http\Controllers;

use DearPOS\DearPOSCustomer\Http\Requests\CustomerAddressRequest;
use DearPOS\DearPOSCustomer\Http\Resources\CustomerAddressCollection;
use DearPOS\DearPOSCustomer\Http\Resources\CustomerAddressResource;
use DearPOS\DearPOSCustomer\Models\Customer;
use DearPOS\DearPOSCustomer\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CustomerAddressController extends Controller
{
    public function index(Request $request, Customer $customer)
    {
        $query = $customer->addresses();

        if ($request->has('type')) {
            $query->where('address_type', $request->type);
        }

        $perPage = $request->input('per_page', 15);
        $addresses = $query->paginate($perPage);

        return new CustomerAddressCollection($addresses);
    }

    public function store(CustomerAddressRequest $request, Customer $customer)
    {
        $address = $customer->addresses()->create($request->validated());

        if ($request->input('is_default')) {
            $customer->addresses()
                ->where('id', '!=', $address->id)
                ->where('address_type', $address->address_type)
                ->update(['is_default' => false]);
        }

        return new CustomerAddressResource($address);
    }

    public function show(Customer $customer, CustomerAddress $address)
    {
        if ($address->customer_id !== $customer->id) {
            abort(404);
        }

        return new CustomerAddressResource($address);
    }

    public function update(CustomerAddressRequest $request, Customer $customer, CustomerAddress $address)
    {
        if ($address->customer_id !== $customer->id) {
            abort(404);
        }

        $address->update($request->validated());

        if ($request->input('is_default')) {
            $customer->addresses()
                ->where('id', '!=', $address->id)
                ->where('address_type', $address->address_type)
                ->update(['is_default' => false]);
        }

        return new CustomerAddressResource($address);
    }

    public function destroy(Customer $customer, CustomerAddress $address)
    {
        if ($address->customer_id !== $customer->id) {
            abort(404);
        }

        if ($customer->addresses()->count() === 1) {
            return response()->json([
                'message' => 'Cannot delete the last address',
            ], 422);
        }

        $address->delete();

        return response()->noContent();
    }
}
