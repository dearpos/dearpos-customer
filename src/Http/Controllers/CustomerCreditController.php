<?php

namespace DearPOS\DearPOSCustomer\Http\Controllers;

use DearPOS\DearPOSCustomer\Http\Requests\CustomerCreditRequest;
use DearPOS\DearPOSCustomer\Http\Resources\CustomerCreditCollection;
use DearPOS\DearPOSCustomer\Http\Resources\CustomerCreditResource;
use DearPOS\DearPOSCustomer\Models\Customer;
use DearPOS\DearPOSCustomer\Models\CustomerCreditHistory;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class CustomerCreditController extends Controller
{
    public function index(Request $request, Customer $customer)
    {
        $query = $customer->creditHistory();

        if ($request->has('type')) {
            $query->where('transaction_type', $request->type);
        }

        if ($request->has('reference_type')) {
            $query->where('reference_type', $request->reference_type);
        }

        $perPage = $request->input('per_page', 15);
        $credits = $query->paginate($perPage);

        return new CustomerCreditCollection($credits);
    }

    public function store(CustomerCreditRequest $request, Customer $customer)
    {
        return DB::transaction(function () use ($request, $customer) {
            $data = $request->validated();
            $data['created_by'] = request()->user()->id;

            $credit = $customer->creditHistory()->create($data);

            // Update customer balance
            $amount = $data['amount'];
            if ($data['transaction_type'] === 'decrease') {
                $amount = -$amount;
            }

            $newBalance = $customer->current_balance + $amount;

            if ($newBalance > $customer->credit_limit) {
                throw new \Exception('Transaction would exceed credit limit');
            }

            $customer->update(['current_balance' => $newBalance]);

            return new CustomerCreditResource($credit);
        });
    }

    public function show(Customer $customer, CustomerCreditHistory $credit)
    {
        if ($credit->customer_id !== $customer->id) {
            abort(404);
        }

        return new CustomerCreditResource($credit);
    }
}
