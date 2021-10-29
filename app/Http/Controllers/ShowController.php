<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
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
        $posts = Post::with('comments', 'tags')->latest()->get();
        foreach ($posts as $post) {
            $post['file_path'] = $this->GetPresignedURL($post['file_path']);
        }

        return view('index', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::with('user', 'comments', 'tags')->findOrFail($id);
        $post['file_path'] = $this->GetPresignedURL($post['file_path']);
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
