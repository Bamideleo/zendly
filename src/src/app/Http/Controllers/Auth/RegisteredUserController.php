<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\GeneralSetting;
use App\Models\PricingPlan;
use Carbon\Carbon;
use App\Http\Utility\SendMail;
use App\Models\PasswordReset;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */



    public function create()
    {
        $title = "Registration";
        return view('user.auth.register', compact('title'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required'
        ]);
        $code = preg_replace('/[ ,]+/', '', trim($request->code));
        $email = session()->get('registration_verify_email');
        $userResetToken = PasswordReset::where('email', $email)->where('token', $code)->first();
        if(!$userResetToken){
            $notify[] = ['error', 'Invalid verification code'];
            return back()->withNotify($notify);
        }
        
        session()->put('registration_verify_email',null);
        $general = GeneralSetting::first();
        $user = User::where('email',$email)->first();
        if($general->sign_up_bonus == 1){
            $plan = PricingPlan::find($general->plan_id);
            if($plan){
                $user->credit = $plan->credit;
                $user->email_credit = $plan->email_credit;
                $user->whatsapp_credit = $plan->whatsapp_credit;
            }
        }
        $user->status=1;
        $user->save();
        $userResetToken->delete();
        Auth::login($user);
        return redirect(RouteServiceProvider::HOME);
    }

    public function verify(Request $request)
    { 
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]); 

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'status' => 3,
            'password' => Hash::make($request->password),
        ]);
        PasswordReset::where('email', $request->email)->delete();
        $passwordReset = PasswordReset::create([
            'email' => $request->email,
            'token' => randomNumber(),
            'created_at' => Carbon::now(),
        ]);

        $mailCode = [
            'name' => $request->name, 
            'code' => $passwordReset->token, 
            'time' => $passwordReset->created_at,
        ];
        try {
            SendMail::MailNotification($request,'REGISTRATION_VERIFY',$mailCode);
        } catch (Exception $e) {
            $notify[] = ['error', 'Something went wrong! verification code sent successfully, please try with valid email'];
            return back()->withNotify($notify);
        }
        session()->put('registration_verify_email', $request->email);
        $notify[] = ['success', 'Check your email a code sent successfully for verify registration process'];
        return redirect(route('registration.verify.code'))->withNotify($notify);
    }

    public function verifyCode()
    {
        $title = "User Registration Verification";
        $route = "register";
        if(!session()->get('registration_verify_email')) {
            $notify[] = ['error','Your verification session expired please try again'];
            return redirect()->route('registration.verify')->withNotify($notify);
        }
        return view('user.auth.verify_code',compact('title','route'));
    }
}
