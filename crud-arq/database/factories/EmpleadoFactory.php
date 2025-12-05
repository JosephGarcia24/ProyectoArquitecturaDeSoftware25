<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empleado>
 */
class EmpleadoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'departamento' => $this->faker->randomElement(['Ventas', 'Marketing', 'Desarrollo', 'Recursos Humanos']),
            'salario' => $this->faker->randomFloat(2, 30000, 100000),
        ];
    }
}
