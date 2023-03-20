<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailLog;
use App\Models\EmailCreditLog;
use App\Models\MailConfiguration;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\EmailGroup;
use App\Models\EmailContact;
use Carbon\Carbon;
use App\Http\Utility\SendEmail;
use App\Jobs\ProcessEmail;
use Shuchkin\SimpleXLSX;
use Intervention\Image\Facades\Image;

class ManageEmailController extends Controller
{
    public function index()
    {
        $title = "All Email History";
        $emailLogs = EmailLog::orderBy('id', 'DESC')->with('sender','user')->paginate(paginateNumber());
        return view('admin.email.index', compact('title', 'emailLogs'));
    }

    public function pending()
    {
        $title = "Pending Email History";
        $emailLogs = EmailLog::where('status',EmailLog::PENDING)->orderBy('id', 'DESC')->with('sender','user')->paginate(paginateNumber());
        return view('admin.email.index', compact('title', 'emailLogs'));
    }

    public function success()
    {
        $title = "Delivered Email History";
        $emailLogs = EmailLog::where('status',EmailLog::SUCCESS)->orderBy('id', 'DESC')->with('sender','user')->paginate(paginateNumber());
        return view('admin.email.index', compact('title', 'emailLogs'));
    }

    public function schedule()
    {
        $title = "Schedule Email History";
        $emailLogs = EmailLog::where('status',EmailLog::SCHEDULE)->orderBy('id', 'DESC')->with('sender','user')->paginate(paginateNumber());
        return view('admin.email.index', compact('title', 'emailLogs'));
    }

    public function failed()
    {
        $title = "Failed Email History";
        $emailLogs = EmailLog::where('status',EmailLog::FAILED)->orderBy('id', 'DESC')->with('sender','user')->paginate(paginateNumber());
        return view('admin.email.index', compact('title', 'emailLogs'));
    }

