<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Post;
use App\Common\CommonMethods;

class ShowController extends Controller
{
    public function index()
    {
        $posts = Post::with('comments', 'tags')->latest()->get();
        foreach ($posts as $post) {
            $post['file_path'] = CommonMethods::GetPresignedURL($post['file_path']);
        }

        return view('index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::with('user', 'comments', 'tags')->findOrFail($id);
        $post['file_path'] = CommonMethods::GetPresignedURL($post['file_path']);
        $date = $post->created_at->format('Y/m/d');
        $auth = Auth::id();

        return view('post.show', compact('post', 'date', 'auth'));
    }

    public function destroy($id)
    {
        if (Auth::check()) {
            Post::find($id)->delete();
        }

        return redirect()->route('post.list');
    }
}
