<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AndroidApi;
use App\Models\AndroidApiSimInfo;
use App\Models\SMSlog;
use App\Models\Subscription;
use App\Models\GeneralSetting;
use App\Models\SmsGateway;
use App\Models\EmailLog;
use App\Jobs\ProcessSms;
use Carbon\Carbon;
use App\Jobs\ProcessEmail;

class CronController extends Controller
{

    public function run()
    {
        $setting = GeneralSetting::first();

        $this->androidApiSim();
        $this->emailSchedule();

        if(Carbon::parse($setting->schedule_at)->addMinute(30) < Carbon::now()){
            $this->subscription();
            $this->smsSchedule();
            $setting->schedule_at = Carbon::now();
        }

        $setting->cron_job_run = Carbon::now();
        $setting->save();
    }
    protected function androidApiSim(){
        $androidApis = AndroidApi::where('status', 1)->pluck('id')->toArray();
        $simInfos = AndroidApiSimInfo::whereIn('android_gateway_id', $androidApis)->where('status', 1)->pluck('id')->toArray();
        if($simInfos){
            $smslogs = SMSlog::whereNull('api_gateway_id')->whereNull('android_gateway_sim_id')->where('status', 1)->get();
            foreach ($smslogs as $key => $smslog) {
                $smslog->android_gateway_sim_id = $simInfos[array_rand($simInfos,1)];
                $smslog->save();
            }
        }
    }

    protected function subscription()
    {
        $subscriptions = Subscription::where('status',1)->get();
        foreach($subscriptions as $subscription){
            $expiredTime = $subscription->expired_date;
            $now = Carbon::now()->toDateTimeString();
            if($now > $expiredTime){
                $subscription->status = 2;
                $subscription->save();
            }
        }
    }

    protected function smsSchedule()
    {
        $smslogs = SMSlog::where('status', 2)->where('schedule_status', 2)->get();
        foreach($smslogs as $smslog){
            $expiredTime = $smslog->initiated_time;
            $now = Carbon::now()->toDateTimeString();
            if($now > $expiredTime){
                $general = GeneralSetting::first();
                if($general->sms_gateway == 1){
                    $smsGateway = SmsGateway::where('id', $general->sms_gateway_id)->first();
                    $smslog->api_gateway_id = $smsGateway->id;
                    $smslog->android_gateway_sim_id = null;
                    ProcessSms::dispatch($smslog->to, $smslog->user->phone, $smslog->message, $smsGateway->credential, $smsGateway->gateway_code, $smslog->id);
                }else{
                    $smslog->status = 1;
                    $smslog->api_gateway_id = null;
                    $smslog->android_gateway_sim_id = null;
                }
                $smslog->save();
            }
        }

        $pendingsmslogs = SMSlog::where('status', 1)->get();
        foreach($pendingsmslogs as $pendingsms){
            $general = GeneralSetting::first();
            if($general->sms_gateway == 1){
                $smsGateway = SmsGateway::where('id', $general->sms_gateway_id)->first();
                $pendingsms->api_gateway_id = $smsGateway->id;
                $pendingsms->android_gateway_sim_id = null;
                ProcessSms::dispatch($pendingsms->to, $pendingsms->user->phone, $pendingsms->message, $smsGateway->credential, $smsGateway->gateway_code, $pendingsms->id);
            }else{
                $pendingsms->status = 1;
                $pendingsms->api_gateway_id = null;
            }
            $pendingsms->save();
        }
    }

    protected function emailSchedule()
    {
        $emailLogs = EmailLog::where('status', 2)->where('schedule_status', 2)->get();
        foreach($emailLogs as $emailLog){
            $expiredTime = $emailLog->initiated_time;
            $now = Carbon::now()->toDateTimeString();
            if($now > $expiredTime){
                $general = GeneralSetting::first();
                ProcessEmail::dispatch($emailLog->id);
            }
        }
    }

}
