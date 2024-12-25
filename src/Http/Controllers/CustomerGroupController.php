<?php

namespace DearPOS\DearPOSCustomer\Http\Controllers;

use DearPOS\DearPOSCustomer\Http\Requests\CustomerGroupRequest;
use DearPOS\DearPOSCustomer\Http\Resources\CustomerGroupCollection;
use DearPOS\DearPOSCustomer\Http\Resources\CustomerGroupResource;
use DearPOS\DearPOSCustomer\Models\CustomerGroup;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class CustomerGroupController extends Controller
{
    public function index(Request $request): CustomerGroupCollection
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

    public function store(CustomerGroupRequest $request): CustomerGroupResource
    {
        $customerGroup = CustomerGroup::create($request->validated());

        return new CustomerGroupResource($customerGroup);
    }

    public function show(CustomerGroup $customerGroup): CustomerGroupResource
    {
        return new CustomerGroupResource($customerGroup);
    }

    public function update(CustomerGroupRequest $request, CustomerGroup $customerGroup): CustomerGroupResource
    {
        $customerGroup->update($request->validated());

        return new CustomerGroupResource($customerGroup->refresh());
    }

    public function destroy(CustomerGroup $customerGroup): \Illuminate\Http\JsonResponse
    {
        if ($customerGroup->customers()->exists()) {
            throw ValidationException::withMessages([
                'group' => 'Cannot delete group with customers',
            ]);
        }

        $customerGroup->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
