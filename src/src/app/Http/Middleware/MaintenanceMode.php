<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Illuminate\Http\Response;

class MaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $general = GeneralSetting::first();
        if ($general->maintenance_mode=="true") {
            $site_name = $general->site_name;
            $maintenance_mode_message = $general->maintenance_mode_message;
            return new Response(view('errors.maintenance',compact('site_name','maintenance_mode_message')));
        }
        return $next($request);
    }
}
