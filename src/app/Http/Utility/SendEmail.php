<?php
namespace App\Http\Utility;
use Illuminate\Support\Facades\Mail;
use App\Models\GeneralSetting;
use App\Models\EmailLog;
use App\Models\User;

class SendEmail
{
    public static function SendPHPmail($emailFrom, $sitename, $emailTo, $subject, $messages, $emailLog)
    { 
        $headers = "From: $sitename <$emailFrom> \r\n";
        $headers .= "Reply-To: $sitename <$emailFrom> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        try {
            @mail($emailTo, $subject, $message, $headers);
            $emailLog->status =  EmailLog::SUCCESS;
        } catch (\Exception $e) {
            $emailLog->status =  EmailLog::FAILED;
            $emailLog->response_gateway  = $e->getMessage();
        }
        $emailLog->save();
    }

    public static function SendSmtpMail($emailFrom, $fromName, $emailTo, $replyTo, $subject, $messages, $emailLog)
    {
        try{
            Mail::send([], [], function ($message) use ($messages, $emailFrom, $fromName, $emailTo, $replyTo, $subject) 
            {
                $message->to($emailTo)
                    ->replyTo($replyTo)
                    ->subject($subject)
                    ->from($emailFrom,$fromName)
                    ->setBody($messages, 'text/html','utf-8');
            }); 
            $emailLog->status = EmailLog::SUCCESS;
            $emailLog->save();
        }catch (\Exception $e){ 
            $emailLog->status = EmailLog::FAILED;
            $emailLog->response_gateway  = $e->getMessage();
            $emailLog->save();

            $user = User::find($emailLog->user_id);
            if ($user!='') {
                $user->email_credit += 1;
                $user->save();
            }
        }
    }

    public static function SendGrid($emailFrom, $fromName, $emailTo, $subject, $messages, $emailLog, $credentials)
    {
        $general = GeneralSetting::first();
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom($emailFrom, $fromName);
        $email->addTo($emailTo);
        $email->setSubject($subject);
        $email->addContent("text/html", $messages);
        $sendgrid = new \SendGrid(@$credentials);

        try {
            $response = $sendgrid->send($email);
            if ($response->statusCode()!=200) {
                $emailLog->status =  EmailLog::FAILED;
                $emailLog->response_gateway  = $e->getMessage();
                $emailLog->save();
                $user = User::find($emailLog->user_id);
                if ($user!='') {
                    $user->email_credit += 1;
                    $user->save();
                }
            }else{
                $emailLog->status =  EmailLog::SUCCESS;
                $emailLog->save();
            }
        }catch (\Exception $e) {
            $emailLog->status =  EmailLog::FAILED;
            $emailLog->response_gateway  = $e->getMessage();
            $emailLog->save();
            $user = User::find($emailLog->user_id);
            if ($user!='') {
                $user->email_credit += 1;
                $user->save();
            }
        }
    }
}