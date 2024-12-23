<?php

namespace DearPOS\DearPOSCustomer\Services;

use DearPOS\DearPOSCustomer\Models\Customer;
use DearPOS\DearPOSCustomer\Models\CustomerGroup;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    /**
     * @param string $id
     * @return Customer|null
     */
    public function getCustomerById(string $id): ?Customer
    {
        return Customer::find($id);
    }

    /**
     * Retrieve a customer by their code.
     *
     * @param string $code The customer's code.
     * @return Customer|null The customer, or null if not found.
     */
    public function getCustomerByCode(string $code): ?Customer
    {
        return Customer::where('code', $code)->first();
    }

    /**
     * Create a new customer with the given data.
     *
     * @param array $data The customer's data.
     * @return Customer The newly created customer.
     */

    public function createCustomer(array $data): Customer
    {
        return DB::transaction(function () use ($data) {
            return Customer::create($data);
        });
    }

    /**
     * Update a customer with the given data.
     *
     * @param Customer $customer The customer to update.
     * @param array $data The data to update the customer with.
     * @return Customer The updated customer.
     */
    public function updateCustomer(Customer $customer, array $data): Customer
    {
        return DB::transaction(function () use ($customer, $data) {
            $customer->update($data);

            return $customer->fresh();
        });
    }

    /**
     * Delete a customer.
     *
     * @param Customer $customer The customer to delete.
     * @return bool Whether the customer was deleted successfully.
     */
    public function deleteCustomer(Customer $customer): bool
    {
        return DB::transaction(function () use ($customer) {
            return $customer->delete();
        });
    }

    /**
     * Update a customer's balance.
     *
     * @param string $id The customer's ID.
     * @param float $amount The amount to add to the customer's balance.
     *
     * @throws ModelNotFoundException If the customer is not found.
     * @throws Exception If the new balance would exceed the customer's credit limit.
     *
     * @return Customer The updated customer.
     */
    public function updateCustomerBalance(string $id, float $amount): Customer
    {
        $customer = $this->getCustomerById($id);

        if (! $customer) {
            throw new ModelNotFoundException('Customer not found');
        }

        $newBalance = $customer->current_balance + $amount;

        if ($newBalance > $customer->credit_limit) {
            throw new Exception('Insufficient credit limit');
        }

        $customer->update(['current_balance' => $newBalance]);

        return $customer;
    }

    /**
     * Retrieve a customer group by its ID.
     *
     * @param string $id The group's ID.
     * @return CustomerGroup|null The group, or null if not found.
     */
    public function getGroupById(string $id): ?CustomerGroup
    {
        return CustomerGroup::find($id);
    }

    /**
     * Create a new customer group with the given data.
     *
     * @param array $data The data to create the group with.
     * @return CustomerGroup The newly created group.
     */
    public function createGroup(array $data): CustomerGroup
    {
        return DB::transaction(function () use ($data) {
            return CustomerGroup::create($data);
        });
    }

    public function updateGroup(CustomerGroup $group, array $data): CustomerGroup
    {
        return DB::transaction(function () use ($group, $data) {
            $group->update($data);

            return $group->fresh();
        });
    }

    public function deleteGroup(CustomerGroup $group): bool
    {
        return DB::transaction(function () use ($group) {
            return $group->delete();
        });
    }

    public function addAddress(Customer $customer, array $data): void
    {
        DB::transaction(function () use ($customer, $data) {
            $address = $customer->addresses()->create($data);

            if ($data['is_default'] ?? false) {
                $customer->addresses()
                    ->where('id', '!=', $address->id)
                    ->where('address_type', $address->address_type)
                    ->update(['is_default' => false]);
            }
        });
    }

    public function addContact(Customer $customer, array $data): void
    {
        DB::transaction(function () use ($customer, $data) {
            $contact = $customer->contacts()->create($data);

            if ($data['is_primary'] ?? false) {
                $customer->contacts()
                    ->where('id', '!=', $contact->id)
                    ->update(['is_primary' => false]);
            }
        });
    }

    public function addCredit(Customer $customer, array $data): void
    {
        DB::transaction(function () use ($customer, $data) {
            // Calculate balance change
            $amount = $data['amount'];
            if ($data['transaction_type'] === 'decrease') {
                $amount = -$amount;
            }

            $newBalance = $customer->current_balance + $amount;

            // Validate credit limit
            if ($newBalance > $customer->credit_limit) {
                throw new Exception('Transaction would exceed credit limit');
            }

            // Create credit history
            $customer->creditHistory()->create($data);

            // Update customer balance
            $customer->update(['current_balance' => $newBalance]);
        });
    }

    public function importCustomers(array $data): SupportCollection
    {
        return DB::transaction(function () use ($data) {
            $customers = collect();

            foreach ($data as $customerData) {
                $customer = $this->createCustomer($customerData);
                $customers->push($customer);

                // Import alamat jika ada
                if (! empty($customerData['addresses'])) {
                    foreach ($customerData['addresses'] as $addressData) {
                        $this->addAddress($customer, $addressData);
                    }
                }

                // Import kontak jika ada
                if (! empty($customerData['contacts'])) {
                    foreach ($customerData['contacts'] as $contactData) {
                        $this->addContact($customer, $contactData);
                    }
                }
            }

            return $customers;
        });
    }

    public function exportCustomers(): Collection
    {
        return Customer::with(['group', 'addresses', 'contacts', 'creditHistory'])->get();
    }

    public function cleanupCustomers(): int
    {
        return DB::transaction(function () {
            return Customer::onlyTrashed()->forceDelete();
        });
    }

    public function syncCustomerBalances(): void
    {
        DB::transaction(function () {
            $customers = Customer::all();

            foreach ($customers as $customer) {
                $totalCredit = $customer->creditHistory()
                    ->selectRaw('SUM(CASE WHEN transaction_type = "increase" THEN amount ELSE -amount END) as total')
                    ->value('total') ?? 0;

                $customer->update(['current_balance' => $totalCredit]);
            }
        });
    }
}
