<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use App\Models\Tag;
use App\Models\User;
use App\Models\Project;
use App\Http\Requests\StoreIssueRequest;
use App\Http\Requests\UpdateIssueRequest;
use Illuminate\Http\Request;

class IssueController extends Controller
{
    public function index(Request $request)
    {
        $issues = Issue::with(['project', 'tags', 'users'])
            ->when(
                $request->status,
                fn($q) =>
                $q->where('status', $request->status)
            )
            ->when(
                $request->priority,
                fn($q) =>
                $q->where('priority', $request->priority)
            )
            ->when($request->tag, function ($q) use ($request) {
                $q->whereHas('tags', function ($t) use ($request) {
                    $t->where('tags.id', $request->tag);
                });
            })
            ->latest()
            ->paginate(10);

        return view('issues.index', compact('issues'));
    }

    public function create(Request $request)
    {
        $projects = Project::orderBy('name')->get();

        return view('issues.create', [
            'projects' => $projects,
            'selectedProject' => $request->project_id,
        ]);
    }

    public function store(StoreIssueRequest $request)
    {
        Issue::create($request->validated());

        return redirect()->route('issues.index')
            ->with('success', 'Issue created successfully.');
    }

    public function show(Issue $issue)
    {
        $issue->load(['project', 'tags']);

        $tags = Tag::all();
        $users = User::all();

        return view('issues.show', compact('issue', 'tags', 'users'));
    }

    public function edit(Issue $issue)
    {
        $projects = Project::orderBy('name')->get();

        return view('issues.edit', compact('issue', 'projects'));
    }

    public function update(UpdateIssueRequest $request, Issue $issue)
    {
        $issue->update($request->validated());

        return redirect()->route('issues.index')
            ->with('success', 'Issue updated successfully.');
    }

    public function destroy(Issue $issue)
    {
        $issue->delete();

        return redirect()->route('issues.index')
            ->with('success', 'Issue deleted successfully.');
    }

    public function attachUser(Request $request, Issue $issue)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $issue->users()->syncWithoutDetaching([$request->user_id]);

        return response()->json([
            'message' => 'User attached successfully',
            'user' => User::find($request->user_id)
        ]);
    }
    public function detachUser(Request $request, Issue $issue)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $issue->users()->detach($request->user_id);

        return response()->json([
            'message' => 'User detached successfully'
        ]);
    }
}
