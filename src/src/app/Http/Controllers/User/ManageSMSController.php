<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use App\Models\SMSlog;
use App\Models\GeneralSetting;
use App\Models\CreditLog;
use App\Models\SmsGateway;
use Carbon\Carbon;
use Shuchkin\SimpleXLSX;
use App\Jobs\ProcessSms;

class ManageSMSController extends Controller
{
    public function create()
    {
    	$title = "Compose SMS";
    	$user = Auth::user();
    	$groups = $user->group()->get();
    	$templates = $user->template()->get();
    	return view('user.sms.create', compact('title', 'groups', 'templates'));
    }

    public function index()
    {
    	$title = "SMS History";
        $user = Auth::user();
        $smslogs = SMSlog::where('user_id', $user->id)->orderBy('id', 'DESC')->with('smsGateway', 'androidGateway')->paginate(paginateNumber());
    	return view('user.sms.index', compact('title', 'smslogs'));
    }


    public function pending()
    {
        $title = "Pending SMS History";
        $user = Auth::user();
        $smslogs = SMSlog::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 1)->with('smsGateway','androidGateway')->paginate(paginateNumber());
        return view('user.sms.index', compact('title', 'smslogs'));
    }


    public function delivered()
    {
        $title = "Delivered SMS History";
        $user = Auth::user();
        $smslogs = SMSlog::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 4)->with('smsGateway','androidGateway')->paginate(paginateNumber());
        return view('user.sms.index', compact('title', 'smslogs'));
    }

    public function failed()
    {
        $title = "Failed SMS History";
        $user = Auth::user();
        $smslogs = SMSlog::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 3)->with('smsGateway','androidGateway')->paginate(paginateNumber());
        return view('user.sms.index', compact('title', 'smslogs'));
    }

    public function scheduled()
    {
    	$title = "Scheduled SMS History";
    	$user = Auth::user();
        $smslogs = SMSlog::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 2)->with('smsGateway','androidGateway')->paginate(paginateNumber());
        return view('user.sms.index', compact('title', 'smslogs'));
    }

    public function processing()
    {
        $title = "Processing SMS History";
        $user = Auth::user();
        $smslogs = SMSlog::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 5)->with('smsGateway','androidGateway')->paginate(paginateNumber());
        return view('user.sms.index', compact('title', 'smslogs'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'message' => 'required',
            'schedule' => 'required|in:1,2',
            'shedule_date' => 'required_if:schedule,2',
            'group_id' => 'nullable|array|min:1',
            'group_id.*' => 'nullable|exists:groups,id,user_id,'.$user->id,
        ]);

        if(!$request->number && !$request->group_id && !$request->file){
            $notify[] = ['error', 'Invalid number collect format'];
            return back()->withNotify($notify);
        }
        $numberGroupName  = [];
        $allContactNumber  = [];
        if($request->number){
            $contactNumber = preg_replace('/[ ,]+/', ',', trim($request->number));
            $recipientNumber  = explode(",",$contactNumber);
            array_push($allContactNumber, $recipientNumber);

        }

        if($request->group_id){
            $groupNumber = Contact::where('user_id', $user->id)->whereIn('group_id', $request->group_id)->pluck('contact_no')->toArray();
            $numberGroupName = Contact::where('user_id', $user->id)->whereIn('group_id', $request->group_id)->pluck('name','contact_no')->toArray();
            array_push($allContactNumber, $groupNumber);
        }
        if($request->file){
            $extension = strtolower($request->file->getClientOriginalExtension());
            if(!in_array($extension, ['csv','txt','xlsx'])){
                $notify[] = ['error', 'Invalid file extension'];
                return back()->withNotify($notify);
            }
            if($extension == "txt"){
                $contactNumberTxt = file($request->file);
                unset($contactNumberTxt[0]);
                $txtNumber = array_values($contactNumberTxt);
                $txtNumber = preg_replace('/[^a-zA-Z0-9_ -]/s','',$txtNumber);
                array_push($allContactNumber,$txtNumber);
            }
            if($extension == "csv"){
                $contactNumberCsv = array();
                $contactNameCsv = array();
                $nameNumberArray[] = [];
                $csvArrayLength = 0;
                if(($handle = fopen($request->file, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                        if($csvArrayLength == 0){
                           $csvArrayLength = count($data);
                        }
                        foreach($data as $dataVal){
                            if(filter_var($dataVal, FILTER_SANITIZE_NUMBER_INT)){
                                array_push($contactNumberCsv, $dataVal);
                            }
                            else{
                                array_push($contactNameCsv, $dataVal);
                            }
                        }
                    }
                }
                for ($i = 0; $i < $csvArrayLength; $i++){
                    unset($contactNameCsv[$i]);
                }
                if((count($contactNameCsv)) == 0){
                    $contactNameCsv = $contactNumberCsv;
                }
                $nameNumberArray = array_combine($contactNumberCsv, $contactNameCsv);
                $numberGroupName = $numberGroupName +  $nameNumberArray;
                $csvNumber = array_values($contactNumberCsv);
                array_push($allContactNumber, $csvNumber);
            }

            if($extension == "xlsx"){

                $nameNumberArray[] = [];
                $contactNameXlsx = array();
                $exelArrayLength = 0;
                $contactNumberxlsx = array();
                $xlsx = SimpleXLSX::parse($request->file);
                $data = $xlsx->rows();
                foreach($data as $key=>$val){
                    if($exelArrayLength == 0){
                        $exelArrayLength = count($val);
                    }
                    foreach($val as $dataKey=>$dataVal){
                        if(filter_var($dataVal, FILTER_SANITIZE_NUMBER_INT)){
                            array_push($contactNumberxlsx, $dataVal);
                        }
                        else{
                            array_push($contactNameXlsx, (string)$dataVal);
                        }
                    }
                }
                for ($i = 0; $i < $exelArrayLength; $i++){
                    unset($contactNameXlsx[$i]);
                }
                if((count($contactNameXlsx)) == 0){
                    $contactNameXlsx = $contactNumberxlsx;
                }
                $nameNumberArray = array_combine($contactNumberxlsx, $contactNameXlsx);
                $numberGroupName = $numberGroupName +  $nameNumberArray;
                $excelNumber = array_values($contactNumberxlsx);
                array_push($allContactNumber, $excelNumber);
            }
        }
        $general = GeneralSetting::first();
        $contactNewArray = [];
        foreach($allContactNumber as $childArray){
            foreach($childArray as $value){
                $contactNewArray[] = $value;
            }
        }
        $contactNewArray = array_unique($contactNewArray);
        $messages = str_split($request->message,160);
        $totalMessage = count($messages);
        $totalNumber = count($contactNewArray);
        $totalCredit = $totalNumber * $totalMessage;

        if($totalCredit > $user->credit){
            $notify[] = ['error', 'You do not have a sufficient credit for send message'];
            return back()->withNotify($notify);
        }

        $user->credit -=  $totalCredit;
        $user->save();

        $creditInfo = new CreditLog();
        $creditInfo->user_id = $user->id;
        $creditInfo->credit_type = "-";
        $creditInfo->credit = $totalCredit;
        $creditInfo->trx_number = trxNumber();
        $creditInfo->post_credit =  $user->credit;
        $creditInfo->details = $totalCredit." credits were cut for " .$totalNumber . " number send message";
        $creditInfo->save();

        $smsGateway = SmsGateway::where('id', $general->sms_gateway_id)->first();
        if(!$smsGateway){
            $notify[] = ['error', 'Invalid Sms Gateway'];
            return back()->withNotify($notify);
        }
        $setTimeInDelay = 0;
        if($request->schedule == 2){
            $setTimeInDelay = $request->shedule_date;
        }else{
            $setTimeInDelay = Carbon::now();
        }
        foreach ($contactNewArray as $key => $value) {
            $log = new SMSlog();
            if($general->sms_gateway == 1){
                $log->api_gateway_id = $smsGateway->id;
            }
            $log->user_id = $user->id;
            $log->to = $value;
            $log->initiated_time = $request->schedule == 1 ? Carbon::now() : $request->shedule_date;
            if(array_key_exists($value,$numberGroupName)){
                $finalContent = str_replace('{{name}}', $numberGroupName ? $numberGroupName[$value]:$value, offensiveMsgBlock($request->message));
            }
            else{
                $finalContent = str_replace('{{name}}',$value, offensiveMsgBlock($request->message));
            }
            $log->message = $finalContent;
            $log->status = $request->schedule == 2 ? 2 : 1;
            $log->schedule_status = $request->schedule;
            $log->save();

            if($general->sms_gateway == 1){
                if($log->status == 1){
                    if(count($contactNewArray) == 1 && $request->schedule==1){
                        ProcessSms::dispatchNow($value, $request->smsType, $finalContent, $smsGateway->credential, $smsGateway->gateway_code, $log->id);
                    }
                    else{
                        ProcessSms::dispatch($value, $request->smsType, $finalContent, $smsGateway->credential, $smsGateway->gateway_code, $log->id)->delay(Carbon::parse($setTimeInDelay));
                    }
                }
            }
        }
        $notify[] = ['success', 'New SMS request sent, please see in the SMS history for final status'];
        return back()->withNotify($notify);
    }


    public function search(Request $request, $scope)
    {
        $title = "SMS History";
        $search = $request->search;
        $searchDate = $request->date;
        $user = Auth::user();


        if ($search!="") {
            $smslogs = SMSlog::where('user_id', $user->id)->where('to','like',"%$search%");
        }
        if ($searchDate!="") {
            $searchDate_array = explode('-',$request->date);
            $firstDate = $searchDate_array[0];
            $lastDate = null;
            if (count($searchDate_array)>1) {
                $lastDate = $searchDate_array[1];
            }
            $matchDate = "/\d{2}\/\d{2}\/\d{4}/";
            if ($firstDate && !preg_match($matchDate,$firstDate)) {
                $notify[] = ['error','Invalid order search date format'];
                return back()->withNotify($notify);
            }
            if ($lastDate && !preg_match($matchDate,$lastDate)) {
                $notify[] = ['error','Invalid order search date format'];
                return back()->withNotify($notify);
            }
            if ($firstDate) {
                $smslogs = SMSlog::where('user_id', $user->id)->whereDate('created_at',Carbon::parse($firstDate));
            }
            if ($lastDate){
                $smslogs = SMSlog::where('user_id', $user->id)->whereDate('created_at','>=',Carbon::parse($firstDate))->whereDate('created_at','<=',Carbon::parse($lastDate));
            }

        }
        if ($search=="" && $searchDate==""){
                $notify[] = ['error','Please give any search filter data'];
                return back()->withNotify($notify);
        }
        if($scope == 'pending') {
            $smslogs = $smslogs->where('status',SMSlog::PENDING);
        }elseif($scope == 'delivered'){
            $smslogs = $smslogs->where('status',SMSlog::SUCCESS);
        }elseif($scope == 'schedule'){
            $smslogs = $smslogs->where('status',SMSlog::SCHEDULE);
        }elseif($scope == 'failed'){
            $smslogs = $smslogs->where('status',SMSlog::FAILED);
        }

        $smslogs = $smslogs->orderBy('id','desc')->with('user', 'androidGateway', 'smsGateway')->paginate(paginateNumber());
        return view('user.sms.index', compact('title', 'smslogs', 'search','searchDate'));
    }

}
