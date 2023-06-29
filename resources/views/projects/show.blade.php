@extends ('layouts.app')

@section('content')
<header class="flex items-center mb-3 py-4">
        <div class="flex w-full items-end justify-between">
                <p class="text-grey text-sm font-normal">
                        <a href="/projects" class="text-grey text-sm font-normal no-underline">
                                My Projects
                        </a> / {{ $project->title }}
                </p>
                <a href="{{ $project->path(). '/edit' }}" class="button">Edit Project</a>
        </div>

</header>
<main>
        <div class="lg:flex -mx-3">
                <div class="lg:w-3/4 px-3 mb-6">
                        <div class="mb-8">
                                <h2 class="text-lg text-grey font-normal mb-3">Tasks</h2>

                                <!-- tasks -->
                                @foreach ($project->tasks as $task)
                                <div class="card mb-3">
                                        <form method="POST" action="{{ $task->path() }}">
                                                @method('PATCH')
                                                @csrf
                                                <div class="flex">
                                                        <input name="body" value="{{ $task->body }}" class="w-full {{ $task->completed ? 'text-grey' : '' }}">
                                                        <input name="completed" type="checkbox" onchange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}>
                                                </div>
                                        </form>
                                </div>
                                @endforeach
                                <div class="card mb-3">
                                        <form action="{{ $project->path() . '/tasks' }}" method="POST">
                                                @csrf
                                                <input placeholder="Add a new Task" class="w-full" name="body">
                                        </form>
                                </div>

                        </div>
                        <div>
                                <h2 class="text-lg text-grey font-normal mb-3">General Notes</h2>
                                <form action="{{ $project->path() }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <textarea 
                                                name="notes"
                                                class="card w-full mb-4" 
                                                placeholder="Anything special that you want to make a note of" 
                                                style="min-height: 200px;"
                                        >
                                                {{ $project->notes }}
                                        </textarea>
                                        <button type="submit" class="button">Save</button>
                                </form>
                        </div>
                </div>
                <div class="lg:w-1/4 px-3">
                        @include('projects.card', ['charLimit' => PHP_INT_MAX])
                </div>
        </div>
</main>

@endsection

@if($errors->any())
    <div class="field mt-6">
        @foreach($errors->all() as $error)
            <li class="text-sm text-red">{{$error }}</li>
        @endforeach
    </div>
@endif