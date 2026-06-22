<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
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
        return view('projects.edit', compact('project'));
    }

    /**
     * Update project
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->validated());

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully');
    }

    /**
     * Delete project
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully');
    }
}
