<?php

namespace DearPOS\DearPOSCustomer\Http\Controllers;

use DearPOS\DearPOSCustomer\Http\Requests\CustomerGroupRequest;
use DearPOS\DearPOSCustomer\Http\Resources\CustomerGroupCollection;
use DearPOS\DearPOSCustomer\Http\Resources\CustomerGroupResource;
use DearPOS\DearPOSCustomer\Models\CustomerGroup;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CustomerGroupController extends Controller
{
    public function index(Request $request)
    {
        $query = CustomerGroup::query();

        if ($request->has('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->has('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $perPage = $request->input('per_page', 15);
        $customerGroups = $query->paginate($perPage);

        return new CustomerGroupCollection($customerGroups);
    }

    public function store(CustomerGroupRequest $request)
    {
        $customerGroup = CustomerGroup::create($request->validated());

        return new CustomerGroupResource($customerGroup);
    }

    public function show(CustomerGroup $customerGroup)
    {
        return new CustomerGroupResource($customerGroup);
    }

    public function update(CustomerGroupRequest $request, CustomerGroup $customerGroup)
    {
        $customerGroup->update($request->validated());

        return new CustomerGroupResource($customerGroup);
    }

    public function destroy(CustomerGroup $customerGroup)
    {
        if ($customerGroup->customers()->exists()) {
            return response()->json([
                'message' => 'Cannot delete group with active customers',
            ], 422);
        }

        $customerGroup->delete();

        return response()->noContent();
    }
}
