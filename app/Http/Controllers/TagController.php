<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\TagRequest;
use App\Common\CommonMethods;

class TagController extends Controller
{
    public function list($id) {
        $tag = Tag::with('posts')->findOrFail($id);
        $posts = $tag->posts;
        foreach ($posts as $post) {
            $post['file_path'] = CommonMethods::GetPresignedURL($post['file_path']);
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
        $tags = Tag::with('posts')->where('tag_name', $trim)->latest()->get();

        if ($tags->isNotEmpty()) {
            foreach ($tags as $tag) {
                $posts = $tag->posts;
                foreach ($posts as $post) {
                    $post['file_path'] = CommonMethods::GetPresignedURL($post['file_path']);
                }

                return view('tag.result', compact('posts', 'tag_name'));
            }
        }  else {
            $message = '検索結果はありません';
            return view('tag.result', compact('message'));
        }
    }
}
