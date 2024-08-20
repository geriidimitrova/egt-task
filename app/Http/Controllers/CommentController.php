<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Get all comments based on user's authorizations
     *
     */
    public function getComments()
    {
        $comments = Comment::where('is_approved', !request()->user()->is_admin)->with('user')->get();
        return view('comments.index', compact('comments'));
    }

    /**
     * Create new comment
     *
     */
    public function create(Request $request): \Illuminate\Http\JsonResponse
    {
        // Check if user has already sent a comment within last 24 hours
        $lastComment = Comment::where('user_id', auth()->id())
            ->where('created_on', '>=', Carbon::now()->subDays(1)->unix())
            ->first();

        if ($lastComment) {
            return response()->json([
                'message' => 'You can submit comment for approval only once within 24 hours.'
            ], 400);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // is_approved has default value 0,
        Comment::create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'created_on' => Carbon::now()->unix(),
        ]);

        return response()->json(['message' => 'Comment submitted for approval'], 200);
    }

    /**
     * Approve comment
     *
     */
    public function update($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->is_approved = 1;
            $comment->saveOrFail();

            return response()->json(['message' => 'Comment approved successfully.']);
        }
        return response()->json(['message' => 'Comment not found.'], 400);
    }

    /**
     * Reject comment
     *
     */
    public function delete($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $comment->deleteOrFail();
            return response()->json(['message' => 'Comment removed successfully.']);
        }
        return response()->json(['message' => 'Comment not found.'], 400);
    }
}
