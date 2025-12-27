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
        // Creamos 3 estados usando el factory
        LoanStatus::factory()->count(3)->create();

        $response = $this->getJson('/api/loan_status');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data')
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'nombre_estado']
                     ]
                 ]);
    }

    // Se agregó el prefijo test_
    public function test_it_can_create_a_new_loan_status()
    {
        $data = [
            'name_status' => 'APROBADO'
        ];

        $response = $this->postJson('/api/loan_status', $data);

        $response->assertStatus(201)
                 ->assertJsonPath('additional.message', 'Estado de prestamo creado exitosamente.')
                 ->assertJsonPath('data.nombre_estado', 'APROBADO');

        $this->assertDatabaseHas('loan_statuses', ['name_status' => 'APROBADO']);
    }

    // Se agregó el prefijo test_
    public function test_it_returns_404_when_status_not_found()
    {
        $response = $this->getJson('/api/loan_status/999');

        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Estado de prestamo no encontrado.',
                     'error' => true
                 ]);
    }

    // Se agregó el prefijo test_
    public function test_it_validates_required_name_status()
    {
        $response = $this->postJson('/api/loan_status', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name_status']);
    }
}