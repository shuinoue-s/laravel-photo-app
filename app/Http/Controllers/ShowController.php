<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ShowController extends Controller
{
    public function GetPresignedURL(string $s3_key)
    {
        $s3 = Storage::disk('s3');
        $client = $s3->getDriver()->getAdapter()->getClient();
        $command = $client->getCommand('GetObject', [
            'Bucket' => env('AWS_BUCKET'),
            'Key' => $s3_key
        ]);
        $request = $client->createPresignedRequest($command, "+10 minutes");
        return (string) $request->getUri();
    }

    public function index()
    {
        $posts = Post::all()->sortByDesc('created_at');
        foreach ($posts as $post) {
            $post['file_path'] = $this->GetPresignedURL($post['file_path']);
        }

        return view('index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $post['file_path'] = $this->GetPresignedURL($post['file_path']);
        $date = $post->created_at->format('Y/m/d');
        $auth = Auth::id();
        $post_user = $post->user()->where('id', $post->user_id)->get();
        $comments = Comment::where('post_id', $id)->latest()->get();
        $tags = $post->tags->toArray();
        return view('post.show', compact('post', 'date', 'auth', 'comments', 'tags', 'post_user'));
    }

    public function destroy($id)
    {
        if (Auth::check()) {
            Post::find($id)->delete();
        }

        return redirect()->route('post.list');
    }
}
