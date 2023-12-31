<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cliente;

class ClienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nome' => $this->faker->name,
            'email' => $this->faker->email,
            'telefone' => $this->faker->phoneNumber,
            'sexo' => $this->faker->randomElement(['Masculino', 'Feminino']),
            'foto' => $this->faker->imageUrl(),
        ];
    }
}
