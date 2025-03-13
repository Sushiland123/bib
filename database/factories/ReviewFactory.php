<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_usuario' => \App\Models\User::factory(), // Crea un usuario relacionado
            'id_libro' => \App\Models\Book::factory(), // Crea un libro relacionado
            'rating' => fake()->numberBetween(1, 5), // Genera una calificación aleatoria entre 1 y 5
            'comentario' => fake()->paragraph(), // Genera un comentario aleatorio
            'fecha_publicacion' => fake()->dateTimeThisYear(), // Genera una fecha y hora aleatoria de este año
        ];
    }
}
