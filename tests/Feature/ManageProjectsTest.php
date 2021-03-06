<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $atts = [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(5),
            'notes' => 'General notes here'
        ];
        $response = $this->post('/projects', $atts);
        $project = Project::where($atts)->first();

        $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $atts);

        $this->get($project->path())
            ->assertSee($atts['title'])
            ->assertSee($atts['description'])
            ->assertSee($atts['notes']);
    }

    /** @test */
    public function a_user_can_update_a_projects_notes()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();
        $project = auth()->user()->projects()->create(Project::factory()->raw());

        $this->patch($project->path(), ['notes' => 'some cool notes'])
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', ['notes' => 'some cool notes']);
    }

    /** @test */
    public function a_user_can_view_their_projects()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = Project::factory()->create(['user_id' => auth()->id()]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee(\Str::limit($project->description, 100));
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();

        $project = Project::factory()->create();

        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        // $this->withoutExceptionHandling();
        $this->signIn();

        $project = Project::factory()->create();

        $this->patch($project->path(), ['notes' => 'some new note'])->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();
        $attributes = Project::factory()->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();
        $attributes = Project::factory()->raw(['description' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

    /** @test */
    public function guests_cannot_manage_projects()
    {
        //$this->withoutExceptionHandling();
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');

        $project = Project::factory()->create();
        $this->post('/projects', $project->toArray())->assertRedirect('login');

        $this->get($project->path())->assertRedirect('login');
    }
}
