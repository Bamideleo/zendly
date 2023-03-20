<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Config;
class SocialLoginServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            $general = GeneralSetting::first();
            if($general){
                if($general->s_login_google_info){
                    $google = array(
                        'client_id' => $general->s_login_google_info->g_client_id,
                        'client_secret' => $general->s_login_google_info->g_client_secret,
                        'redirect' => url('auth/google/callback'),
                    );
                    Config::set('services.google', $google);
                }
            }
        }catch(\Exception $exception){
            
        }
    }
}
