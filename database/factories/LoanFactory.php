<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\LoanStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoanFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Esto creará automáticamente un cliente y un estado si no se los pasas al test
            'customer_id' => Customer::factory(), 
            'loan_status_id' => LoanStatus::factory(),
            'principal_amount' => $this->faker->randomFloat(2, 500, 10000),
            'interest_rate' => $this->faker->numberBetween(10, 12),
            'payment_term' => $this->faker->numberBetween(3, 6),
            'number_installments' => $this->faker->numberBetween(3, 6),
            'interest_to_collect' => $this->faker->randomFloat(2, 50, 1200),
        ];
    }
}