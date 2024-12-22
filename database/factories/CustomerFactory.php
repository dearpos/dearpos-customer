<?php

namespace DearPOS\DearPOSCustomer\Database\Factories;

use DearPOS\DearPOSCustomer\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'id' => $this->faker->uuid(),
            'code' => 'CUST' . fake()->numberBetween(100, 999),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'mobile' => fake()->phoneNumber(),
            'tax_number' => fake()->optional()->numerify('###.###.###-##'),
            'credit_limit' => fake()->randomFloat(2, 1000, 1000000),
            'current_balance' => 0,
            'notes' => fake()->optional()->text(),
            'status' => 'active',
            'group_id' => null,
        ];
    }
}
