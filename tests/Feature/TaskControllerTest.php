<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_tasks_user()
    {
        $user = User::factory()->create();
        Task::factory()->count(5)->create(['user_id' => $user->id]);

        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson('/api/tasks');

        $response->assertStatus(200);
    }

    public function test_store_task()
    {
        $user  = User::factory()->create();
        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->postJson('/api/tasks', [
                'title'       => 'Test Task',
                'description' => 'Task description',
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'title', 'description', 'user_id']);
    }

    public function test_show_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->getJson("/api/tasks/$task->id");

        $response->assertStatus(200);
    }

    public function test_update_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->putJson("/api/tasks/{$task->id}", [
                'title'       => 'Updated Task',
                'description' => 'Updated description',
                'status'      => 'completed',
            ]);

        $response->assertStatus(200)
            ->assertJson(['title' => 'Updated Task', 'description' => 'Updated description']);
    }

    public function test_destroy_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $token = auth('api')->login($user);

        $response = $this->withHeader('Authorization', "Bearer $token")
            ->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
