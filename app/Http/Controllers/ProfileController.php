<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    public function profile()
    {
        $auth = Auth::user();
        $user_profile = Profile::where('user_id', $auth->id)->first();
        if ($user_profile) {
            if ($user_profile->profile_image) {
                $user_profile['profile_image'] = $this->GetPresignedURL($user_profile['profile_image']);
            }
        }

        return view('mypage.profile', compact('auth', 'user_profile'));
    }

    public function edit()
    {
        $auth = Auth::user();
        $user_profile = Profile::where('user_id', $auth->id)->first();
        if ($user_profile) {
            if ($user_profile->profile_image) {
                $user_profile['profile_image'] = $this->GetPresignedURL($user_profile['profile_image']);
            }
        }

        return view('mypage.edit', compact('auth', 'user_profile'));
    }

    public function create(ProfileRequest $request)
    {
        $auth = Auth::user();
        $user_profile = Profile::where('user_id', $auth->id)->first();
        $upload_icon = $request->file('image');

        if (is_null($user_profile)) {
            if ($upload_icon && $request->body) {
                $file_path = Storage::disk('s3')->putFile('/uploads', $upload_icon);
                Profile::create([
                    'user_id' => $auth->id,
                    'profile_image' => $file_path,
                    'profile_body' => $request->body
                ]);
            }

            if ($upload_icon && !$request->body) {
                $file_path = Storage::disk('s3')->putFile('/uploads', $upload_icon);
                Profile::create([
                    'user_id' => $auth->id,
                    'profile_image' => $file_path,
                    'profile_body' => ''
                ]);
            }

            if (!$upload_icon && $request->body) {
                Profile::create([
                    'user_id' => $auth->id,
                    'profile_image' => '',
                    'profile_body' => $request->body
                ]);
            }
        } else {
            if ($upload_icon && $request->body) {
                $file_path = Storage::disk('s3')->putFile('/uploads', $upload_icon);
                $user_profile->profile_image = $file_path;
                $user_profile->profile_body = $request->body;
                $user_profile->save();
            }

            if ($upload_icon && !$request->body) {
                $file_path = Storage::disk('s3')->putFile('/uploads', $upload_icon);
                $user_profile->profile_image = $file_path;
                $user_profile->profile_body = '';
                $user_profile->save();
            }

            if (!$upload_icon && $request->body) {
                $user_profile->profile_body = $request->body;
                $user_profile->save();
            }
        }

        if(Auth::check()) {
            if ($auth->name !== $request->name) {
                $auth->name = $request->name;
                $auth->save();
            }
        }

       return redirect()->route('mypage.profile');
    }

    public function destroy($id)
    {
        if (Auth::check()) {
            User::find($id)->delete();
        }

        return redirect()->route('mypage.profile');
    }
}
