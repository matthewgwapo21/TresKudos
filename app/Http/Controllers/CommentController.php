<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller {

    public function store(Request $request, Recipe $recipe) {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id'   => auth()->id(),
            'recipe_id' => $recipe->id,
            'body'      => $request->body,
        ]);

        return back()->with('success', 'Comment posted!');
    }

    public function destroy(Comment $comment) {
        if (auth()->id() !== $comment->user_id && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $comment->delete();
        return back()->with('success', 'Comment deleted.');
    }
}