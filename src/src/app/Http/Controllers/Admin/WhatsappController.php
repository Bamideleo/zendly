<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SMSlog;
use App\Models\User;
use App\Models\CreditLog;
use App\Models\Group;
use App\Models\GeneralSetting;
use App\Models\SmsGateway;
use App\Models\Template;
use App\Models\Contact;
use App\Jobs\ProcessWhatsapp;
use App\Models\WhatsappCreditLog;
use App\Models\WhatsappDevice;
use App\Models\WhatsappLog;
use App\Rules\MessageFileValidationRule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Shuchkin\SimpleXLSX;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;


class WhatsappController extends Controller
{
    public function index()
    {
        $title = "All Whatsapp Message History";
        $smslogs = WhatsappLog::orderBy('id', 'DESC')->with('user', 'whatsappGateway')->paginate(paginateNumber());
        return view('admin.whatsapp_messaging.index', compact('title', 'smslogs'));
    }

    public function pending()
    {
        $title = "Pending Whatsapp Message History";
        $smslogs = WhatsappLog::where('status',WhatsappLog::PENDING)->orderBy('id', 'DESC')->with('user', 'whatsappGateway')->paginate(paginateNumber());
        return view('admin.whatsapp_messaging.index', compact('title', 'smslogs'));
    }

    public function success()
    {
        $title = "Delivered Whatsapp Message History";
        $smslogs = WhatsappLog::where('status',WhatsappLog::SUCCESS)->orderBy('id', 'DESC')->with('user', 'whatsappGateway')->paginate(paginateNumber());
        return view('admin.whatsapp_messaging.index', compact('title', 'smslogs'));
    }

    public function schedule()
    {
        $title = "Schedule Whatsapp Message History";
        $smslogs = WhatsappLog::where('status',WhatsappLog::SCHEDULE)->orderBy('id', 'DESC')->with('user', 'whatsappGateway')->paginate(paginateNumber());
        return view('admin.whatsapp_messaging.index', compact('title', 'smslogs'));
    }

    public function failed()
    {
        $title = "Failed Whatsapp Message History";
        $smslogs = WhatsappLog::where('status',WhatsappLog::FAILED)->orderBy('id', 'DESC')->with('user', 'whatsappGateway')->paginate(paginateNumber());
        return view('admin.whatsapp_messaging.index', compact('title', 'smslogs'));
    }

    public function processing()
    {
        $title = "Processing Whatsapp Message History";
        $smslogs = WhatsappLog::where('status',WhatsappLog::PROCESSING)->orderBy('id', 'DESC')->with('user', 'whatsappGateway')->paginate(paginateNumber());
        return view('admin.whatsapp_messaging.index', compact('title', 'smslogs'));
    }

    public function search(Request $request, $scope)
    {
        $title = "WhatsApp Message History Search";
        $search = $request->search;
        $searchDate = $request->date;

        if ($search!="") {
            $smslogs = WhatsappLog::where(function ($q) use ($search) {
                $q->where('to','like', "%$search%")->orWhereHas('user', function ($user) use ($search) {
                    $user->where('email', 'like', "%$search%");
                });
            });
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
                $smslogs = WhatsappLog::whereDate('created_at',Carbon::parse($firstDate));
            }
            if ($lastDate){
                $smslogs = WhatsappLog::whereDate('created_at','>=',Carbon::parse($firstDate))->whereDate('created_at','<=',Carbon::parse($lastDate));
            }
        }

        if ($search=="" && $searchDate=="") {
            $notify[] = ['error','Search data field empty'];
            return back()->withNotify($notify);
        }


        if($scope == 'pending') {
            $smslogs = $smslogs->where('status',WhatsappLog::PENDING);
        }elseif($scope == 'success'){
            $smslogs = $smslogs->where('status',WhatsappLog::SUCCESS);
        }elseif($scope == 'schedule'){
            $smslogs = $smslogs->where('status',WhatsappLog::SCHEDULE);
        }elseif($scope == 'failed'){
            $smslogs = $smslogs->where('status',WhatsappLog::FAILED);
        }
        $smslogs = $smslogs->orderBy('id','desc')->with('user', 'whatsappGateway')->paginate(paginateNumber());

