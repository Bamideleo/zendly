<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Artisan;
use Image;
use App\Models\PricingPlan;

class GeneralSettingController extends Controller
{
    public function index()
    {
        $title = "General Setting";
        $general = GeneralSetting::first();
        $timeLocations = timezone_identifiers_list();
        $countries = json_decode(file_get_contents(resource_path('views/partials/country_file.json')));
        $plans = PricingPlan::select('id', 'name')->latest()->get();
        return view('admin.setting.index', compact('title', 'general', 'timeLocations','countries', 'plans'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'site_name' => 'required|max:255',
            'country_code' => 'required|max:30',
            'currency_name' => 'required|max:10',
            'currency_symbol' => 'required|max:10',
            'site_logo' => 'nullable|image|mimes:jpg,png,jpeg',
            'site_favicon' => 'nullable|image|mimes:jpg,png,jpeg',
        ]);
        $timeLocationFile = config_path('timesetup.php');
        $timedata = '<?php $timelog = '.$request->timelocation.' ?>';
        file_put_contents($timeLocationFile, $timedata);
        $general = GeneralSetting::first();
        $general->plan_id = $request->plan_id;
        $general->sign_up_bonus = $request->sign_up_bonus;
        $general->site_name = $request->site_name;
        $general->country_code = $request->country_code;
        $general->sms_gateway = $request->sms_gateway;
        $general->registration_status  = $request->registration_status;
        $general->currency_name = $request->currency_name;
        $general->currency_symbol = $request->currency_symbol; 
        $general->debug_mode = $request->debug_mode=="" ? "false" : $request->debug_mode;
        $general->maintenance_mode = $request->maintenance_mode=="" ? "false" : $request->maintenance_mode;
        if ($request->maintenance_mode_message!='') {
            $general->maintenance_mode_message = $request->maintenance_mode_message;
        }
        $general->save();
        if ($request->debug_mode==true) {
            $path = base_path('.env');
            $env_content = file_get_contents($path);
            if (file_exists($path)) {
               file_put_contents($path, str_replace('APP_ENV=production', 'APP_ENV=local', $env_content));
               $env_content = file_get_contents($path);
               file_put_contents($path, str_replace('APP_DEBUG=false', 'APP_DEBUG=true', $env_content));
            }
        }else{
            $path = base_path('.env');
            $env_content = file_get_contents($path);
            if (file_exists($path)) {
               file_put_contents($path, str_replace('APP_ENV=local', 'APP_ENV=production', $env_content));
               $env_content = file_get_contents($path);
               file_put_contents($path, str_replace('APP_DEBUG=true', 'APP_DEBUG=false', $env_content));
            }
        }
        if($request->hasFile('site_logo')) {
            try{
                $path = filePath()['site_logo']['path'];
                if (!file_exists($path)) {mkdir($path, 0755, true);}
                Image::make($request->site_logo)->save($path . '/site_logo.png');
            }catch (\Exception $exp) {
                $notify[] = ['error', 'Logo could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
        if($request->hasFile('site_favicon')) {
            try{
                $path = filePath()['site_logo']['path'];
                if (!file_exists($path)) {mkdir($path, 0755, true);}
                $size = explode('x', filePath()['favicon']['size']);
                Image::make($request->site_favicon)->resize($size[0], $size[1])->save($path . '/site_favicon.png');
            }catch (\Exception $exp) {
                $notify[] = ['error', 'Favicon could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
        $notify[] = ['success', 'General Setting has been updated'];
        return back()->withNotify($notify);
    }

    public function cacheClear()
    {
        Artisan::call('optimize:clear');
        $notify[] = ['success','Cache cleared successfully'];
        return back()->withNotify($notify);
    }

    public function installPassportKey()
    {
        shell_exec('php ../artisan passport:install');
        shell_exec('php ../artisan passport:keys');
        $notify[] = ['success','Passport api key generated successfully'];
        return back()->withNotify($notify);
    }

    public function systemInfo()
    {
        $title = "System Information";
        $systemInfo['laravelversion'] = app()->version();
        $systemInfo['serverdetail'] = $_SERVER;
        $systemInfo['phpversion'] = phpversion();
        return view('admin.system_info',compact('title','systemInfo'));
    }

    public function socialLogin()
    {
        $title = "Social Login Credentials";
        return view('admin.setting.socal_login', compact('title'));
    }

    public function socialLoginUpdate(Request $request)
    {
        $this->validate($request, [
            'g_client_id' => 'required',
            'g_client_secret' => 'required',
        ]);
        $general = GeneralSetting::first();
        $google = [
            'g_client_id' => $request->g_client_id,
            'g_client_secret' => $request->g_client_secret,
        ];
        $general->s_login_google_info = $google;
        $general->save();
        $notify[] = ['success', 'Social login setting has been updated'];
        return back()->withNotify($notify);
    }

    public function frontendSection()
    {
        $title = "Manage Frontend Section";
        return view('admin.setting.frontend_section', compact('title'));
    }


    public function frontendSectionStore(Request $request)
    {
         $this->validate($request, [
            'heading' => 'required',
            'sub_heading' => 'required',
        ]);
        $general = GeneralSetting::first();
        $frontend = [
            'heading' => $request->heading,
            'sub_heading' => $request->sub_heading,
        ];
        $general->frontend_section = $frontend;
        $general->save();
        $notify[] = ['success', 'Frontend section has been updated'];
        return back()->withNotify($notify);
    }
}
