<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ShowController extends Controller
{
    public function index()
    {
        $posts = Post::all()->sortByDesc('created_at');

        return view('index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $date = $post->created_at->format('Y/m/d');
        $auth = Auth::id();
        $comments = Comment::where('post_id', $id)->latest()->get();
        $tags = $post->tags->toArray();
        return view('post.show', compact('post', 'date', 'auth', 'comments', 'tags'));
    }

    public function destroy($id)
    {
        if (Auth::check()) {
            Post::find($id)->delete();
        }

        return redirect()->route('post.list');
    }
}
