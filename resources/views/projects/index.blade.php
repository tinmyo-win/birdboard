@extends ('layouts.app')

@section('content')
<header class="flex items-center mb-3 py-4">
    <div class="flex w-full items-end justify-between">
        <h1 class="text-grey text-sm font-normal">My Projects</h1>
        <a href="/projects/create" class="button" @click.prevent="$modal.show('new-project')">New project</a>
    </div>

</header>
<main class="lg:flex lg:flex-wrap -mx-3">
    @forelse ($projects as $project)
    <div class="lg:w-1/3 px-3 pb-6">
        @include('projects.card', ['charLimit' => 100])
    </div>
    @empty
    <div>No projects yet.</div>
    @endforelse
</main>

<new-project-modal></new-project-modal>

@endsection