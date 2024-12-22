<?php

namespace DearPOS\DearPOSCustomer\Commands;

use DearPOS\DearPOSCustomer\Models\Customer;
use DearPOS\DearPOSCustomer\Models\CustomerGroup;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class CustomerCleanupCommand extends Command
{
    protected $signature = 'customer:cleanup {--days=30}';

    protected $description = 'Clean up soft deleted customer data';

    public function handle(): int
    {
        $days = (int) $this->option('days');
        $date = Carbon::now()->subDays($days);

        $customersCount = Customer::onlyTrashed()
            ->where('deleted_at', '<=', $date)
            ->forceDelete();

        $groupsCount = CustomerGroup::onlyTrashed()
            ->where('deleted_at', '<=', $date)
            ->forceDelete();

        $this->info("Cleaned up {$customersCount} customers and {$groupsCount} groups older than {$days} days");
        return self::SUCCESS;
    }
}
