<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project()
    {
        // $this->withoutExceptionHandling();
        $task = Task::factory()->create();

        $this->assertInstanceOf('App\Models\Project', $task->project);
    }

    /** @test */
    public function it_has_a_path()
    {
        $task = Task::factory()->create();

        $this->assertEquals($task->path(), $task->project->path() . '/tasks/' . $task->id);
    }
}
