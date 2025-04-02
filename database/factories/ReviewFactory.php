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
            'user_id' => \App\Models\User::factory(), // Crea un usuario relacionado
            'book_id' => \App\Models\Book::factory(), // Crea un libro relacionado
            'rating' => fake()->numberBetween(1, 5), // Genera una calificación aleatoria entre 1 y 5
            'comment' => fake()->paragraph(), // Genera un comentario aleatorio
            'publication_date' => fake()->dateTimeThisYear(), // Genera una fecha y hora aleatoria de este año
        ];
    }
}
