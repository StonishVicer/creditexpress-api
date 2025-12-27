<?php

namespace Tests\Feature\Api;

use App\Models\LoanStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_list_all_loan_statuses()
    {
        LoanStatus::factory()->count(3)->create();

        $response = $this->getJson('/api/loan_status');

        $response->assertStatus(200);
        
        // Si el controlador devuelve LoanStatusResource::collection(), 
        // Laravel envuelve los datos en una llave 'data'.
        $response->assertJsonCount(3);
    }

    public function test_it_can_create_a_new_loan_status()
    {
        $data = ['name_status' => 'APROBADO'];

        $response = $this->postJson('/api/loan_status', $data);

        $response->assertStatus(201)
                 ->assertJsonPath('additional.message', 'Estado creado exitosamente.')
                 ->assertJsonPath('data.name_status', 'APROBADO');

        $this->assertDatabaseHas('loan_statuses', ['name_status' => 'APROBADO']);
    }

    public function test_it_returns_404_when_status_not_found()
    {
        $response = $this->getJson('/api/loan_status/999');

        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Estado no encontrado.',
                     'error' => true
                 ]);
    }

    public function test_it_validates_required_name_status()
    {
        $response = $this->postJson('/api/loan_status', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name_status']);
    }

    public function test_it_can_update_loan_status()
    {
        $status = LoanStatus::factory()->create(['name_status' => 'PENDIENTE']);

        $response = $this->putJson("/api/loan_status/{$status->id}", [
            'name_status' => 'ACTUALIZADO'
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('additional.message', 'Estado actualizado exitosamente.');
        
        $this->assertDatabaseHas('loan_statuses', [
            'id' => $status->id,
            'name_status' => 'ACTUALIZADO'
        ]);
    }
}