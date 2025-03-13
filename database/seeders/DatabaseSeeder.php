<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Book;
use App\Models\Review;
use App\Models\PersonalLibrary;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();
        Book::factory(50)->create();
        Review::factory(100)->create();

        // Ejemplo para la tabla pivote (si la usas):
        PersonalLibrary::factory(150)->create();
    }
}