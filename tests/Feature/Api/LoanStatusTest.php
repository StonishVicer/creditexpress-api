<?php

namespace Tests\Feature\Api;

use App\Models\LoanStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoanStatusTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_loan_statuses()
    {
        LoanStatus::factory()->count(3)->create();

        $response = $this->getJson('/api/loan_status');

        // CORRECCIÓN: Ahora el conteo se hace sobre la llave 'data'
        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name_status']
                ],
                'message',
                'error',
                'status'
            ]);
    }

    #[Test]
    public function it_can_create_a_new_loan_status()
    {
        $data = ['name_status' => 'APROBADO'];

        $response = $this->postJson('/api/loan_status', $data);

        $response->assertStatus(201)
            ->assertJsonPath('message', 'Estado creado exitosamente.')
            ->assertJsonPath('data.name_status', 'APROBADO')
            ->assertJsonPath('error', false);
    }

    #[Test]
    public function it_validates_required_name_status()
    {
        $response = $this->postJson('/api/loan_status', []);
        $response->assertStatus(422)->assertJsonValidationErrors(['name_status']);
    }

    #[Test]
    public function it_validates_unique_name_status()
    {
        LoanStatus::factory()->create(['name_status' => 'EXISTENTE']);
        $response = $this->postJson('/api/loan_status', ['name_status' => 'EXISTENTE']);
        $response->assertStatus(422)->assertJsonValidationErrors(['name_status']);
    }

    #[Test]
    public function it_can_show_a_specific_loan_status()
    {
        $status = LoanStatus::factory()->create();
        $response = $this->getJson("/api/loan_status/{$status->id}");

        // CORRECCIÓN: El ID ahora vive dentro de 'data'
        $response->assertStatus(200)
            ->assertJsonPath('data.id', $status->id)
            ->assertJsonPath('message', 'Estado recuperado exitosamente.');
    }

    #[Test]
    public function it_returns_404_when_status_not_found()
    {
        $response = $this->getJson('/api/loan_status/999');
        $response->assertStatus(404)
            ->assertJson([
                'error' => true,
                'message' => 'Estado no encontrado.'
            ]);
    }

    #[Test]
    public function it_can_update_loan_status()
    {
        $status = LoanStatus::factory()->create(['name_status' => 'PENDIENTE']);
        $response = $this->putJson("/api/loan_status/{$status->id}", ['name_status' => 'ACTUALIZADO']);

        $response->assertStatus(200)
            ->assertJsonPath('message', 'Estado actualizado exitosamente.')
            ->assertJsonPath('data.name_status', 'ACTUALIZADO');
    }

    #[Test]
    public function it_can_delete_loan_status()
    {
        $status = LoanStatus::factory()->create();
        $response = $this->deleteJson("/api/loan_status/{$status->id}");

        // Sincronizado con el mensaje del controlador
        $response->assertStatus(200)
            ->assertJsonPath('message', 'Estado eliminado exitosamente.');
        
        $this->assertDatabaseMissing('loan_statuses', ['id' => $status->id]);
    }
}