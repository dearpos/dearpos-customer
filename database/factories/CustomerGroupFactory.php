<?php

namespace DearPOS\DearPOSCustomer\Database\Factories;

use DearPOS\DearPOSCustomer\Models\CustomerGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerGroupFactory extends Factory
{
    protected $model = CustomerGroup::class;

    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'discount_percentage' => $this->faker->randomFloat(2, 0, 100),
            'is_active' => true,
        ];
    }
}
