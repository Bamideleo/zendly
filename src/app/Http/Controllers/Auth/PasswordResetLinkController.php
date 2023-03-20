<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use App\Http\Utility\SendMail;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $title = "forgot password";
        return view('user.auth.forgot-password', compact('title'));
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $notify[] = ['error', 'User not found.'];
            return back()->withNotify($notify);
        }
        PasswordReset::where('email', $request->email)->delete();
        $passwordReset = PasswordReset::create([
            'email' => $request->email,
            'token' => randomNumber(),
            'created_at' => Carbon::now(),
        ]);
        $mailCode = [
            'code' => $passwordReset->token, 
            'time' => $passwordReset->created_at,
        ];
        SendMail::MailNotification($user,'PASSWORD_RESET',$mailCode);
        session()->put('password_reset_user_email', $request->email);
        $notify[] = ['success', 'check your email password reset code sent successfully'];
        return redirect(route('password.verify.code'))->withNotify($notify);
    }


    public function passwordResetCodeVerify(){
        $title = 'Password Reset';
        $route = "email.password.verify.code";
        if(!session()->get('password_reset_user_email')) {
            $notify[] = ['error','Your email session expired please try again'];
            return redirect()->route('password.request')->withNotify($notify);
        }
        return view('user.auth.verify_code',compact('title','route'));
    }


    public function emailVerificationCode(Request $request)
    {
        $this->validate($request, [
            'code' => 'required'
        ]);
        $code = preg_replace('/[ ,]+/', '', trim($request->code));
        $email = session()->get('password_reset_user_email');
        $userResetToken = PasswordReset::where('email', $email)->where('token', $code)->first();
        if(!$userResetToken){
            $notify[] = ['error', 'Invalid token'];
            return redirect(route('password.request'))->withNotify($notify);
        }
        $notify[] = ['success', 'Change your password.'];
        return redirect()->route('password.reset', $code)->withNotify($notify);

    }
}
