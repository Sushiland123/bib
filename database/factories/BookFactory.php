<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tittle' => fake()->sentence(3), // Genera una oración de 3 palabras
            'publisher' => fake()->company(), // Genera un nombre de compañía aleatorio
            'ISBN' => fake()->isbn13(), // Genera un ISBN-13 aleatorio
            'lenguage' => fake()->randomElement(['Español', 'Inglés', 'Francés', 'Alemán']), // Selecciona un idioma aleatorio de la lista
            'version' => fake()->randomElement(['1ra', '2da', '3ra', 'Edición Especial']), // Selecciona una edición aleatoria
            'author' => fake()->name(), // Genera un nombre de autor aleatorio
            'description' => fake()->paragraph(), // Genera un párrafo aleatorio
            'publication_date' => fake()->numberBetween(1900, 2023), // Genera un año aleatorio entre 1900 y 2023
            'categories' => fake()->randomElement(['Ficción', 'No Ficción', 'Ciencia Ficción', 'Fantasía', 'Romance', 'Thriller']), // Selecciona una categoría aleatoria
        ];
    }
}