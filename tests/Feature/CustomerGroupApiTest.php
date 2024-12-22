<?php

namespace DearPOS\DearPOSCustomer\Tests\Feature;

use DearPOS\DearPOSCustomer\Models\CustomerGroup;
use DearPOS\DearPOSCustomer\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CustomerGroupApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_groups()
    {
        CustomerGroup::factory(3)->create();

        $response = $this->getJson('/api/customer-groups');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'discount_percentage',
                        'is_active',
                    ],
                ],
            ]);
    }

    public function test_can_create_group_via_api()
    {
        $data = [
            'name' => 'Test Group',
            'description' => 'Test Description',
            'discount_percentage' => 10,
            'is_active' => true,
        ];

        $response = $this->postJson('/api/customer-groups', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'discount_percentage',
                    'is_active',
                ],
            ]);

        $this->assertDatabaseHas('customer_groups', $data);
    }

    public function test_can_update_group_via_api()
    {
        $group = CustomerGroup::factory()->create();

        $updateData = [
            'name' => 'Updated Group',
            'description' => 'Updated description',
            'discount_percentage' => 15,
            'is_active' => false,
        ];

        $response = $this->putJson("/api/customer-groups/$group->id", $updateData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'description',
                    'discount_percentage',
                    'is_active',
                ],
            ]);

        $this->assertDatabaseHas('customer_groups', array_merge(
            ['id' => $group->id],
            $updateData
        ));
    }

    public function test_can_delete_group_via_api()
    {
        $group = CustomerGroup::factory()->create();

        $response = $this->deleteJson("/api/customer-groups/$group->id");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('customer_groups', ['id' => $group->id]);
    }

    public function test_cannot_delete_group_with_customers_via_api()
    {
        $group = CustomerGroup::factory()->create();

        $response = $this->deleteJson("/api/customer-groups/$group->id");

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['group' => 'Cannot delete group with customers']);

        $this->assertDatabaseHas('customer_groups', ['id' => $group->id]);
    }
}
