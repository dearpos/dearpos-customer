<?php

namespace DearPOS\DearPOSCustomer\Tests\Feature;

use DearPOS\DearPOSCustomer\Models\Customer;
use DearPOS\DearPOSCustomer\Models\CustomerGroup;
use DearPOS\DearPOSCustomer\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_customers()
    {
        Customer::factory(3)->create();

        $response = $this->getJson('/api/customers');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'code',
                        'name',
                        'email',
                        'phone',
                        'mobile',
                        'tax_number',
                        'credit_limit',
                        'notes',
                        'status',
                        'group_id',
                    ],
                ],
            ]);
    }

    public function test_can_create_customer_via_api()
    {
        $group = CustomerGroup::factory()->create();

        $data = [
            'code' => 'CUST001',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'mobile' => '0987654321',
            'tax_number' => 'TAX001',
            'credit_limit' => 1000,
            'notes' => 'Test notes',
            'status' => 'active',
            'group_id' => $group->id,
        ];

        $response = $this->postJson('/api/customers', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'code',
                    'name',
                    'email',
                    'phone',
                    'mobile',
                    'tax_number',
                    'credit_limit',
                    'notes',
                    'status',
                    'group_id',
                ],
            ]);

        $this->assertDatabaseHas('customers', $data);
    }

    public function test_can_update_customer_via_api()
    {
        $customer = Customer::factory()->create();
        $group = CustomerGroup::factory()->create();

        $updateData = [
            'code' => $customer->code,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone' => '1234567890',
            'mobile' => '0987654321',
            'tax_number' => 'TAX002',
            'credit_limit' => 2000,
            'notes' => 'Updated notes',
            'status' => 'active',
            'group_id' => $group->id,
        ];

        $response = $this->putJson("/api/customers/{$customer->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'code',
                    'name',
                    'email',
                    'phone',
                    'mobile',
                    'tax_number',
                    'credit_limit',
                    'notes',
                    'status',
                    'group_id',
                ],
            ]);

        $this->assertDatabaseHas('customers', array_merge(
            ['id' => $customer->id],
            $updateData
        ));
    }

    public function test_can_delete_customer_via_api()
    {
        $customer = Customer::factory()->create();

        $response = $this->deleteJson("/api/customers/{$customer->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted('customers', [
            'id' => $customer->id,
        ]);
    }
}
