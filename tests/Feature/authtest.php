<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use PHPUnit\Framework\Attributes\Test;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function a_user_can_register()
    {
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'username' => 'testuser',
            'age' => 25,
            'country' => 'Test Country',
            'password' => 'password',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    #[Test]
    public function a_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('token', $response->json());
    }

    #[Test]
    public function test_user_can_logout_successfully()
    {
        // Crear un usuario
        $user = User::factory()->create();
    
        // Autenticar al usuario generando un token
        $token = $user->createToken('TestToken')->plainTextToken;
    
        // Hacer la petición de logout con el token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/v1/auth/logout');
    
        // Verificar que responde con éxito y mensaje esperado
        $response->assertStatus(200)
                 ->assertJson(['message' => 'You are logged out']);
    
        // Verificar que el token fue eliminado
        $this->assertDatabaseMissing('personal_access_tokens', [
            'tokenable_id' => $user->id,
            'name' => 'TestToken',
        ]);
    }
    


    #[Test]
    public function an_admin_can_grant_and_revoke_permissions()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($admin, 'sanctum')->postJson("/api/v1/auth/admin/{$user->id}")
            ->assertStatus(200);

        $this->assertEquals('admin', $user->fresh()->role);

        $this->actingAs($admin, 'sanctum')->deleteJson("/api/v1/auth/admin/{$user->id}")
            ->assertStatus(200);

        $this->assertEquals('user', $user->fresh()->role);
    }

    #[Test]
    public function an_admin_can_get_all_users()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        User::factory()->count(5)->create();

        $response = $this->actingAs($admin, 'sanctum')->getJson('/api/v1/auth/users');

        $response->assertStatus(200);
        $response->assertJsonCount(6); // Incluyendo al admin creado
    }

    #[Test]
    public function an_admin_can_get_user_by_id()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')->getJson("/api/v1/auth/users/{$user->id}");

        $response->assertStatus(200);
        $response->assertJson(['id' => $user->id, 'email' => $user->email]);
    }

    #[Test]
    public function a_user_can_view_their_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->getJson('/api/v1/profile/user');

        $response->assertStatus(200);
        $response->assertJson(['id' => $user->id, 'email' => $user->email]);
    }

    #[Test]
    public function a_user_can_update_their_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->putJson('/api/v1/profile/user', [
            'name' => 'Updated Name',
            'username' => 'updateduser',
            'age' => 30,
            'country' => 'Updated Country',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'username' => 'updateduser',
            'age' => 30,
            'country' => 'Updated Country',
        ]);
    }
}