<?php

namespace DearPOS\DearPOSCustomer\Http\Controllers;

use DearPOS\DearPOSCustomer\Http\Requests\CustomerRequest;
use DearPOS\DearPOSCustomer\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class CustomerController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Customer::query()->withTrashed();

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

        return response()->json([
            'data' => $customers->map(function ($customer) {
                return [
                    'id' => $customer->id,
                    'code' => $customer->code,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'mobile' => $customer->mobile,
                    'tax_number' => $customer->tax_number,
                    'credit_limit' => $customer->credit_limit,
                    'current_balance' => $customer->current_balance,
                    'notes' => $customer->notes,
                    'status' => $customer->status,
                    'group_id' => $customer->group_id,
                    'deleted_at' => $customer->deleted_at,
                ];
            }),
            'meta' => [
                'total' => $customers->total(),
                'per_page' => $customers->perPage(),
                'current_page' => $customers->currentPage(),
                'last_page' => $customers->lastPage(),
                'from' => $customers->firstItem(),
                'to' => $customers->lastItem(),
            ],
            'links' => [
                'first' => $customers->url(1),
                'last' => $customers->url($customers->lastPage()),
                'prev' => $customers->previousPageUrl(),
                'next' => $customers->nextPageUrl(),
            ],
        ]);
    }

    public function store(CustomerRequest $request): JsonResponse
    {
        $customer = Customer::create($request->validated());

        return response()->json([
            'data' => [
                'id' => $customer->id,
                'code' => $customer->code,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'mobile' => $customer->mobile,
                'tax_number' => $customer->tax_number,
                'credit_limit' => $customer->credit_limit,
                'current_balance' => $customer->current_balance,
                'notes' => $customer->notes,
                'status' => $customer->status,
                'group_id' => $customer->group_id,
            ],
        ], Response::HTTP_CREATED);
    }

    public function show(Customer $customer): JsonResponse
    {
        return response()->json([
            'data' => [
                'id' => $customer->id,
                'code' => $customer->code,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'mobile' => $customer->mobile,
                'tax_number' => $customer->tax_number,
                'credit_limit' => $customer->credit_limit,
                'current_balance' => $customer->current_balance,
                'notes' => $customer->notes,
                'status' => $customer->status,
                'group_id' => $customer->group_id,
                'deleted_at' => $customer->deleted_at,
            ],
        ]);
    }

    public function update(CustomerRequest $request, Customer $customer): JsonResponse
    {
        $customer->update($request->validated());
        $customer->refresh();

        return response()->json([
            'data' => [
                'id' => $customer->id,
                'code' => $customer->code,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'mobile' => $customer->mobile,
                'tax_number' => $customer->tax_number,
                'credit_limit' => $customer->credit_limit,
                'current_balance' => $customer->current_balance,
                'notes' => $customer->notes,
                'status' => $customer->status,
                'group_id' => $customer->group_id,
                'deleted_at' => $customer->deleted_at,
            ],
        ]);
    }

    public function destroy(Customer $customer): Response
    {
        $customer->delete();

        return response()->noContent();
    }

    public function restore($id): JsonResponse
    {
        $customer = Customer::withTrashed()->find($id);
        $customer->restore();

        return response()->json([
            'data' => [
                'id' => $customer->id,
                'code' => $customer->code,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'mobile' => $customer->mobile,
                'tax_number' => $customer->tax_number,
                'credit_limit' => $customer->credit_limit,
                'current_balance' => $customer->current_balance,
                'notes' => $customer->notes,
                'status' => $customer->status,
                'group_id' => $customer->group_id,
            ],
        ]);
    }
}
