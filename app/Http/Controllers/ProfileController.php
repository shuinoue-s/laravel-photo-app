<?php

namespace App\Http\Controllers;

use Auth;
use Storage;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use App\Models\User;
use App\Common\CommonMethods;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        $auth = Auth::user();
        $user_profile = Profile::where('user_id', $auth->id)->first();
        if ($user_profile) {
            if ($user_profile->profile_image) {
                $user_profile['profile_image'] = CommonMethods::GetPresignedURL($user_profile['profile_image']);
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
                $user_profile['profile_image'] = CommonMethods::GetPresignedURL($user_profile['profile_image']);
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
        $user_id = Auth::id();
        $guest_user_id = 12;

        if (Auth::check()) {
            if ($user_id !== $guest_user_id) {
                User::find($id)->delete();
            } else {
                $error_message = 'ゲストユーザーでは削除できません';
                return view('mypage.edit', compact('error_message'));
            }
        }
        return redirect()->route('mypage.profile');
    }
}
