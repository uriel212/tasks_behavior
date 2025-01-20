<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_registration()
    {
        $response = $this->postJson('/api/register', [
            'name'     => 'Demo User',
            'email'    => 'user@demo.com',
            'password' => 'demo123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'user' => ['id', 'name', 'email', 'created_at', 'updated_at'],
            ]);

        $this->assertDatabaseHas('users', [
            'email' => 'user@demo.com',
        ]);
    }

    public function test_login()
    {
        // $user = User::factory()->create([
        //     'email'    => 'user@demo.com',
        //     'password' => Hash::make('demo123'),
        // ]);

        $response = $this->postJson('/api/login', [
            'email'    => 'user@demo.com',
            'password' => 'demo123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user',
                'authorization' => ['token', 'type'],
            ]);
    }

    public function test_portrait()
    {
        $user = User::factory()->create();

        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/me');

        $response->assertStatus(200)
            ->assertJson(['id' => $user->id]);
    }
}
