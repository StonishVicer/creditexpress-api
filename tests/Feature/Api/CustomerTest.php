<?php

namespace Tests\Feature\Api;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_customers()
    {
        Customer::factory()->count(3)->create();

        $response = $this->getJson('/api/customers');

        // Nota: Asegúrate de que CustomerResource devuelva una colección envuelta en 'data'
        $response->assertStatus(200)
                 ->assertJsonCount(3);
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

        // Enviamos solo el nombre mediante PUT. 
        // Como quitamos 'sometimes' del Request, esto DEBE fallar.
        $response = $this->putJson("/api/customers/{$customer->id}", [
            'name' => 'Nombre Nuevo'
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['number_id', 'phone', 'address', 'payment_classification', 'status']);
    }

    public function test_can_update_customer_with_all_fields()
    {
        $customer = Customer::factory()->create(['name' => 'Nombre Original']);

        $response = $this->putJson("/api/customers/{$customer->id}", [
            'name' => 'Nombre Editado',
            'number_id' => $customer->number_id,
            'phone' => '12345678901',
            'address' => 'Nueva Direccion',
            'payment_classification' => 'REGULAR',
            'status' => 'ACTIVE'
        ]);

        $response->assertStatus(200)
                 ->assertJsonPath('additional.message', 'Cliente editado exitosamente.');

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Nombre Editado'
        ]);
    }
}