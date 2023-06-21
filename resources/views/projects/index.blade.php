@extends ('layouts.app')

@section('content')
<header class="flex items-center mb-3 py-4">
    <div class="flex w-full items-end justify-between">
        <h1 class="text-grey text-sm font-normal">My Projects</h1>
        <a href="/projects/create" class="button">New project</a>
    </div>

</header>
<main class="lg:flex lg:flex-wrap -mx-3">
    @forelse ($projects as $project)
    <div class="lg:w-1/3 px-3 pb-6">
        <div class="card" style="height: 200px;">
            <h3 class="font-normal text-xl mb-3 py-4 -ml-5 border-l-4 border-blue-light pl-4">
                <a href="{{ $project->path() }}" class="text-black no-underline"> {{ $project->title }} </a>
            </h3>
            <div class="text-grey">
                {{ str_limit($project->description, 100) }}
            </div>
        </div>
    </div>
    @empty
    <div>No projects yet.</div>
    @endforelse
</main>

@endsection