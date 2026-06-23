<?php

namespace App\Http\Controllers;

use App\Models\Issue;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCommentRequest;

class CommentController extends Controller
{
    public function index(Issue $issue)
    {
        $comments = $issue->comments()
            ->latest()
            ->paginate(5);

        return response()->json([
            'comments' => $comments->items(),
            'next_page_url' => $comments->nextPageUrl(),
            'prev_page_url' => $comments->previousPageUrl(),
            'current_page' => $comments->currentPage(),
        ]);
    }

    public function store(StoreCommentRequest $request, Issue $issue)
    {
        $comment = $issue->comments()->create($request->validated());

        return response()->json([
            'message' => 'Comment added successfully',
            'comment' => $comment
        ]);
    }
}