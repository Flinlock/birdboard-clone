<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = Project::factory()->create(['user_id' => auth()->id()]);
        $task = $project->addTask('I am a task');

        $this->patch($task->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $attributes = Task::factory()->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();

        $project = Project::factory()->create();

        $attributes = Task::factory()->raw();

        $this->post($project->path() . '/tasks', $attributes)
            ->assertStatus(403);
        $this->assertDatabaseMissing('tasks', $attributes);
    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_a_task()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();

        $project = Project::factory()->create();

        $task = $project->addTask('I am a task');

        $this->patch($task->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }
}
