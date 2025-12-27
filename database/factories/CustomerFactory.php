<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'number_id' => $this->faker->unique()->numerify('#########'), // 9 dígitos
            'phone' => $this->faker->numerify('###########'), // 11 dígitos
            'address' => $this->faker->address(),
            'payment_classification' => $this->faker->randomElement(['GOOD', 'REGULAR', 'BAD']),
            'status' => 'ACTIVE',
        ];
    }
}
