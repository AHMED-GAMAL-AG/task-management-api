<?php

namespace Tests\Feature;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    // Test for creating a new task
    public function test_can_create_task()
    {
        $data = [
            'title' => 'Test Task',
            'description' => 'This is a test task',
            'status' => 'pending',
            'due_date' => now()->addDays(5)->format('Y-m-d'), // Due date 5 days from now
        ];

        $response = $this->postJson('/api/tasks', $data);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJson(['title' => $data['title']]);
    }

    // Test for updating an existing task
    public function test_can_update_task()
    {
        $task = Task::factory()->create();

        $data = [
            'title' => 'Updated Task',
            'description' => 'This is an updated task',
            'status' => 'in progress',
            'due_date' => now()->addDays(10)->format('Y-m-d'), // Due date 10 days from now
        ];

        $response = $this->putJson("/api/tasks/{$task->id}", $data);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['title' => $data['title']]);
    }

    // Test for deleting a task
    public function test_can_delete_task()
    {
        $task = Task::factory()->create();

        $response = $this->deleteJson("/api/tasks/{$task->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['message' => 'Task deleted successfully']);
    }

    // Test for retrieving a single task by ID
    public function test_can_retrieve_single_task()
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/tasks/{$task->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJson(['title' => $task->title]);
    }

    // Test for retrieving a list of all tasks
    public function test_can_retrieve_all_tasks()
    {
        Task::factory()->count(5)->create();

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(5);
    }

    // Test for retrieving tasks by status
    public function test_can_retrieve_tasks_by_status()
    {
        Task::factory()->create(['status' => 'in progress']);
        Task::factory()->create(['status' => 'completed']);
        Task::factory()->create(['status' => 'pending']);

        $response = $this->getJson('/api/tasks/status/in progress');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(1);
    }
}
