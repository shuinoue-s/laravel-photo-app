<?php

namespace App\Http\Controllers;

use Auth;
use Storage;
use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use App\Common\CommonMethods;

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

        if ($request->file('image')->isValid([])) {
            $file_name = $request->file('image')->getClientOriginalName();
            $file_path = Storage::disk('s3')->putFile('/uploads', $request->file('image'));

            $post = new Post();
            $post->user_id = $user_id;
            $post->file_name = $file_name;
            $post->file_path = $file_path;
            $post->title = $request->title;
            $post->description = $request->description;
            $post->save();
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
        $posts = Post::where('user_id', $user_id)->latest()->get();
        foreach ($posts as $post) {
            $post['file_path'] = CommonMethods::GetPresignedURL($post['file_path']);
        }
        $user_name = User::find($user_id);

        return view('post.list', compact('posts', 'user_name'));
    }
}
