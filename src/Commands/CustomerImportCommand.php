<?php

namespace DearPOS\DearPOSCustomer\Commands;

use DearPOS\DearPOSCustomer\Services\CustomerService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CustomerImportCommand extends Command
{
    protected $signature = 'customer:import {file} {--format=csv}';

    protected $description = 'Import customers from a file';

    public function handle(CustomerService $service): int
    {
        $file = $this->argument('file');
        
        if (!file_exists($file)) {
            $this->error("File not found: {$file}");
            return self::FAILURE;
        }

        $format = strtolower($this->option('format'));
        if ($format !== 'csv') {
            $this->error("Unsupported format: {$format}");
            return self::FAILURE;
        }

        $handle = fopen($file, 'r');
        $headers = fgetcsv($handle);
        $count = 0;
        $errors = [];

        while (($data = fgetcsv($handle)) !== false) {
            $row = array_combine($headers, $data);
            
            try {
                $validator = Validator::make($row, [
                    'name' => 'required|string|max:100',
                    'code' => 'required|string|max:50|unique:customers,code',
                    'email' => 'nullable|email|max:100|unique:customers,email',
                ]);

                if ($validator->fails()) {
                    $errors[] = "Row {$count}: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                $service->createCustomer($row);
                $count++;
            } catch (\Exception $e) {
                $errors[] = "Row {$count}: " . $e->getMessage();
            }
        }

        fclose($handle);

        $this->info("Imported {$count} customers successfully.");
        
        if (!empty($errors)) {
            $this->error("Encountered " . count($errors) . " errors:");
            foreach ($errors as $error) {
                $this->error($error);
            }
        }

        return empty($errors) ? self::SUCCESS : self::FAILURE;
    }
}
