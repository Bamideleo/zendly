<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MailConfiguration;
use App\Models\GeneralSetting;
use App\Http\Utility\SendMail;
use Carbon\Carbon;
use App\Models\EmailTemplates;

class MailConfigurationController extends Controller
{
    public function index()
    {
        $title = "Mail Configuration";
        $mails = MailConfiguration::latest()->get();
        return view('admin.mail.index', compact('title', 'mails'));
    }

    public function edit($id)
    {
        $title = "Mail updated";
        $mail = MailConfiguration::findOrFail($id);
        return view('admin.mail.edit', compact('title', 'mail'));
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
        $mail = MailConfiguration::findOrFail($id);
        if($mail->name === "SMTP"){
            $general = GeneralSetting::first();
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

    public function sendMailMethod(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:mails,id'
        ]);
        $mail = MailConfiguration::findOrFail($request->id);
        $general = GeneralSetting::first();
        $general->email_gateway_id = $mail->id;
        $general->save();
        $notify[] = ['success', 'Email method has been updated'];
        return back()->withNotify($notify);
    }


    public function globalTemplate()
    {
        $title = "Global template";
        return view('admin.mail.global_template', compact('title'));
    }

    public function globalTemplateUpdate(Request $request)
    {
        $this->validate($request,[
            'mail_from' => 'required|email',
            'body' => 'required',
        ]);
        $general = GeneralSetting::first();
        $general->mail_from = $request->mail_from;
        $general->email_template = $request->body;
        $general->save();
        $notify[] = ['success', 'Global email template has been updated'];
        return back()->withNotify($notify);

    }

    public function mailTester(Request $request,$id)
    {
        $general = GeneralSetting::first();
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
}
