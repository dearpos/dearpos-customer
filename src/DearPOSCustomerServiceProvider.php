<?php

namespace DearPOS\DearPOSCustomer;

use DearPOS\DearPOSCustomer\Commands\CustomerCleanupCommand;
use DearPOS\DearPOSCustomer\Commands\CustomerCreateCommand;
use DearPOS\DearPOSCustomer\Commands\CustomerExportCommand;
use DearPOS\DearPOSCustomer\Commands\CustomerImportCommand;
use DearPOS\DearPOSCustomer\Commands\CustomerSyncBalanceCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DearPOSCustomerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('dearpos-customer')
            ->hasConfigFile()
            ->hasMigrations([
                'create_customer_groups_table',
                'create_customers_table',
                'create_customer_addresses_table',
                'create_customer_contacts_table',
                'create_customer_credit_history_table',
            ])
            ->hasCommands([
                CustomerCreateCommand::class,
                CustomerImportCommand::class,
                CustomerExportCommand::class,
                CustomerCleanupCommand::class,
                CustomerSyncBalanceCommand::class,
            ])
            ->hasRoute('api');
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
