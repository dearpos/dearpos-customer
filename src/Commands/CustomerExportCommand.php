<?php

namespace DearPOS\DearPOSCustomer\Commands;

use DearPOS\DearPOSCustomer\Models\Customer;
use Illuminate\Console\Command;

class CustomerExportCommand extends Command
{
    protected $signature = 'customer:export {file} {--format=csv}';

    protected $description = 'Export customers to a file';

    public function handle(): int
    {
        $file = $this->argument('file');
        $format = strtolower($this->option('format'));

        if ($format !== 'csv') {
            $this->error("Unsupported format: {$format}");

            return self::FAILURE;
        }

        $handle = fopen($file, 'w');

        // Write headers
        $headers = [
            'id', 'group_id', 'code', 'name', 'email', 'phone', 'mobile',
            'tax_number', 'credit_limit', 'current_balance', 'notes', 'status',
            'created_at', 'updated_at',
        ];
        fputcsv($handle, $headers);

        // Write data
        Customer::chunk(100, function ($customers) use ($handle, $headers) {
            foreach ($customers as $customer) {
                $row = [];
                foreach ($headers as $header) {
                    $row[] = $customer->$header;
                }
                fputcsv($handle, $row);
            }
        });

        fclose($handle);

        $this->info("Customers exported successfully to {$file}");

        return self::SUCCESS;
    }
}
