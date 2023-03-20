<?php
namespace App\Http\Utility;
use App\Models\PaymentMethod;
use App\Models\PaymentLog;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Subscription;
use App\Models\GeneralSetting;
use App\Models\CreditLog;
use App\Models\EmailCreditLog;
use App\Http\Utility\SendMail;

class PaymentInsert
{
    public static function paymentCreate($gatewayId)
    {
        $paymentMethod = PaymentMethod::where('unique_code', $gatewayId)->where('status', 1)->first();
        if(!$paymentMethod){
            $notify[] = ['error', 'Invalid Payment gateway'];
            return back()->withNotify($notify);
        }
        $userId = auth()->user()->id;
        $subscription = Subscription::where('id', session('subscription_id'))->where('user_id', $userId)->whereIn('status',[0,1,2])->first();
        $charge = ($subscription->amount * $paymentMethod->percent_charge / 100);
        $total_amount = $subscription->amount + $charge;
        $final_amount = $total_amount * $paymentMethod->rate;

        $paymentLog = PaymentLog::create([
            'subscriptions_id' => $subscription->id,
            'user_id' => $userId,
            'method_id' => $paymentMethod->id,
            'charge' => $charge,
            'rate' => $paymentMethod->rate,
            'amount' => $total_amount,
            'final_amount' => $final_amount,
            'trx_number' => trxNumber(),
            'status' => 0,
        ]);
        session()->put('payment_track', $paymentLog->trx_number);
    }
}