        return view('admin.whatsapp_messaging.index', compact('title', 'smslogs', 'search', 'searchDate'));
    }

    public function smsStatusUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:whatsapp_logs,id',
            'status' => 'required|in:1,3,4',
        ]);
        $smslog = WhatsappLog::findOrFail($request->id);
        $smslog->status = $request->status;
        $smslog->update();
        $notify[] = ['success', 'WhatsApp status has been updated'];
        return back()->withNotify($notify);
    }

    public function create()
    {
        $title = "Compose WhatsApp Message";
        $templates = Template::whereNull('user_id')->get();
        $groups = Group::whereNull('user_id')->get();
        return view('admin.whatsapp_messaging.create', compact('title', 'groups', 'templates'));
    }

    public function store(Request $request)
    {
        $message = 'message';
        $rules = 'required';
        if($request->hasFile('document')){
            $message = 'document';
            $rules = ['required', new MessageFileValidationRule('document')];
        } else if($request->hasFile('audio')){
            $message = 'audio';
            $rules = ['required', new MessageFileValidationRule('audio')];
        } else if($request->hasFile('image')){
            $message = 'image';
            $rules = ['required', new MessageFileValidationRule('image')];
        } else if($request->hasFile('video')){
            $message = 'video';
            $rules = ['required', new MessageFileValidationRule('video')];
        }
        $request->validate([
            $message => $rules,
            'schedule' => 'required|in:1,2',
            'shedule_date' => 'required_if:schedule,2',
            'group_id' => 'nullable|array|min:1',
            'group_id.*' => 'nullable|exists:groups,id',
        ]);

        if(!$request->number && !$request->group_id && !$request->file){
            $notify[] = ['error', 'Invalid number collect format'];
            return back()->withNotify($notify);
        }

        $allContactNumber = [];
        $numberGroupName  = [];

        if($request->number){
            $contactNumber = preg_replace('/[ ,]+/', ',', trim($request->number));
            $recipientNumber  = explode(",",$contactNumber);
            array_push($allContactNumber, $recipientNumber);
        }
        if($request->group_id){
            $groupNumber = Contact::whereNull('user_id')->whereIn('group_id', $request->group_id)->pluck('contact_no')->toArray();
            $numberGroupName = Contact::whereNull('user_id')->whereIn('group_id', $request->group_id)->pluck('name','contact_no')->toArray();
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
                array_push($allContactNumber, $txtNumber);
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

        $contactNewArray = [];
        foreach($allContactNumber as $childArray){
            foreach($childArray as $value){
                $contactNewArray[] = $value;
            }
        }
        $contactNewArray = array_unique($contactNewArray);
        $messages = str_split($request->message,320);
        $totalMessage = count($messages);
        $totalNumber = count($contactNewArray);
        $totalCredit = $totalNumber * $totalMessage;
        
        $whatsappGateway = WhatsappDevice::where('status', 'connected')->pluck('delay_time','id')->toArray();
        
        if(count($whatsappGateway) < 1){
            $notify[] = ['error', 'Not available WhatsApp Gateway'];
            return back()->withNotify($notify);
        }
        $postData = [];
        if($request->hasFile('document')){
            $file = $request->file('document');
            $fileName = uniqid().time().'.'.$file->getClientOriginalExtension();
            $path = filePath()['whatsapp']['path_document'];
            if(!file_exists($path)){
                mkdir($path, 0755, true);
            }
            try {
                move_uploaded_file($file->getRealPath(), $path.'/'.$fileName);
            } catch (\Exception $e) {

            }
            $postData['type'] = 'pdf';
            $postData['url_file'] = $path.'/'.$fileName;
            $postData['name'] = $fileName;
        }
        if($request->hasFile('audio')){
            $file = $request->file('audio');
            $fileName = uniqid().time().'.'.$file->getClientOriginalExtension();
            $path = filePath()['whatsapp']['path_audio'];
            if(!file_exists($path)){
                mkdir($path, 0755, true);
            }
            try {
                move_uploaded_file($file->getRealPath(), $path.'/'.$fileName);
            } catch (\Exception $e) {

            }
            $postData['type'] = 'Audio';
            $postData['url_file'] = $path.'/'.$fileName;
            $postData['name'] = $fileName;
        }
        if($request->hasFile('image')){
            $file = $request->file('image');
            $fileName = uniqid().time().'.'.$file->getClientOriginalExtension();
            $path = filePath()['whatsapp']['path_image'];
            if(!file_exists($path)){
                mkdir($path, 0755, true);
            }
            try {
                move_uploaded_file($file->getRealPath(), $path.'/'.$fileName);
            } catch (\Exception $e) {

            }
            $postData['type'] = 'Image';
            $postData['url_file'] = $path.'/'.$fileName;
            $postData['name'] = $fileName;
        }
        if($request->hasFile('video')){
            $file = $request->file('video');
            $fileName = uniqid().time().'.'.$file->getClientOriginalExtension();
            $path = filePath()['whatsapp']['path_video'];
            if(!file_exists($path)){
                mkdir($path, 0755, true);
            }
            try {
                move_uploaded_file($file->getRealPath(), $path.'/'.$fileName);
            } catch (\Exception $e) {

            }
            $postData['type'] = 'Video';
            $postData['url_file'] = $path.'/'.$fileName;
            $postData['name'] = $fileName;
        }
        $delayTimeCount = [];
        $setTimeInDelay = 0;
        if($request->schedule == 2){
            $setTimeInDelay = $request->shedule_date;
        }else{
            $setTimeInDelay = Carbon::now();
        }

        $setWhatsAppGateway =  $whatsappGateway;
        $i = 1; $addSecond = 10;$gateWayid = null;
        foreach (array_filter($contactNewArray) as $key => $value) {
            foreach ($setWhatsAppGateway as $key => $appGateway){
                $addSecond = $appGateway * $i;
                $gateWayid = $key;
                unset($setWhatsAppGateway[$key]);
                if(empty($setWhatsAppGateway)){
                    $setWhatsAppGateway =  $whatsappGateway;
                    $i++;
                }
                break;
            }

            $log = new WhatsappLog();
            if(count($whatsappGateway) > 0){
                $log->whatsapp_id =  $gateWayid;
            }
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

            if($request->hasFile('document')){
                $log->document = $fileName;
            }
            if($request->hasFile('audio')){
                $log->audio = $fileName;
            }
            if($request->hasFile('image')){
                $log->image = $fileName;
            }
            if($request->hasFile('video')){
                $log->video = $fileName;
            }
            $log->schedule_status = $request->schedule;
            $log->save();

            if(count($contactNewArray) == 1 && $request->schedule==1){
                dispatch_now(new ProcessWhatsapp($finalContent, $value, $log->id, $postData));
            }else{
                dispatch(new ProcessWhatsapp($finalContent, $value, $log->id, $postData))->delay(Carbon::parse($setTimeInDelay)->addSeconds($addSecond));
            }
        }

        $notify[] = ['success', 'New WhatsApp Message request sent, please see in the WhatsApp Log history for final status'];
        return back()->withNotify($notify);
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        try {
            $smsLog = WhatsappLog::findOrFail($request->id);
            if ($smsLog->status==1) {
                $user = User::find($smsLog->user_id);
                if($user){
                    $messages = str_split($smsLog->message,160);
                    $totalcredit = count($messages);

                    $user->credit += $totalcredit;
                    $user->save();

                    $creditInfo = new WhatsappCreditLog();
                    $creditInfo->user_id = $smsLog->user_id;
                    $creditInfo->type = "+";
                    $creditInfo->credit = $totalcredit;
                    $creditInfo->trx_number = trxNumber();
                    $creditInfo->post_credit =  $user->whatsapp_credit;
                    $creditInfo->details = $totalcredit." Credit Return ".$smsLog->to." is Falied";
                    $creditInfo->save();
                }
            }
            $smsLog->delete();
            $notify[] = ['success', "Successfully SMS log deleted"];
        } catch (\Exception $e) {
            $notify[] = ['error', "Error occour in SMS delete time. Error is "+$e->getMessage()];
        }
        return back()->withNotify($notify);
    }
}
