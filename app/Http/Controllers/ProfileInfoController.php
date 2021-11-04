<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Common\CommonMethods;

class ProfileInfoController extends Controller
{
    public function profileInfo($name)
    {
        $post_user = User::with('profile', 'posts')->where('name', $name)->first();

        if ($post_user->profile) {
            if ($post_user->profile->profile_image) {
                $post_user->profile['profile_image'] = CommonMethods::GetPresignedURL($post_user->profile['profile_image']);
            }
        }

        foreach ($post_user->posts as $post) {
            $post['file_path'] = CommonMethods::GetPresignedURL($post['file_path']);
        }

        return view('mypage.profile_info', compact('post_user'));
    }
}
