<?php

namespace App\Http\Controllers;

use App\Project;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectsController extends Controller
{
    public function index()
    {
        try {
            // $projects = Project::all();
            $projects = auth()->user()->projects;

            return view('projects.index', compact('projects'));
        } catch (Exception $e) {
            Log::info($e->getTraceAsString());
        }
    }

    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3',
        ]);

        $project = auth()->user()->projects()->create($attributes);

        return redirect($project->path());
    }

    public function update(Project $project)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }

        $project->update(request(['notes']));

        return redirect($project->path());
    }

    public function show(Project $project)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }
        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }
}
