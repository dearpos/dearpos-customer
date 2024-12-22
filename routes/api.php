<?php

use DearPOS\DearPOSCustomer\Http\Controllers\CustomerController;
use DearPOS\DearPOSCustomer\Http\Controllers\CustomerGroupController;
use DearPOS\DearPOSCustomer\Http\Controllers\CustomerAddressController;
use DearPOS\DearPOSCustomer\Http\Controllers\CustomerContactController;
use DearPOS\DearPOSCustomer\Http\Controllers\CustomerCreditController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    // Customer Groups
    Route::apiResource('customer-groups', CustomerGroupController::class);

    // Customers
    Route::apiResource('customers', CustomerController::class);

    // Customer Addresses
    Route::apiResource('customers.addresses', CustomerAddressController::class);

    // Customer Contacts
    Route::apiResource('customers.contacts', CustomerContactController::class);

    // Customer Credits
    Route::apiResource('customers.credits', CustomerCreditController::class)->only(['index', 'store', 'show']);
});
