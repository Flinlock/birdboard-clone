@extends('layouts.app')
@section('content')
    <div >
        <h1 class="mr-auto mb-4">Project management for scrubs!</h1>
        <a href="/projects/create">Create Project</a>
    </div>

    <div class="flex">
        @forelse ($projects as $project)
            <div class="bg-white mr-4 p-5 rounded shadow w-1/3" style="height: 200px">
                
                <h3>{{ $project->title }}</h3>

                <div>{{ \Str::limit($project->description, 300) }}</div>
                
            </div>
        @empty
            <div>No projects yet</div>
        @endforelse
        
    </div>

@endsection