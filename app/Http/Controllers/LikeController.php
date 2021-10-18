<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Like;

class LikeController extends Controller
{
    public function firstcheck($post)
    {
        $user_id = Auth::id();
        $likes = new Like();
        $like = Like::where('post_id', $post)->where('user_id', $user_id)->first();

        if ($like) {
            $count = $likes->where('post_id', $post)->where('like', 1)->count();
            return [$like->like, $count];
        } else {
            $like = $likes->create([
                'user_id' => $user_id,
                'post_id' => $post,
                'like' => 0
            ]);
            $count = $likes->where('post_id', $post)->where('like', 1)->count();
            return [$like->like, $count];
        }
    }

    public function check($post)
    {
        $user_id = Auth::id();
        $likes = new Like();
        $like = Like::where('post_id', $post)->where('user_id', $user_id)->first();

        if ($like->like == 1) {
            $like->like = 0;
            $like->save();
            $count = $likes->where('post_id',$post)->where('like',1)->count();
            return [$like->like,$count];
        } else {
            $like->like = 1;
            $like->save();
            $count = $likes->where('post_id',$post)->where('like',1)->count();
            return [$like->like,$count];
       };
    }
}
