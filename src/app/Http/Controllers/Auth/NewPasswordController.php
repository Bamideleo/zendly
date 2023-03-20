<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\PasswordReset;
use App\Models\User;
use App\Http\Utility\SendMail;
use Carbon\Carbon;

class NewPasswordController extends Controller
{
    public function create($token)
    {
        $title = "Password change";
        $passwordToken = $token;
        $email = session()->get('password_reset_user_email');
        $userResetToken = PasswordReset::where('email', $email)->where('token', $token)->first();
        if(!$userResetToken){
            $notify[] = ['error', 'Invalid token'];
            return redirect(route('password.request'))->withNotify($notify);
        }
        return view('user.auth.reset',compact('title', 'passwordToken'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6',
            'token' => 'required|exists:password_resets,token',
        ]);
        $email = session()->get('password_reset_user_email');
        $userResetToken = PasswordReset::where('email', $email)->where('token', $request->token)->first();
        if(!$userResetToken){
            $notify[] = ['error', 'Invalid token'];
            return redirect(route('password.request'))->withNotify($notify);
        }
        $user = User::where('email', $email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        if(session()->get('password_reset_user_email')){
            session()->forget('password_reset_user_email');
        }
        $mailCode = [
            'time' => Carbon::now(),
        ];
        SendMail::MailNotification($user,'PASSWORD_RESET_CONFIRM',$mailCode);
        $notify[] = ['success', 'Password changed successfully'];
        $userResetToken->delete();
        return redirect(route('login'))->withNotify($notify);
    }
}
