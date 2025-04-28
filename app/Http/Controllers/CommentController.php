<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index()
    {
        return Comment::with('user', 'post')->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_id'=>'required|exists:posts,id',
            'content'=>'required'
        ]);

        $comment = Comment::create([
            'content' => $request->content,
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
        ]);

        return response()->json($comment, 201);
    }

    public function show(Comment $comment)
    {
        return $comment->load('user', 'post');
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content'=>'required'
        ]);

        $comment->update([
            'content'=>$request->content
        ]);

        return response()->json($comment);
    }

    public function destroy(Comment $comment)
    {

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
