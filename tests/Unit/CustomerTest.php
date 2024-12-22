<?php

namespace DearPOS\DearPOSCustomer\Tests\Unit;

use DearPOS\DearPOSCustomer\Models\Customer;
use DearPOS\DearPOSCustomer\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_customer()
    {
        $customer = Customer::factory()->create();

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'code' => $customer->code,
            'name' => $customer->name,
        ]);
    }

    public function test_cannot_create_customer_with_duplicate_code()
    {
        $customer = Customer::factory()->create();

        $this->expectException(\Illuminate\Database\QueryException::class);

        Customer::factory()->create([
            'code' => $customer->code,
        ]);
    }

    public function test_can_update_customer()
    {
        $customer = Customer::factory()->create();

        $customer->update([
            'name' => 'Updated Name',
            'current_balance' => 1000,
        ]);

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Updated Name',
            'current_balance' => 1000,
        ]);
    }

    public function test_can_delete_customer()
    {
        $customer = Customer::factory()->create();

        $customer->delete();

        $this->assertSoftDeleted($customer);
    }

    public function test_can_manage_customer_balance()
    {
        $customer = Customer::factory()->create([
            'current_balance' => 0,
        ]);

        $customer->update([
            'current_balance' => 1000,
        ]);

        $this->assertEquals(1000, $customer->fresh()->current_balance);

        $customer->update([
            'current_balance' => 500,
        ]);

        $this->assertEquals(500, $customer->fresh()->current_balance);
    }
}
