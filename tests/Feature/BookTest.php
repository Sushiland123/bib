<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Book;
use PHPUnit\Framework\Attributes\Test;

class BookTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_get_all_books()
    {
        $user = User::factory()->create();
        Book::factory()->count(5)->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/books');

        $response->assertStatus(200);
        $response->assertJsonCount(5);
    }

    #[Test]
    public function an_admin_can_create_a_book()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $bookData = [
            'tittle' => 'New Book',
            'publisher' => 'New Publisher',
            'ISBN' => '1234567890123',
            'lenguage' => 'es',
            'version' => 'segunda',
            'author' => 'New Author',
            'description' => 'New Description',
            'publication_date' => '2023',
            'categories' => 'Fiction, Adventure',
        ];

        $response = $this->actingAs($admin, 'sanctum')->postJson('/api/v1/books', $bookData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('books', ['tittle' => 'New Book']);
    }

    #[Test]
    public function an_admin_can_update_a_book()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $book = Book::factory()->create();

        $updatedData = [
            'tittle' => 'New Book',
            'publisher' => 'New Publisher',
            'ISBN' => '1234567890123',
            'lenguage' => 'es',
            'version' => 'segunda',
            'author' => 'New Author',
            'description' => 'New Description',
            'publication_date' => '2023',
            'categories' => 'Fiction, Adventure',
        ];

        $response = $this->actingAs($admin, 'sanctum')->putJson("/api/v1/books/{$book->id}", $updatedData);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', ['id' => $book->id, 'tittle' => 'New Book']);
    }

    #[Test]
    public function an_admin_can_delete_a_book()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $book = Book::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')->deleteJson("/api/v1/books/{$book->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}