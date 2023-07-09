@extends ('layouts.app')

@section('content')
<header class="flex items-center mb-3 py-4">
        <div class="flex w-full items-end justify-between">
                <p class="text-default text-sm font-normal">
                        <a href="/projects" class="text-default text-sm font-normal no-underline">
                                My Projects
                        </a> / {{ $project->title }}
                </p>
                <div class="flex items-center">
                        @foreach ($project->members as $member)
                        <img src="{{ avatar_url($member->name) }}" alt="{{ $member->name }}'s avatar" class="rounded-full w-8 mr-2">
                        @endforeach
                        <img src="{{ avatar_url($project->owner->name) }}" alt="{{ $project->owner->name }}'s avatar" class="rounded-full w-8 mr-2">
                        <a href="{{ $project->path(). '/edit' }}" class="button ml-4">Edit Project</a>
                </div>
        </div>

</header>
<main>
        <div class="lg:flex -mx-3">
                <div class="lg:w-3/4 px-3 mb-6">
                        <div class="mb-8">
                                <h2 class="text-lg text-default font-normal mb-3">Tasks</h2>

                                <!-- tasks -->
                                @foreach ($project->tasks as $task)
                                <div class="card mb-3">
                                        <form method="POST" action="{{ $task->path() }}">
                                                @method('PATCH')
                                                @csrf
                                                <div class="flex">
                                                        <input name="body" value="{{ $task->body }}" class="bg-card text-default w-full {{ $task->completed ? 'text-default' : '' }}">
                                                        <input name="completed" type="checkbox" onchange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}>
                                                </div>
                                        </form>
                                </div>
                                @endforeach
                                <div class="card mb-3">
                                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                                                @csrf
                                                <input placeholder="Add a new Task" class="bg-card text-default w-full" name="body">
                                        </form>
                                </div>

                        </div>
                        <div>
                                <h2 class="text-lg text-default font-normal mb-3">General Notes</h2>
                                <form action="{{ $project->path() }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <textarea name="notes" class="card w-full mb-4" placeholder="Anything special that you want to make a note of" style="min-height: 200px;">
                                        {{ $project->notes }}
                                        </textarea>
                                        <button type="submit" class="button">Save</button>
                                </form>
                        </div>

                        @include('errors')
                </div>
                <div class="lg:w-1/4 px-3">
                        @include('projects.card', ['charLimit' => PHP_INT_MAX])

                        @include('projects.activity.card')
                        
                        @can('manage', $project)
                             @include('projects.invite')
                        @endcan
                </div>
        </div>
</main>

@endsection