<?php

namespace App\Http\Controllers\PaymentMethod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\PaymentLog;
use App\Models\GeneralSetting;
use App\Http\Controllers\PaymentMethod\PaymentController;


class PaymentWithInstamojo extends Controller
{
    public static function process()
    {
        $basic = GeneralSetting::first();
        $paymentMethod = PaymentMethod::where('unique_code','INSTA106')->first();
        if(!$paymentMethod){
            $notify[] = ['error', 'Invalid Payment gateway'];
            return back()->withNotify($notify);
        }
        $paymentTrackNumber = session()->get('payment_track');
        $paymentLog = PaymentLog::where('trx_number', $paymentTrackNumber)->first();
          

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://instamojo.com/api/1.1/payment-requests/');
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                "X-Api-Key:$paymentMethod->api_key",
                "X-Auth-Token:$paymentMethod->auth_token"
            )
        );
        $payload = array(
            'purpose' => 'Payment to ' . $basic->site_name,
            'amount' => round($paymentLog->final_amount,2),
            'buyer_name' => $paymentLog->user->name,
            'redirect_url' => route('user.dashboard'),
            'webhook' => route('user.ipn.instamojo'),
            'email' => $paymentLog->user->email,
            'send_email' => true,
            'allow_repeated_payments' => false
        );

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
        $response = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($response);

        if ($res->success) { 
            $send['redirect'] = true;
            $send['redirect_url'] = $res->payment_request->longurl;
        } else {
            $send['error'] = true;
            $send['message'] = "Invalid Request";
        }
        return json_encode($send);
    }

    public function ipn(Request $request)
    {
    	$paymentTrackNumber = session()->get('payment_track');
        $data = PaymentLog::where('trx_number', $paymentTrackNumber)->orderBy('id', 'DESC')->first();
        $paymentMethod = PaymentMethod::where('unique_code','INSTA106')->first();

        $imData = $_POST;
        $macSent = $imData['mac'];
        unset($imData['mac']);
        ksort($imData, SORT_STRING | SORT_FLAG_CASE);
        $mac = hash_hmac("sha1", implode("|", $imData), $paymentMethod->payment_parameter->salt);

        if ($macSent == $mac && $imData['status'] == "Credit" && $data->status == '0') {
             PaymentController::paymentUpdate($paymentLog->trx_number);
            $notify[] = ['success', 'Payment successful!'];
            return redirect()->route('user.dashboard')->withNotify($notify);
        }
    }
}
