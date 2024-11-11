<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Capacitacion>
 */
class CapacitacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre'=>$this->faker->title(10),
            'empresa'=>$this->faker->company(),
            'descripcion'=>$this->faker->text(100),
            'duracion'=>$this->faker->text(30),
            'imagen'=>'/img/example.png'
            
        ];
    }
}