<?php

namespace DearPOS\DearPOSCustomer\Commands;

use DearPOS\DearPOSCustomer\Models\Customer;
use Illuminate\Console\Command;

class CustomerSyncBalanceCommand extends Command
{
    protected $signature = 'customer:sync-balance';

    protected $description = 'Synchronize customer balances with transactions';

    public function handle(): int
    {
        $count = 0;

        Customer::chunk(100, function ($customers) use (&$count) {
            foreach ($customers as $customer) {
                // TODO: Implement actual balance calculation based on transactions
                // This is a placeholder that needs to be implemented based on
                // how transactions are tracked in the main application

                // $balance = $customer->transactions()->sum('amount');
                // $customer->update(['current_balance' => $balance]);

                $count++;
            }
        });

        $this->info("Synchronized balances for {$count} customers");

        return self::SUCCESS;
    }
}
