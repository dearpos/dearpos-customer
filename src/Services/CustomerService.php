<?php

namespace DearPOS\DearPOSCustomer\Services;

use DearPOS\DearPOSCustomer\Models\Customer;
use DearPOS\DearPOSCustomer\Models\CustomerGroup;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CustomerService
{
    public function getCustomerById(string $id): ?Customer
    {
        return Customer::find($id);
    }

    public function getCustomerByCode(string $code): ?Customer
    {
        return Customer::where('code', $code)->first();
    }

    public function createCustomer(array $data): Customer
    {
        return DB::transaction(function () use ($data) {
            return Customer::create($data);
        });
    }

    public function updateCustomer(Customer $customer, array $data): Customer
    {
        return DB::transaction(function () use ($customer, $data) {
            $customer->update($data);
            return $customer->fresh();
        });
    }

    public function deleteCustomer(Customer $customer): bool
    {
        return DB::transaction(function () use ($customer) {
            return $customer->delete();
        });
    }

    public function updateCustomerBalance(string $id, float $amount): Customer
    {
        $customer = $this->getCustomerById($id);

        if (!$customer) {
            throw new ModelNotFoundException("Customer not found");
        }

        $newBalance = $customer->current_balance + $amount;

        if ($newBalance > $customer->credit_limit) {
            throw new \Exception("Insufficient credit limit");
        }

        $customer->update(['current_balance' => $newBalance]);

        return $customer;
    }

    public function getGroupById(string $id): ?CustomerGroup
    {
        return CustomerGroup::find($id);
    }

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
            // Hitung perubahan saldo
            $amount = $data['amount'];
            if ($data['transaction_type'] === 'decrease') {
                $amount = -$amount;
            }

            $newBalance = $customer->current_balance + $amount;

            // Validasi batas kredit
            if ($newBalance > $customer->credit_limit) {
                throw new \Exception('Transaction would exceed credit limit');
            }

            // Buat riwayat kredit
            $customer->creditHistory()->create($data);

            // Update saldo pelanggan
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
                if (!empty($customerData['addresses'])) {
                    foreach ($customerData['addresses'] as $addressData) {
                        $this->addAddress($customer, $addressData);
                    }
                }

                // Import kontak jika ada
                if (!empty($customerData['contacts'])) {
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
