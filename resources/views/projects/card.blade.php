<div class="card flex flex-col" style="height: 200px;">
    <h3 class="font-normal text-xl mb-3 py-4 -ml-5 border-l-4 border-blue-light pl-4">
        <a href="{{ $project->path() }}" class="text-default no-underline"> {{ $project->title }} </a>
    </h3>
    <div class="text-default mb-4 flex-1">
        {{ str_limit($project->description, $charLimit)  }}
    </div>

    @can('manage', $project)
    <footer>
        <form method="POST" action="{{ $project->path() }}" class="text-right">
            @method('DELETE')
            @csrf
            <button type="submit" class="text-xs">Delete</button>
        </form>
    </footer>
    @endcan
</div>