<?php

namespace Tests\Feature\Api;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase; // Limpia la base de datos en cada test

    public function test_can_get_all_customers()
    {
        Customer::factory()->count(3)->create();

        $response = $this->getJson('/api/customers');

        $response->assertStatus(200)
                 ->assertJsonCount(3, 'data');
    }

    public function test_can_create_customer()
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

        $response->assertStatus(201)
                 ->assertJsonPath('additional.message', 'Cliente creado exitosamente.');
        
        $this->assertDatabaseHas('customers', ['number_id' => '123456789']);
    }

    public function test_put_requires_all_fields_for_update()
    {
        $customer = Customer::factory()->create();

        // Enviamos solo el nombre mediante PUT
        $response = $this->putJson("/api/customers/{$customer->id}", [
            'name' => 'Nombre Nuevo'
        ]);

        // Debe fallar con 422 porque falta el resto de campos obligatorios para PUT
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['number_id', 'phone', 'address']);
    }

    public function test_patch_allows_partial_update()
    {
        $customer = Customer::factory()->create(['name' => 'Nombre Original']);

        $response = $this->patchJson("/api/customers/{$customer->id}", [
            'name' => 'Nombre Editado'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Nombre Editado'
        ]);
    }
}