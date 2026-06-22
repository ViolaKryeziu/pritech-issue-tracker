<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Project;
use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;

class IssueController extends Controller
{
    public function index()
    {
        $issues = Issue::with('project')
            ->latest()
            ->paginate(10);

        return view('issues.index', compact('issues'));
    }

    public function create()
    {
        $projects = Project::orderBy('name')->get();

        return view('issues.create', compact('projects'));
    }

    public function store(StoreIssueRequest $request)
    {
        Issue::create($request->validated());

        return redirect()
            ->route('issues.index')
            ->with('success', 'Issue created successfully.');
    }

    public function show(Issue $issue)
    {
        $issue->load('project');

        return view('issues.show', compact('issue'));
    }

    public function edit(Issue $issue)
    {
        $projects = Project::orderBy('name')->get();

        return view('issues.edit', compact('issue', 'projects'));
    }

    public function update(UpdateIssueRequest $request, Issue $issue)
    {
        $issue->update($request->validated());

        return redirect()
            ->route('issues.index')
            ->with('success', 'Issue updated successfully.');
    }

    public function destroy(Issue $issue)
    {
        $issue->delete();

        return redirect()
            ->route('issues.index')
            ->with('success', 'Issue deleted successfully.');
    }
}