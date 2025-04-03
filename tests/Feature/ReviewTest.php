<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_write_reviews_for_books()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/v1/books/' . $book->id . '/reviews', [
            'rating' => 5,
            'comment' => 'Great book!',
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['comment' => 'Great book!']);
    }

    public function test_user_can_view_their_review_for_a_specific_book()
    {
        // Crear un usuario y un libro
        $user = User::factory()->create();
        $book = Book::factory()->create();
    
        // Crear una reseña para ese libro y ese usuario
        $review = \App\Models\Review::factory()->create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'rating' => 5,
            'comment' => 'Excelente libro',
        ]);
    
        // Usuario autenticado hace GET a la ruta para ver las reseñas del libro
        $response = $this->actingAs($user, 'sanctum')
            ->getJson("/api/v1/books/{$book->id}/reviews");
    
        // Verifica que devuelve 200 y contiene la reseña
        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'user_id' => $user->id,
                     'book_id' => $book->id,
                     'rating' => 5,
                     'comment' => 'Excelente libro',
                 ]);
    }
    
}