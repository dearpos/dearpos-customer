<?php

namespace DearPOS\DearPOSCustomer\Tests\Unit;

use DearPOS\DearPOSCustomer\Models\Customer;
use DearPOS\DearPOSCustomer\Models\CustomerGroup;
use DearPOS\DearPOSCustomer\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;

class CustomerGroupTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_group()
    {
        $group = CustomerGroup::factory()->create();

        $this->assertDatabaseHas('customer_groups', [
            'id' => $group->id,
            'name' => $group->name,
            'description' => $group->description,
            'discount_percentage' => $group->discount_percentage,
            'is_active' => $group->is_active,
        ]);
    }

    public function test_cannot_create_group_with_duplicate_name()
    {
        $group = CustomerGroup::factory()->create();

        $this->expectException(ValidationException::class);

        CustomerGroup::factory()->create([
            'name' => $group->name,
        ]);
    }

    public function test_can_update_group()
    {
        $group = CustomerGroup::factory()->create();

        $group->update([
            'name' => 'Updated Group',
            'description' => 'Updated description',
            'discount_percentage' => 15,
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('customer_groups', [
            'id' => $group->id,
            'name' => 'Updated Group',
            'description' => 'Updated description',
            'discount_percentage' => 15,
            'is_active' => false,
        ]);
    }

    public function test_cannot_delete_group_with_customers()
    {
        $group = CustomerGroup::factory()->create();
        $customer = Customer::factory()->create(['group_id' => $group->id]);

        $this->expectException(ValidationException::class);

        $group->delete();

        $this->assertDatabaseHas('customer_groups', ['id' => $group->id]);
    }
}
