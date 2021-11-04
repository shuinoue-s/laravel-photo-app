<?php

namespace App\Http\Controllers;

use Auth;
use App\Http\Requests\PasswordChangeRequest;

class PasswordChangeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function passwordChangeShow()
    {
        $auth = Auth::user();

        return view('mypage.passwordchange_show', compact('auth'));
    }

    public function passwordChange(PasswordChangeRequest $request)
    {
        $auth = Auth::user();
        $auth->password = bcrypt($request->get('password'));
        $auth->save();

        return redirect()->route('mypage.profile')->with('status', __('パスワードが変更されました'));
    }
}
