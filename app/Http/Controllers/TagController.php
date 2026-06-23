<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Issue;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\AttachTagRequest;
use App\Http\Requests\DetachTagRequest;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->get();
        return view('tags.index', compact('tags'));
    }

    public function store(StoreTagRequest $request)
    {
        Tag::create($request->validated());

        return back()->with('success', 'Tag created successfully');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return back()->with('success', 'Tag deleted');
    }

    public function all()
    {
        return response()->json(Tag::all());
    }

    public function attach(AttachTagRequest $request, Issue $issue)
    {
        $issue->tags()->syncWithoutDetaching([$request->tag_id]);

        return response()->json([
            'message' => 'Tag attached',
            'tag' => Tag::find($request->tag_id)
        ]);
    }

    public function detach(DetachTagRequest $request, Issue $issue)
    {
        $issue->tags()->detach($request->tag_id);

        return response()->json([
            'message' => 'Tag detached'
        ]);
    }
}
