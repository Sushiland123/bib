<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonalLibraryTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_books_to_personal_library()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/library', ['id' => $book->id]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Libro agregado correctamente']);
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