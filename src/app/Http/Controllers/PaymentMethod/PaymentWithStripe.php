<?php

namespace App\Http\Controllers\PaymentMethod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use App\Models\PaymentMethod;
use App\Models\PaymentLog;
use App\Http\Controllers\PaymentMethod\PaymentController;
use Session;

class PaymentWithStripe extends Controller
{
    public function stripePost(Request $request)
    {
    	$paymentMethod = PaymentMethod::where('unique_code','STRIPE101')->first();
        if(!$paymentMethod){
            $notify[] = ['error', 'Invalid Payment gateway'];
            return back()->withNotify($notify);
        }
        $paymentTrackNumber = session()->get('payment_track');
        $paymentLog = PaymentLog::where('trx_number', $paymentTrackNumber)->first();
        $amount = round($paymentLog->final_amount, 2) * 100;
        Stripe::setApiKey(@$paymentMethod->payment_parameter->secret_key);
        $charge = Charge::create ([
            "amount" => $amount,
            "currency" => $paymentMethod->currency->name,
            "source" => $request->stripeToken,
            "description" => "Payment success"
        ]);
        if($charge['status'] == 'succeeded') {
            PaymentController::paymentUpdate($paymentLog->trx_number);
            $notify[] = ['success', 'Payment successful!'];
            return redirect()->route('user.dashboard')->withNotify($notify);
        }
    }
}
