<?php
namespace App\Http\Utility;
use App\Models\MailConfiguration;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemoMail;
use App\Models\GeneralSetting;
use App\Models\EmailTemplates;

class SendMail
{
    public static function MailNotification($userInfo, $emailTemplate, $code = [])
    {
        $general = GeneralSetting::first();
    	$mailConfiguration = MailConfiguration::where('id', $general->email_gateway_id)->where('status', 1)->first();
    	if(!$mailConfiguration){
    		return;
    	}

        $emailTemplate = EmailTemplates::where('slug', $emailTemplate)->first();
        $messages = str_replace("{{username}}", @$userInfo->username, $general->email_template);
        $messages = str_replace("{{message}}", @$emailTemplate->body, $messages);
        foreach ($code as $key => $value) {
            $messages = str_replace('{{' . $key . '}}', $value, $messages);
        }
    	if($mailConfiguration->name === "PHP MAIL"){
    		self::SendPHPmail($general->mail_from, $general->site_name, $userInfo->email, $emailTemplate->subject, $messages);
    	}
        elseif($mailConfiguration->name === "SMTP"){
    		self::SendSMTPMail($mailConfiguration->driver_information->from->address, $userInfo->email, $general->site_name, $emailTemplate->subject, $messages);
    	}
        elseif($mailConfiguration->name === "SendGrid Api"){
            self::SendGrid($mailConfiguration->driver_information->from->address, $general->site_name, $userInfo->email, $emailTemplate->subject, $messages, @$mailConfiguration->driver_information->app_key);
        }
    }

    public static function SendPHPmail($emailFrom, $sitename, $emailTo, $subject, $messages)
    {
        $headers = "From: $sitename <$emailFrom> \r\n";
        $headers .= "Reply-To: $sitename <$emailFrom> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        try {
            @mail($emailTo, $subject, $message, $headers); 
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function SendSMTPMail($emailFrom, $emailTo, $fromName, $subject, $messages)
    {  
        try{ 
            Mail::send([], [], function ($message) use ($messages, $emailFrom, $fromName, $emailTo, $subject) {
                        $message->to($emailTo) 
                    ->subject($subject)
                    ->from($emailFrom,$fromName)
                    ->setBody($messages, 'text/html','utf-8');
            });
        }catch (\Exception $e){  
            return $e->getMessage();
        } 
    } 

    public static function SendGrid($emailFrom,$fromName, $emailTo, $subject, $messages, $credentials)
    { 
        try{
            $email = new \SendGrid\Mail\Mail();
            $email->setFrom($emailFrom, $fromName);
            $email->setSubject($subject);
            $email->addTo($emailTo);
            $email->addContent("text/html", $messages);
            $sendgrid = new \SendGrid($credentials);
            $response = $sendgrid->send($email);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
}