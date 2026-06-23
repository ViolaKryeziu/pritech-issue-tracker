<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of projects
     */
    public function index()
    {
        $projects = Project::with('issues')
            ->latest()
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store new project
     */
    public function store(StoreProjectRequest $request)
    {
        Project::create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully');
    }

    /**
     * Show single project
     */
    public function show(Project $project)
    {
        $project->load([
            'issues.comments',
            'issues.tags',
            'issues.users'
        ]);

        return view('projects.show', compact('project'));
    }

    /**
     * Show edit form
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update project
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update($request->validated());

        return redirect()->route('projects.index');
    }

    /**
     * Delete project
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('projects.index');
    }
}
