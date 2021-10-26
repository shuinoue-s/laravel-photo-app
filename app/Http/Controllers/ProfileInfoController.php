<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileInfoController extends Controller
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

    public function profileInfo($name)
    {
        $post_user = User::with('profile', 'posts')->where('name', $name)->first();

        if ($post_user->profile) {
            if ($post_user->profile->profile_image) {
                $post_user->profile['profile_image'] = $this->GetPresignedURL($post_user->profile['profile_image']);
            }
        }

        foreach ($post_user->posts as $post) {
            $post['file_path'] = $this->GetPresignedURL($post['file_path']);
        }

        return view('mypage.profile_info', compact('post_user'));
    }
}
