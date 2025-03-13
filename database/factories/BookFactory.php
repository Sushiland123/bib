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
            'titulo' => fake()->sentence(3), // Genera una oración de 3 palabras
            'editorial' => fake()->company(), // Genera un nombre de compañía aleatorio
            'ISBN' => fake()->isbn13(), // Genera un ISBN-13 aleatorio
            'idioma' => fake()->randomElement(['Español', 'Inglés', 'Francés', 'Alemán']), // Selecciona un idioma aleatorio de la lista
            'edicion' => fake()->randomElement(['1ra', '2da', '3ra', 'Edición Especial']), // Selecciona una edición aleatoria
            'autor' => fake()->name(), // Genera un nombre de autor aleatorio
            'descripcion' => fake()->paragraph(), // Genera un párrafo aleatorio
            'año_publicacion' => fake()->numberBetween(1900, 2023), // Genera un año aleatorio entre 1900 y 2023
            'categoria' => fake()->randomElement(['Ficción', 'No Ficción', 'Ciencia Ficción', 'Fantasía', 'Romance', 'Thriller']), // Selecciona una categoría aleatoria
        ];
    }
}