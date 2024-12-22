<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Customer Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can configure various settings for the customer package.
    |
    */

    // Database table names
    'table_names' => [
        'customers' => 'customers',
        'customer_groups' => 'customer_groups',
    ],

    // Default customer settings
    'defaults' => [
        'credit_limit' => 1000000, // Default credit limit for new customers
        'balance' => 0, // Default starting balance for new customers
    ],

    // Validation rules
    'validation' => [
        'code' => [
            'unique' => true, // Whether customer code should be unique
            'format' => 'CUST%d', // Format for auto-generated customer codes
        ],
    ],
];
