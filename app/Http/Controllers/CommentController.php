<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function create(CommentRequest $request, $id)
    {
        $user_id = Auth::id();

        Comment::create([
            'user_id' => $user_id,
            'post_id' => $id,
            'comment' => $request->comment
        ]);

        return redirect()->route('post.show', compact('id'));
    }

    public function destroy($id)
    {
        if (Auth::check()) {
            Comment::find($id)->delete();
        }

        return back();
    }
}
