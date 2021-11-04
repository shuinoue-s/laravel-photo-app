<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Support\Str;
use App\Models\EmailReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\EmailChangeRequest;

class EmailChangeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function emailChangeShow()
    {
        $auth = Auth::user();

        return view('mypage.emailchange_show', compact('auth'));
    }

    public function emailChange(EmailChangeRequest $request)
    {
        $auth = Auth::user();
        $email_check = true;

        if ($auth->email == $request->new_email) {
            $email_check = false;
        }

        $validator = Validator::make(['email' => $email_check],['email' => 'accepted'], ['メールアドレスが変更されていません']);

        if ($validator->fails()) {
            return redirect()->route('mypage.emailchange_show')->withErrors($validator)->withInput();
        }

        $new_email = $request->new_email;
        $token = hash_hmac(
            'sha256',
            Str::random(40).$new_email,
            config('app.key')
        );

        DB::beginTransaction();
        try {
            $param = [];
            $param['user_id'] = Auth::id();
            $param['new_email'] = $new_email;
            $param['token'] = $token;
            $email_reset = EmailReset::create($param);

            DB::commit();

            $email_reset->sendEmailResetNotification($token);

            return redirect()->route('mypage.profile')->with('flash_message', '確認メールを送信しました');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('mypage.emailchange_show')->with('flash_message', 'メールアドレスの更新に失敗しました');
        }
    }

    public function emailReset($token)
    {
        $email_resets = DB::table('email_resets')
            ->where('token', $token)
            ->first();

        if ($email_resets && !$this->tokenExpired($email_resets->created_at)) {
            $user = User::find($email_resets->user_id);
            $user->email = $email_resets->new_email;
            $user->save();

            DB::table('email_resets')
                ->where('token', $token)
                ->delete();

            return redirect()->route('mypage.profile')->with('flash_message', 'メールアドレスを更新しました');
        } else {
            if ($email_resets) {
                DB::table('email_resets')
                    ->where('token', $token)
                    ->delete();
            }
            return redirect()->route('mypage.emailchange_show')->with('flash_message', 'メールアドレスの更新に失敗しました');
        }
    }

    protected function tokenExpired($createdAt)
    {
        $expires = 60 * 60;
        return Carbon::parse($createdAt)->addSeconds($expires)->isPast();
    }
}