    public function search(Request $request, $scope)
    {
        $title = "Email History Search";
        $search = $request->search;
        $searchDate = $request->date;

        if ($search!="") {
            $emailLogs = EmailLog::where(function ($q) use ($search) {
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
                $emailLogs = EmailLog::whereDate('created_at',Carbon::parse($firstDate));
            }
            if ($lastDate){
                $emailLogs = EmailLog::whereDate('created_at','>=',Carbon::parse($firstDate))->whereDate('created_at','<=',Carbon::parse($lastDate));
            }
        }

        if ($search=="" && $searchDate=="") {
            $notify[] = ['error','Search data field empty'];
            return back()->withNotify($notify);
        }

        if($scope == 'pending') {
            $emailLogs = $emailLogs->where('status',EmailLog::PENDING);
        }elseif($scope == 'success'){
            $emailLogs = $emailLogs->where('status',EmailLog::SUCCESS);
        }elseif($scope == 'schedule'){
            $emailLogs = $emailLogs->where('status',EmailLog::SCHEDULE);
        }elseif($scope == 'failed'){
            $emailLogs = $emailLogs->where('status',EmailLog::FAILED);
        }
        $emailLogs = $emailLogs->orderBy('id','desc')->with('sender','user')->paginate(paginateNumber());
        return view('admin.email.index', compact('title', 'emailLogs', 'search'));
    }


    public function emailStatusUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:email_logs,id',
            'status' => 'required|in:1,3',
        ]);
        $emailLog = EmailLog::findOrFail($request->id);
        $emailLog->status = $request->status;
        $emailLog->update();
        $notify[] = ['success', 'Email status has been updated'];
        return back()->withNotify($notify);
    }

    public function emailSend($id)
    {
        $emailLog = EmailLog::where('status',EmailLog::PENDING)->where('id', $id)->firstOrFail();
        if($emailLog->status == 1){
            ProcessEmail::dispatch($emailLog->id);
        }
        $notify[] = ['success', 'Mail sent'];
        return back()->withNotify($notify);
    }

    public function create()
    {
        $title = "Compose Email";
        $emailGroups = EmailGroup::whereNull('user_id')->get();
        $emailContacts = EmailContact::whereNull('user_id')->with('emailGroup')->paginate(paginateNumber());
        return view('admin.email.create', compact('title', 'emailGroups', 'emailContacts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
            'schedule' => 'required|in:1,2',
            'shedule_date' => 'required_if:schedule,2',
            'email_group_id' => 'nullable|array|min:1',
            'email_group_id.*' => 'nullable|exists:email_groups,id',
            'email.*' => 'nullable|email',
        ]);

        if(!$request->email && !$request->email_group_id && !$request->file){
            $notify[] = ['error', 'Invalid email format'];
            return back()->withNotify($notify);
        }
        $emailGroupName = [];
        $allEmail = [];
        if($request->email[0]){
            array_push($allEmail, $request->email);
        }
        if($request->email_group_id){
            $emailGroup = EmailContact::whereNull('user_id')->whereIn('email_group_id', $request->email_group_id)->pluck('email')->toArray();
            $emailGroupName = EmailContact::whereNull('user_id')->whereIn('email_group_id', $request->email_group_id)->pluck('name','email')->toArray();
            array_push($allEmail, $emailGroup);
        }

        if($request->file){
            $extension = strtolower($request->file->getClientOriginalExtension());
            if(!in_array($extension, ['csv','xlsx'])){
                $notify[] = ['error', 'Invalid file extension'];
                return back()->withNotify($notify);
            }
            if($extension == "csv"){
                $contactEmailCsv = array();
                $contactNameCsv = array();
                $nameEmailArray[] = [];
                $csvArrayLength = 0;
                if(($handle = fopen($request->file, "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                        if($csvArrayLength == 0){
                           $csvArrayLength = count($data);
                        }
                        foreach($data as $dataVal){
                            if(filter_var($dataVal, FILTER_VALIDATE_EMAIL)){
                                array_push($contactEmailCsv, $dataVal);
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
                    $contactNameCsv = $contactEmailCsv;
                }

                $nameEmailArray = array_combine($contactEmailCsv, $contactNameCsv);
                $emailGroupName = array_merge($emailGroupName, $nameEmailArray);
                $csvEmail = array_values($contactEmailCsv);
                array_push($allEmail, $csvEmail);
            };
            if($extension == "xlsx"){
                $nameEmailArray[] = [];
                $contactEmailxlsx = array();
                $exelArrayLength = 0;
                $contactNameXlsx = array();
                $xlsx = SimpleXLSX::parse($request->file);
                $data = $xlsx->rows();
                foreach($data as $key=>$val){
                    if($exelArrayLength == 0){
                        $exelArrayLength = count($val);
                    }
                    foreach($val as $dataKey=>$dataVal){
                        if(filter_var($dataVal, FILTER_VALIDATE_EMAIL)){
                            array_push($contactEmailxlsx, $dataVal);
                        }
                        else{
                            array_push($contactNameXlsx, $dataVal);
                        }
                    }
                }
                for ($i = 0; $i < $exelArrayLength; $i++){
                    unset($contactNameXlsx[$i]);
                }
                if((count($contactNameXlsx)) == 0){
                    $contactNameXlsx = $contactEmailxlsx;
                }
                $nameEmailArray = array_combine($contactEmailxlsx, $contactNameXlsx);
                $emailGroupName = array_merge($emailGroupName, $nameEmailArray);
                $excelEmail = array_values($contactEmailxlsx);
                array_push($allEmail, $excelEmail);
            }
        }


        $contactNewArray = [];
        if (empty($allEmail)) {
            $notify[] = ['error', 'Email address not found'];
            return back()->withNotify($notify);
        }
        foreach($allEmail as $childArray){
            foreach($childArray as $value){
                $contactNewArray[] = $value;
            }
        }

        $general = GeneralSetting::first();
        $emailMethod = MailConfiguration::where('id',$general->email_gateway_id)->first();
        if(!$emailMethod){
            $notify[] = ['error', 'Invalid Email Gateway'];
            return back()->withNotify($notify);
        }

        $content = buildDomDocument($request->message);
        $setTimeInDelay = 0;
        if($request->schedule == 2){
            $setTimeInDelay = $request->shedule_date;
        }else{
            $setTimeInDelay = Carbon::now();
        }
        $contactNewArray = array_unique($contactNewArray);
        foreach($contactNewArray as $key => $value) {
            $emailLog = new EmailLog();
            $emailLog->from_name = $request->from_name;
            $emailLog->reply_to_email = $request->reply_to_email;
            $emailLog->sender_id = $emailMethod->id;
            $emailLog->to = $value;
            $emailLog->initiated_time = $request->schedule == 1 ? Carbon::now() : $request->shedule_date;
            $emailLog->subject = $request->subject;
            if(array_key_exists($value,$emailGroupName)){
                $emailLog->message = str_replace('{{name}}', $emailGroupName ? $emailGroupName[$value]:$value, $content);
            }
            else{
                $emailLog->message = str_replace('{{name}}',$value, $content);
            }
            $content;
            $emailLog->status = $request->schedule == 2 ? 2 : 1;
            $emailLog->schedule_status = $request->schedule;
            $emailLog->save();
            if($emailLog->status == 1){
                if(count($contactNewArray) == 1 && $request->schedule==1){
                    ProcessEmail::dispatchNow($emailLog->id);
                }else{
                    ProcessEmail::dispatch($emailLog->id)->delay(Carbon::parse($setTimeInDelay));
                }
            }
        }
        $notify[] = ['success', 'New Email request sent, please see in the Email history for final status'];
        return back()->withNotify($notify);
    }

    public function viewEmailBody($id)
    {
        $title = "Details View";
        $emailLogs = EmailLog::where('id',$id)->orderBy('id', 'DESC')->limit(1)->first();
        return view('partials.email_view', compact('title', 'emailLogs'));
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);
        try {
            $emailLog = EmailLog::findOrFail($request->id);
            if ($emailLog->status==1) {
                $user = User::find($emailLog->user_id);
                if($user){
                    $user->email_credit += 1;
                    $user->save();
                    $emailCredit = new EmailCreditLog();
                    $emailCredit->user_id = $user->id;
                    $emailCredit->type = "+";
                    $emailCredit->credit = 1;
                    $emailCredit->trx_number = trxNumber();
                    $emailCredit->post_credit =  $user->email_credit;
                    $emailCredit->details = "Credit Added for failed " .$emailLog->to;
                    $emailCredit->save();
                }
            }
            $emailLog->delete();
            $notify[] = ['success', "Successfully email log deleted"];
        } catch (Exception $e) {
            $notify[] = ['error', "Error occour in email delete time. Error is "+$e->getMessage()];
        }
        return back()->withNotify($notify);
    }
}
