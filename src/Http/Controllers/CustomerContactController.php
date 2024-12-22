<?php

namespace DearPOS\DearPOSCustomer\Http\Controllers;

use DearPOS\DearPOSCustomer\Http\Requests\CustomerContactRequest;
use DearPOS\DearPOSCustomer\Http\Resources\CustomerContactCollection;
use DearPOS\DearPOSCustomer\Http\Resources\CustomerContactResource;
use DearPOS\DearPOSCustomer\Models\Customer;
use DearPOS\DearPOSCustomer\Models\CustomerContact;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CustomerContactController extends Controller
{
    public function index(Request $request, Customer $customer)
    {
        $perPage = $request->input('per_page', 15);
        $contacts = $customer->contacts()->paginate($perPage);

        return new CustomerContactCollection($contacts);
    }

    public function store(CustomerContactRequest $request, Customer $customer)
    {
        $contact = $customer->contacts()->create($request->validated());

        if ($request->input('is_primary')) {
            $customer->contacts()
                ->where('id', '!=', $contact->id)
                ->update(['is_primary' => false]);
        }

        return new CustomerContactResource($contact);
    }

    public function show(Customer $customer, CustomerContact $contact)
    {
        if ($contact->customer_id !== $customer->id) {
            abort(404);
        }

        return new CustomerContactResource($contact);
    }

    public function update(CustomerContactRequest $request, Customer $customer, CustomerContact $contact)
    {
        if ($contact->customer_id !== $customer->id) {
            abort(404);
        }

        $contact->update($request->validated());

        if ($request->input('is_primary')) {
            $customer->contacts()
                ->where('id', '!=', $contact->id)
                ->update(['is_primary' => false]);
        }

        return new CustomerContactResource($contact);
    }

    public function destroy(Customer $customer, CustomerContact $contact)
    {
        if ($contact->customer_id !== $customer->id) {
            abort(404);
        }

        $contact->delete();

        return response()->noContent();
    }
}
