<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonalLibraryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_book_to_personal_library()
    {
        // Crear un usuario y un libro
        $user = User::factory()->create();
        $book = Book::factory()->create();
    
        // Hacer petición autenticada usando Sanctum
        $response = $this->actingAs($user, 'sanctum')
            ->postJson("/api/v1/library/{$book->id}");
    
        // Verificar que la respuesta es 200 y contiene el mensaje esperado
        $response->assertStatus(200)
                 ->assertJson(['message' => 'book successfuly added']);
    
        // Verificar que el libro realmente está en la relación del usuario
        $this->assertDatabaseHas('personal_libraries', [
            'user_id' => $user->id,
            'book_id' => $book->id,
        ]);
    }
    

    public function test_user_can_view_books_in_personal_library()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $user->books()->attach($book->id);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/library');

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $book->id]);
    }

    public function test_user_can_view_book_in_personal_library_by_id()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $user->books()->attach($book->id);

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/library/' . $book->id);

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $book->id]);
    }

    public function test_user_can_remove_books_from_personal_library()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $user->books()->attach($book->id);

        $response = $this->actingAs($user, 'sanctum')->deleteJson('/api/v1/library/' . $book->id);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Libro eliminado de tu biblioteca']);
    }
}