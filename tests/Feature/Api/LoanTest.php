<?php

namespace Tests\Feature\Api;

use App\Models\Loan;
use App\Models\Customer;
use App\Models\LoanStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_loan_with_relations()
    {
        $customer = Customer::factory()->create();
        $status = LoanStatus::factory()->create();

        $data = [
            'customer_id' => $customer->id,
            'loan_status_id' => $status->id,
            'principal_amount' => 1000.50,
            'interest_rate' => 11,
            'payment_term' => 5,
            'number_installments' => 5,
            'interest_to_collect' => 110.05
        ];

        $response = $this->postJson('/api/loans', $data);

        $response->assertStatus(201)
                 ->assertJsonPath('data.capital_prestado', 1000.50);
    }

    public function test_cannot_create_loan_with_invalid_interest_rate()
    {
        $response = $this->postJson('/api/loans', [
            'interest_rate' => 15 // El máximo es 12 según tus reglas
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['interest_rate']);
    }
}