<?php

namespace DearPOS\DearPOSCustomer\Commands;

use Illuminate\Console\Command;

class DearPOSCustomerCommand extends Command
{
    public $signature = 'dearpos-customer';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
