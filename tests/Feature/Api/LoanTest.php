<?php

namespace Tests\Feature\Api;

use App\Models\Loan;
use App\Models\Customer;
use App\Models\LoanStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoanTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_loans()
    {
        Loan::factory()->count(2)->create();
        $response = $this->getJson('/api/loans');

        // CORRECCIÓN: Ahora contamos dentro de 'data' y validamos estructura base
        $response->assertStatus(200)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'customer_id', 'loan_status_id', 'principal_amount']
                ],
                'message',
                'error',
                'status'
            ])
            ->assertJsonPath('message', 'Préstamos recuperados exitosamente.');
    }

    #[Test]
    public function it_can_create_a_new_loan_with_relations()
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

        // Validamos que el recurso creado esté en 'data' y el mensaje en la raíz
        $response->assertStatus(201)
            ->assertJsonPath('message', 'Préstamo creado exitosamente.')
            ->assertJsonPath('data.principal_amount', 1000.50)
            ->assertJsonPath('error', false);
    }

    #[Test]
    public function it_validates_required_fields_on_loan_creation()
    {
        $response = $this->postJson('/api/loans', []);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['customer_id', 'loan_status_id', 'principal_amount']);
    }

    #[Test]
    public function it_cannot_create_loan_with_interest_rate_above_maximum()
    {
        // Asumiendo que tu regla de validación falla con 15%
        $response = $this->postJson('/api/loans', ['interest_rate' => 15]);
        
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['interest_rate']);
    }

    #[Test]
    public function it_can_show_a_specific_loan_details()
    {
        $loan = Loan::factory()->create();
        $response = $this->getJson("/api/loans/{$loan->id}");

        // CORRECCIÓN: El ID ahora vive dentro de 'data'
        $response->assertStatus(200)
            ->assertJsonPath('data.id', $loan->id)
            ->assertJsonPath('message', 'Préstamo recuperado exitosamente.');
    }

    #[Test]
    public function it_returns_404_when_loan_not_found()
    {
        $response = $this->getJson('/api/loans/9999');
        
        $response->assertStatus(404)
            ->assertJson([
                'error' => true,
                'message' => 'Préstamo no encontrado.'
            ]);
    }

    #[Test]
    public function it_can_update_loan_terms()
    {
        $loan = Loan::factory()->create();
        $newStatus = LoanStatus::factory()->create();

        $updateData = [
            'customer_id' => $loan->customer_id,
            'loan_status_id' => $newStatus->id,
            'principal_amount' => 1200.00,
            'interest_rate' => 10,
            'payment_term' => 6,
            'number_installments' => 6,
            'interest_to_collect' => 120.00
        ];

        $response = $this->putJson("/api/loans/{$loan->id}", $updateData);

        $response->assertStatus(200)
            ->assertJsonPath('message', 'Préstamo editado exitosamente.')
            // Usamos fragment para evitar conflictos de tipos (float vs int)
            ->assertJsonFragment(['principal_amount' => 1200]); 
    }

    #[Test]
    public function it_can_delete_a_loan()
    {
        $loan = Loan::factory()->create();
        $response = $this->deleteJson("/api/loans/{$loan->id}");

        $response->assertStatus(200)
            ->assertJsonPath('message', 'Préstamo eliminado exitosamente.')
            ->assertJsonPath('error', false);
            
        $this->assertDatabaseMissing('loans', ['id' => $loan->id]);
    }
}