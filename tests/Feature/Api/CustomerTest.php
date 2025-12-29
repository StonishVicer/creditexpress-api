<?php

namespace Tests\Feature\Api;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_list_all_customers()
    {
        // Preparar
        Customer::factory()->count(3)->create();

        // Actuar
        $response = $this->getJson('/api/customers');

        // Asertar
        $response->assertStatus(200)
            ->assertJsonCount(3, 'data') 
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'number_id', 'phone', 'address', 'payment_classification', 'status']
                ],
                'message',
                'error',
                'status'
            ])
            ->assertJsonPath('message', 'Clientes recuperados exitosamente.')
            ->assertJsonPath('error', false);
    }

    #[Test]
    public function it_can_create_a_new_customer()
    {
        $data = [
            'name' => 'Juan Perez',
            'number_id' => '123456789',
            'phone' => '12345678901',
            'address' => 'Calle Falsa 123',
            'payment_classification' => 'GOOD',
            'status' => 'ACTIVE'
        ];

        $response = $this->postJson('/api/customers', $data);

        // El mensaje ahora vive en la raíz, no en 'additional'
        $response->assertStatus(201)
            ->assertJsonStructure(['data', 'message', 'error', 'status'])
            ->assertJsonPath('message', 'Cliente creado exitosamente.')
            ->assertJsonPath('data.name', 'Juan Perez')
            ->assertJsonPath('error', false);
    }

    #[Test]
    public function it_can_show_a_specific_customer()
    {
        $customer = Customer::factory()->create();
        
        $response = $this->getJson("/api/customers/{$customer->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'message', 'error', 'status'])
            ->assertJsonPath('data.id', $customer->id)
            ->assertJsonPath('message', 'Cliente recuperado exitosamente.');
    }

    #[Test]
    public function it_returns_404_when_customer_not_found()
    {
        $response = $this->getJson('/api/customers/9999');

        $response->assertStatus(404)
            ->assertJson([
                'error' => true,
                'message' => 'No se encontró el cliente.',
                'status' => 404
            ]);
    }

    #[Test]
    public function it_validates_required_fields_on_creation()
    {
        $response = $this->postJson('/api/customers', []);

        // Laravel maneja los errores de validación automáticamente con 422
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'number_id']);
    }

    #[Test]
    public function it_requires_all_fields_for_update_via_put()
    {
        $customer = Customer::factory()->create();
        
        // PUT espera el reemplazo completo del recurso
        $response = $this->putJson("/api/customers/{$customer->id}", ['name' => 'Solo nombre']);

        $response->assertStatus(422);
    }

    #[Test]
    public function it_can_update_a_customer_completely()
    {
        $customer = Customer::factory()->create();
        $newData = [
            'name' => 'Editado',
            'number_id' => '987654321',
            'phone' => '09876543210',
            'address' => 'Direccion 456',
            'payment_classification' => 'REGULAR',
            'status' => 'ACTIVE'
        ];

        $response = $this->putJson("/api/customers/{$customer->id}", $newData);

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'message', 'error', 'status'])
            ->assertJsonPath('message', 'Cliente editado exitosamente.')
            ->assertJsonPath('data.name', 'Editado')
            ->assertJsonPath('error', false);
    }

    #[Test]
    public function it_can_delete_a_customer()
    {
        $customer = Customer::factory()->create();
        
        $response = $this->deleteJson("/api/customers/{$customer->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Cliente eliminado exitosamente.',
                'error' => false,
                'status' => 200
            ]);
        
        // Verificar que realmente no existe en la base de datos
        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}