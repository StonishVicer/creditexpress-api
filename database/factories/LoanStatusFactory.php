<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LoanStatusFactory extends Factory
{
    public function definition(): array
    {
        return [
            // Genera estados realistas para tus pruebas
            'name_status' => $this->faker->randomElement(['PENDIENTE', 'APROBADO', 'RECHAZADO', 'PAGADO']),
        ];
    }
}