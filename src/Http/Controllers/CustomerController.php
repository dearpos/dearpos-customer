<?php

namespace DearPOS\DearPOSCustomer\Http\Controllers;

use DearPOS\DearPOSCustomer\Http\Requests\CustomerRequest;
use DearPOS\DearPOSCustomer\Http\Resources\CustomerCollection;
use DearPOS\DearPOSCustomer\Http\Resources\CustomerResource;
use DearPOS\DearPOSCustomer\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('code', 'like', "%{$request->search}%");
            });
        }

        if ($request->has('group_id')) {
            $query->where('group_id', $request->group_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->input('per_page', 15);
        $customers = $query->paginate($perPage);

        return new CustomerCollection($customers);
    }

    public function store(CustomerRequest $request)
    {
        $customer = Customer::create($request->validated());

        return new CustomerResource($customer);
    }

    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    public function update(CustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());

        return new CustomerResource($customer);
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->noContent();
    }
}
