<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmailLog;
use App\Models\EmailCreditLog;
use App\Models\EmailContact;
use App\Models\MailConfiguration;
use App\Models\GeneralSetting;
use Shuchkin\SimpleXLSX;
use Carbon\Carbon;
use App\Jobs\ProcessEmail;

class ManageEmailController extends Controller
{

// email provider settings start

public function emailprovider()
{
    $title = "Mail Configuration";
    $user = Auth::user()->id;
    $emailp = MailConfiguration::where('user_id',$user)->latest()->get();
    $mails = MailConfiguration::where('is_admin',1)->latest()->get();
    $setting = GeneralSetting::where('user_id',$user)->first();
    return view('user.email.provider', compact('title', 'mails','emailp','setting'));
}

public function sendMailMethod(Request $request){
    $this->validate($request, [
        'id' => 'required|exists:mails,id'
    ]);
    $user = Auth::user();
    $chksettings = GeneralSetting::where('user_id',$user->id)->first();
    if(!$chksettings){
    $mail = MailConfiguration::findOrFail($request->id);
    $data = [
        'name' =>$mail->name,
        'driver_information' =>$mail->driver_information,
        'status' =>2,
        'user_id' =>$user->id,
    ];
    $savemail = MailConfiguration::create($data);
    $setting = GeneralSetting::first();
    $generaldata = [
        'site_name' =>$setting->site_name,
        'phone' =>$setting->phone,
        'country_code'=>$setting->country_code,
        'sms_gateway' =>$setting->sms_gateway,
        'currency_name' =>$setting->currency_name,
        'currency_symbol' =>$setting->currency_symbol,
        'sms_gateway_id'=> $setting->sms_gateway_id,
        'email_gateway_id' =>$savemail->id,
        'mail_from' =>$setting->mail_from,
        'email_template' =>$setting->email_template,
        's_login_google_info' =>$setting->s_login_google_info,
        'frontend_section' => $setting->frontend_section,
        'registration_status' =>$setting->registration_status,
        'cron_job_run' =>$setting->cron_job_run,
        'plan_id' =>$setting->plan_id,
        'sign_up_bonus' =>$setting->sign_up_bonus,
        'debug_mode' =>$setting->debug_mode,
        'maintenance_mode' =>$setting->maintenance_mode,
        'maintenance_mode_message' =>$setting->maintenance_mode_message,
        'schedule_at' =>$setting->schedule_at,
        'user_id' =>$user->id,
    ];
    $save_setting = GeneralSetting::create($generaldata);
    
    $notify[] = ['success', 'Mail Method has been Added'];
    return back()->withNotify($notify);
    }else{
        $mail = MailConfiguration::findOrFail($request->id);
    $data = [
        'name' =>$mail->name,
        'driver_information' =>$mail->driver_information,
        'status' =>2,
        'user_id' =>$user->id,
    ];
    $savemail = MailConfiguration::create($data);
    $notify[] = ['success', 'Mail Method has been Added'];
    return back()->withNotify($notify);
    }
}

public function activateapi(Request $request)
{
    $user = Auth::user();
    if($request->status == 2){
    $mailGateway = MailConfiguration::findOrFail($request->id);
    $mailGateway->status = $request->status;
    $mailGateway->save();
    $setting = GeneralSetting::where('user_id',$user->id)->first();
    $setting->email_gateway_id = 0;
    $setting->save();
    $notify[] = ['success', 'Mail Gateway has been Disable'];
    return back()->withNotify($notify);
    }
    else{
        $smsGateway = MailConfiguration::findOrFail($request->id);
        $smsGateway->status = $request->status;
        $smsGateway->save();
        $setting = GeneralSetting::where('user_id',$user->id)->first();
        $setting->email_gateway_id = $request->id;
        $setting->save();
        $notify[] = ['success', 'Mail Gateway has been Enable'];
        return back()->withNotify($notify);
    }
}

public function edit($id)
{
    $title = "Mail updated";
    $mail = MailConfiguration::findOrFail($id);
    return view('user.email.edit', compact('title', 'mail'));
}

public function mailUpdate(Request $request, $id)
{
    $this->validate($request, [
        'driver'   => "required_if:name,==,smtp",
        'host'     => "required_if:name,==,smtp",
        'smtp_port'     => "required_if:name,==,smtp", 
        'encryption'=> "required_if:name,==,smtp",
        'username' => "required_if:name,==,smtp",
        'password' => "required_if:name,==,smtp",
        'from_address' => "required_if:name,==,smtp",
        'from_name' => "required_if:name,==,smtp",
    ]);
    $user = Auth::user();
    $mail = MailConfiguration::findOrFail($id);
    if($mail->name === "SMTP"){
        $setting = GeneralSetting::where('user_id',$user->id)->first();
        $general->mail_from = $request->username;
        $general->save();
        $mail->driver_information = [
            'driver'     => $request->driver,
            'host'       => $request->host,
            'smtp_port'       => $request->smtp_port,
            'from'       => array('address' => $request->from_address, 'name' => $request->from_name),
            'encryption' => $request->encryption,
            'username'   => $request->username,
            'password'   => $request->password,
        ];
    }elseif($mail->name == "SendGrid Api"){
        $mail->driver_information = [
            'app_key'     => $request->app_key,
            'from'       => array('address' => $request->from_address, 'name' => $request->from_name),
        ];
    }
    $mail->save();
    $notify[] = ['success',  ucfirst($mail->name).' mail method has been updated'];
    return back()->withNotify($notify);
}

public function mailTester(Request $request,$id)
    {
        $user = Auth::user();
        $general = GeneralSetting::where('user_id',$user->id)->first();
        $mailConfiguration = MailConfiguration::where('id', $id)->first();
        if(!$mailConfiguration){
            return;
        }

        $response = "";
        $mailCode = [
            'name' => $general->site_name, 
            'time' => Carbon::now(),
        ];
        $emailTemplate = EmailTemplates::where('slug', 'TEST_MAIL')->first();
        
        $messages = str_replace("{{name}}", @$general->site_name, $emailTemplate->body);
        $messages = str_replace("{{time}}", @Carbon::now(), $messages);
          
        if($mailConfiguration->name === "PHP MAIL"){
            $response = SendMail::SendPHPmail($general->mail_from, $general->site_name, $request->email, $emailTemplate->subject, $messages);
        }
        elseif($mailConfiguration->name === "SMTP"){
            $response = SendMail::SendSMTPMail($mailConfiguration->driver_information->from->address, $request->email, $general->site_name, $emailTemplate->subject, $messages);
        }
        elseif($mailConfiguration->name === "SendGrid Api"){
            $response = SendMail::SendGrid($mailConfiguration->driver_information->from->address, $general->site_name, $request->email, $emailTemplate->subject, $messages, @$mailConfiguration->driver_information->app_key);
        } 
        if ($response==null) {
            $notify[] = ['success', "Successfully sent mail, please check your inbox or spam"];
        }else{
            $notify[] = ['error', "Mail Configuration Error, Please check your mail configuration properly"];
        }
 
        return back()->withNotify($notify);
    }
// email provider settings end
    public function create()
    {
    	$title = "Compose Email";
    	$user = Auth::user();
    	$emailContacts = $user->emailContact()->get(['email']);
    	$emailGroups = $user->emailGroup()->get();
    	return view('user.email.create', compact('title', 'emailGroups', 'emailContacts'));
    }

