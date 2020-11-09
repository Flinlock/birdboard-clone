<?php

namespace App\Http\Controllers;

use App\Models\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        if (auth()->user()->isNot($project->user)) {
            abort(403);
        }
        return view('projects.show', compact('project'));
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'string'
        ]);

        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    public function create()
    {
        return view('projects.create');
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);
        // if (auth()->user()->isNot($project->user)) {
        //     abort(403, 'You are not the project owner!');
        // }

        $project->update(request(['notes']));

        return redirect($project->path());
    }
}
