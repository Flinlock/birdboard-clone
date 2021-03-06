<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Project;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_path()
    {
        $project = Project::factory()->create();
        $this->assertEquals('/projects/' . $project->id, $project->path());
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        // $this->withoutExceptionHandling();
        $project = Project::factory()->create();
        $this->assertInstanceOf('App\Models\User', $project->user);
    }

    /** @test */
    public function it_can_add_a_task()
    {
        // $this->withoutExceptionHandling();
        $project = Project::factory()->create();

        $task = $project->addTask('Test task');

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }
}
