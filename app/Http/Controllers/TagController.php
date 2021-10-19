<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Requests\TagRequest;
use Illuminate\Support\Facades\Storage;

class TagController extends Controller
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
    
    public function list($id) {
        $tag = Tag::findOrFail($id);
        $posts = $tag->posts;
        foreach ($posts as $post) {
            $post['file_path'] = $this->GetPresignedURL($post['file_path']);
        }

        return view('tag.list', compact('tag', 'posts'));
    }

    public function search()
    {
        return view('tag.search');
    }

    public function result(TagRequest $request)
    {
        $tag_name = $request->tag;
        $trim = preg_replace('/(　| )/', '', $tag_name);
        $tags = Tag::where('tag_name', $trim)->latest()->get();

        if ($tags->isNotEmpty()) {
            foreach ($tags as $tag) {
                $posts = $tag->posts;
                foreach ($posts as $post) {
                    $post['file_path'] = $this->GetPresignedURL($post['file_path']);
                }

                return view('tag.result', compact('posts', 'tag_name'));
            }
        }  else {
            $message = '検索結果はありません';
            return view('tag.result', compact('message'));
        }
    }
}
