<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            $user = Auth::user();
            if ($user->status == 1) {
                return $next($request);
            }else{
                Auth::guard('web')->logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
                $notify[] = ['error', "Your account is banned by admin"];
                return redirect()->route('login')->withNotify($notify);
            }
        }
        abort(403);
    }
}
