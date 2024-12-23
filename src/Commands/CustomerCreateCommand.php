<?php

namespace DearPOS\DearPOSCustomer\Commands;

use DearPOS\DearPOSCustomer\Services\CustomerService;
use Exception;
use Illuminate\Console\Command;

class CustomerCreateCommand extends Command
{
    protected $signature = 'customer:create {name} {--code=} {--email=} {--group=}';

    protected $description = 'Create a new customer';

    public function handle(CustomerService $service): int
    {
        $data = [
            'name' => $this->argument('name'),
            'code' => $this->option('code') ?? strtoupper(uniqid('CUST')),
            'email' => $this->option('email'),
            'group_id' => $this->option('group'),
        ];

        try {
            $customer = $service->createCustomer($data);
            $this->info("Customer created successfully with ID: $customer->id");

            return self::SUCCESS;
        } catch (Exception $e) {
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
}
