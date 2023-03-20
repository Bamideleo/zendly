<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Response;
use App\Models\AndroidApiSimInfo;
use App\Models\SMSlog;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\CreditLog;

class ManageSMSController extends Controller
{
    
    public function simInfo(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'country_code' => 'required',
            'android_gateway_id' => 'required|exists:android_apis,id',
            'sim_number' => 'required',
            'time_interval' => 'required|integer',
            'sms_remaining' => 'required|integer',
            'send_sms' => 'required|integer',
            'status' => 'required|in:1,2',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => $validator->errors(),
            ],200);
        }
        $data = [
            'android_gateway_id' =>  $request->android_gateway_id,
            'sim_number' => $request->sim_number,
            'time_interval' =>  $request->time_interval,
            'sms_remaining' =>  $request->sms_remaining,
            'send_sms' =>   $request->send_sms,
            'status' => $request->status
        ];
        $simInfo = null;
        $general = GeneralSetting::first();
        if($general->country_code != $request->country_code){
            return response()->json([
                'status' => false,
                'data' => [
                    "message" => 'Invalid Country Code',
                ],
            ],200);
        }
        $simInfo = AndroidApiSimInfo::where('android_gateway_id', $request->android_gateway_id)
            ->where('sim_number', $request->sim_number)->first();
        if($simInfo){
            $simInfo->update($data);
        }else{
            $simInfo = AndroidApiSimInfo::create($data);
        }
        return response()->json([
            'status' => true,
            'android_gateway_sim_id' => $simInfo->id,
        ],200);
    }

    public function smsfind(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'country_code' => 'required',
            'android_gateway_sim_id' => 'required|exists:android_api_sim_infos,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => $validator->errors(),
            ],400);
        }
        $smslogs = SMSlog::whereNull('api_gateway_id')->where('android_gateway_sim_id',$request->android_gateway_sim_id)
        ->where('status', 1)->select('id', 'android_gateway_sim_id','to','initiated_time', 'message')->take(1)->get();
        return response()->json([
            'status' => true,
            'smsLogs' => $smslogs,
        ],200);
    }


    public function smsStatusUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:s_m_slogs,id',
            'status' => 'required|in:4,3',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => $validator->errors(),
            ],400);
        }
        $smslog = SMSlog::where('id',$request->id)->where('status', 1)->first();
        if(!$smslog){
            return response()->json([
                'status' => false,
            ],200);
        }
        if($smslog){
            if($request->status == 4){
                $smslog->status = 4;
                $smslog->save();
            }else{

                $smslog->response_gateway = $request->response_gateway;
                $smslog->status = 3;
                $smslog->save();


                $messages = str_split($smslog->message,160); 
                $totalcredit = count($messages);

                $user = User::find($log->user_id);
                $user->credit += $totalcredit;
                $user->save();

                $creditInfo = new CreditLog();
                $creditInfo->user_id = $smslog->user_id;
                $creditInfo->credit_type = "+";
                $creditInfo->credit = $totalcredit;
                $creditInfo->trx_number = trxNumber();
                $creditInfo->post_credit =  $user->credit;
                $creditInfo->details = $totalcredit." Credit Return ".$smslog->to." is Falied";
                $creditInfo->save();
            }
        }
        return response()->json([
            'status' => true,
        ],200);

    }


    public function simClosed(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'status' => 'required|in:1,2',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'data' => $validator->errors(),
            ],400);
        }
        $array = explode(",", $request->id);
        $simInfos = AndroidApiSimInfo::whereIn('id', $array)->get();
        if($simInfos->isNotEmpty()){
            foreach($simInfos as $simInfo){
               $simInfo->status = $request->status;
               $simInfo->save(); 
            }
        }
        return response()->json([
            'status' => true,
        ],200);
    }


    public function init()
    {
        $general = GeneralSetting::select('site_name')->first();
        return $general;
    }
}
