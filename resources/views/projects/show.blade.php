@extends ('layouts.app')

@section('content')
<header class="flex items-center mb-3 py-4">
        <div class="flex w-full items-end justify-between">
                <h1 class="text-grey text-sm font-normal">My Projects</h1>
                <a href="/projects/create" class="button">New project</a>
        </div>

</header>
<main>
        <div>
                <div>
                        <h2 class="text-grey font-normal">Tasks</h2>
                        <h2 class="text-grey font-normal">General Notes</h2>
                </div>
                <div>
                        <div class="card">
                                <h1>{{ $project->title }}</h1>
                                <div> {{ $project->description }}</div>
                                <a href="/projects">Go Back</a>
                        </div>
                </div>
        </div>
</main>

@endsection