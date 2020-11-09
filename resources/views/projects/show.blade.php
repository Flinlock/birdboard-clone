@extends('layouts.app')
@section('content')
    <header class="flex items-end mb-3 py-4">
        <div class="flex justify-between items-center w-full">
            <p class="text-gray-600 text-sm font-normal">
                <a href="/projects">My Projects</a> / {{ $project->title }}
            </p>
            <a class="button" href="/projects/create">Create Project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -mx-3">
            <div class="lg:w-3/4 px-3">
                <div class="mb-8">
                    <h2 class="text-lg text-gray-600 font-normal mb-3">Tasks</h2>
                    {{-- tasks --}}
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{ $task->path() }}" method="POST">
                                @method('PATCH')
                                @csrf
                                <div class="flex">
                                    <input name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-gray-500 line-through' : '' }}">
                                    <input name="completed" type="checkbox" onchange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                            @csrf
                            <input name="body" type="text" placeholder="Add a task..." class="w-full">
                        </form>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg text-gray-600 font-normal mb-3">General Notes</h2>
                    {{-- general notes --}}
                    <form method="POST" action="{{ $project->path() }}">
                        @method('PATCH')
                        @csrf
                        <textarea name="notes" class="card w-full mb-4" style="min-height: 200px">{{ $project->notes }}</textarea>
                        <button class="button" type="submit">Save</button>
                    </form>
                </div>
            </div>
            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>
        </div>
    </main>

    
@endsection
