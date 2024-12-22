<?php

namespace DearPOS\DearPOSCustomer;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use DearPOS\DearPOSCustomer\Commands\DearPOSCustomerCommand;

class DearPOSCustomerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('dearpos-customer')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_dearpos_customer_table')
            ->hasCommand(DearPOSCustomerCommand::class);
    }
}
