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
            'review_text' => 'Great book!',
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment(['review_text' => 'Great book!']);
    }

    public function test_user_can_view_reviews_for_books()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $review = Review::factory()->create(['book_id' => $book->id, 'user_id' => $user->id]);

        $response = $this->getJson('/api/v1/books/' . $book->id . '/reviews');

        $response->assertStatus(200)
                 ->assertJsonFragment(['review_text' => $review->review_text]);
    }
}