    public function index()
    {
    	$title = "All Email History";
        $user = Auth::user();
        $emailLogs = EmailLog::where('user_id', $user->id)->orderBy('id', 'DESC')->with('sender')->paginate(paginateNumber());
    	return view('user.email.index', compact('title', 'emailLogs'));
    }


    public function pending()
    {
        $title = "Pending Email History";
        $user = Auth::user();
        $emailLogs = EmailLog::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 1)->with('sender')->paginate(paginateNumber());
        return view('user.email.index', compact('title', 'emailLogs'));
    }


    public function delivered()
    {
        $title = "Delivered Email History";
        $user = Auth::user();
        $emailLogs = EmailLog::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 4)->with('sender')->paginate(paginateNumber());
        return view('user.email.index', compact('title', 'emailLogs'));
    }


    public function failed()
    {
        $title = "Failed  Email History";
        $user = Auth::user();
        $emailLogs = EmailLog::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 3)->with('sender')->paginate(paginateNumber());
        return view('user.email.index', compact('title', 'emailLogs'));
    }

    public function scheduled()
    {
    	$title = "Scheduled Email History";
    	$user = Auth::user();
        $emailLogs = EmailLog::where('user_id', $user->id)->orderBy('id', 'DESC')->where('status', 2)->with('sender')->paginate(paginateNumber());
        return view('user.email.index', compact('title', 'emailLogs'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'subject' => 'required',
            'message' => 'required',
            'schedule' => 'required|in:1,2',
            'shedule_date' => 'required_if:schedule,2',
            'email_group_id' => 'nullable|array|min:1',
            'email_group_id.*' => 'nullable|exists:email_groups,id,user_id,'.$user->id,
            'email.*' => 'nullable|email',
        ]);
        if(!$request->email && !$request->email_group_id && !$request->file){
            $notify[] = ['error', 'Email address not found'];
            return back()->withNotify($notify);
        }
        $emailGroupName = [];
        $allEmail = [];
        if($request->email[0]){
            array_push($allEmail, $request->email);
        }
        if($request->email_group_id){
            $emailGroup = EmailContact::where('user_id', $user->id)->whereIn('email_group_id', $request->email_group_id)->pluck('email')->toArray();
            $emailGroupName = EmailContact::where('user_id', $user->id)->whereIn('email_group_id', $request->email_group_id)->pluck('name','email')->toArray();
            array_push($allEmail, $emailGroup);
        }
        if($request->file){
            $extension = strtolower($request->file->getClientOriginalExtension());
            if(!in_array($extension, ['csv','xlsx'])){
                $notify[] = ['error', 'Invalid file extension'];
                return back()->withNotify($notify);
            }
            if($extension == "csv"){
                $contactNameCsv = array();
                $nameEmailArray[] = [];
                $csvArrayLength = 0;
                $contactEmailCsv = array();

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
            }
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

        if(!$user->email){
            $notify[] = ['error', 'Please add your email'];
            return back()->withNotify($notify);
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
        $contactNewArray = array_unique($contactNewArray);
        if(count($contactNewArray) > $user->email_credit){
            $notify[] = ['error', 'You do not have a sufficient email credit for send mail'];
            return back()->withNotify($notify);
        }
        $user->email_credit -=  count($contactNewArray);
        $user->save();
        $emailCredit = new EmailCreditLog();
        $emailCredit->user_id = $user->id;
        $emailCredit->type = "-";
        $emailCredit->credit = count($contactNewArray);
        $emailCredit->trx_number = trxNumber();
        $emailCredit->post_credit =  $user->email_credit;
        $emailCredit->details = count($contactNewArray)." credits were cut for send email";
        $emailCredit->save();
        $general = GeneralSetting::where('user_id',$user->id)->first();
        $emailMethod = MailConfiguration::where('id',$general->email_gateway_id)->first();
        if(!$emailMethod){
            $notify[] = ['error', 'Invalid Mail Gateway'];
            return back()->withNotify($notify);
        }

        $content = buildDomDocument(offensiveMsgBlock($request->message));
        $setTimeInDelay = 0;
        if($request->schedule == 2){
            $setTimeInDelay = $request->shedule_date;
        }else{
            $setTimeInDelay = Carbon::now();
        }
        foreach($contactNewArray as $key => $value) {
            $emailLog = new EmailLog();
            $emailLog->user_id = $user->id;
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
            $emailLog->status = $request->schedule == 2 ? 2 : 1;
            $emailLog->schedule_status = $request->schedule;
            $emailLog->save();
            if($emailLog->status == 1){
                if(count($contactNewArray) == 1 && $request->schedule==1){
                    ProcessEmail::dispatchNow($emailLog->id);
                }
                else{
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
        $user = Auth::user();
        $emailLogs = EmailLog::where('id',$id)->where('user_id',$user->id)->orderBy('id', 'DESC')->limit(1)->first();
        return view('partials.email_view', compact('title', 'emailLogs'));
    }

    public function search(Request $request, $scope)
    {
        $title = "Email History";
        $search = $request->search;
        $searchDate = $request->date;

        $user = Auth::user();

        if ($search!="") {
            $emailLogs = EmailLog::where('user_id', $user->id)->where('to','like',"%$search%");
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
                $emailLogs = EmailLog::where('user_id', $user->id)->whereDate('created_at',Carbon::parse($firstDate));
            }
            if ($lastDate){
                $emailLogs = EmailLog::where('user_id', $user->id)->whereDate('created_at','>=',Carbon::parse($firstDate))->whereDate('created_at','<=',Carbon::parse($lastDate));
            }
        }
        if ($search=="" && $searchDate==""){
                $notify[] = ['error','Please give any search filter data'];
                return back()->withNotify($notify);
        }
        if($scope == 'pending') {
            $emailLogs = $emailLogs->where('status',EmailLog::PENDING);
        }elseif($scope == 'delivered'){
            $emailLogs = $emailLogs->where('status',EmailLog::SUCCESS);
        }elseif($scope == 'schedule'){
            $emailLogs = $emailLogs->where('status',EmailLog::SCHEDULE);
        }elseif($scope == 'failed'){
            $emailLogs = $emailLogs->where('status',EmailLog::FAILED);
        }

        $emailLogs = $emailLogs->orderBy('id','desc')->with('sender')->paginate(paginateNumber());
        return view('user.email.index', compact('title', 'emailLogs', 'search','searchDate'));
    }
}
