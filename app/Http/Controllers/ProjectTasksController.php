<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        if (auth()->user()->isNot($project->user)) {
            abort(403, 'You are not the project owner!');
        }

        request()->validate(['body' => 'required']);
        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        if (auth()->user()->isNot($task->project->user)) {
            abort(403, 'You are not the project owner!');
        }

        request()->validate(['body' => 'required']);

        $task->update([
            'body' => request('body'),
            'completed' => request()->has('completed')
        ]);

        return redirect($project->path());
    }
}
