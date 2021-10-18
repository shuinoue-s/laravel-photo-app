<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function form()
    {
        return view('post.form');
    }

    public function upload(PostRequest $request)
    {
        $user_id = Auth::id();
        $upload_image = $request->file('image');

        if($upload_image) {
            $path = $upload_image->store('uploads', 'public');
            if($path) {
                $post = Post::create([
                    'user_id' => $user_id,
                    'file_name' => $upload_image->getClientOriginalName(),
                    'file_path' => $path,
                    'title' => $request->title,
                    'description' => $request->description
                ]);

            }
        }

        $trim = preg_replace('/(　| )/', '', $request->tags);
        preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶ一-龠々]+)/u', $trim, $match);

        $tags = [];
        foreach ($match[1] as $tag) {
            $record = Tag::firstOrcreate(['tag_name' => $tag]);
            array_push($tags, $record);
        }

        $tags_id = [];
        foreach ($tags as $tag) {
            array_push($tags_id, $tag['id']);
        }

        $post->tags()->attach($tags_id);

        return redirect()->route('post.list');
    }

    public function list()
    {
        $user_id = Auth::id();
        $posts = Post::where('user_id', $user_id)
            ->latest()
            ->get();
        $user_name = User::find($user_id);

        return view('post.list', compact('posts', 'user_name'));
    }
}
