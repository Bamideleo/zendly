<?php

namespace App\Http\Controllers\PaymentMethod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentLog;
use App\Models\PaymentMethod;
use App\Models\GeneralSetting;
use App\Models\Subscription;
use App\Models\User;
use App\Models\CreditLog;
use App\Models\EmailCreditLog;
use App\Models\Transaction;
use App\Http\Utility\SendMail;
use App\Models\WhatsappCreditLog;
use Razorpay\Api\Api;


class PaymentController extends Controller
{
    
    public function preview()
    {
        $title = "Payment Info";
        $userId = auth()->user()->id;
        $paymentTrackNumber = session()->get('payment_track');
        $paymentLog = PaymentLog::where('trx_number', $paymentTrackNumber)->first();
        $subscription = Subscription::where('id', session('subscription_id'))->where('user_id', $userId)->whereIn('status',[0,1,2])->first();
        return view('user.payment', compact('title', 'paymentLog','subscription'));
    }

    public function paymentConfirm()
    {
        $paymentTrackNumber = session()->get('payment_track');
        $paymentLog = PaymentLog::where('trx_number', $paymentTrackNumber)->first();
        $paymentMethod = PaymentMethod::where('unique_code', $paymentLog->paymentGateway->unique_code)->first();
        if(!$paymentMethod){ 
            $notify[] = ['error', 'Invalid Payment gateway'];
            return back()->withNotify($notify);
        }
        if($paymentLog->paymentGateway->unique_code == "STRIPE101"){
            $title = "Payment with Stripe";
            return view('user.payment.strip', compact('title', 'paymentMethod'));
        }else if($paymentLog->paymentGateway->unique_code == "PAYPAL102"){
            $title = "Payment with PayPal";
            return view('user.payment.paypal', compact('title', 'paymentMethod', 'paymentLog'));
        }else if($paymentLog->paymentGateway->unique_code == "PAYSTACK103"){
            $title = "Payment with Paystack";
            return view('user.payment.paystack', compact('title', 'paymentMethod', 'paymentLog'));
        }else if($paymentLog->paymentGateway->unique_code == "SSLCOMMERZ104"){
            $title = "Payment with SSLcommerz";
            return view('user.payment.sslcommerz', compact('title', 'paymentMethod', 'paymentLog'));
        }else if($paymentLog->paymentGateway->unique_code == "PAYTM105"){
            $title = "Payment with Paytm";
            return view('user.payment.paytm', compact('title', 'paymentMethod', 'paymentLog'));
        }else if($paymentLog->paymentGateway->unique_code == "INSTA106"){
            $title = "Payment with Instamojo";
            return view('user.payment.instamojo', compact('title', 'paymentMethod', 'paymentLog'));
        }else if($paymentLog->paymentGateway->unique_code == "FLUTTER107"){
            $title = "Payment with Flutterwave";
            return view('user.payment.flutterwave', compact('title', 'paymentMethod', 'paymentLog'));
        }else if($paymentLog->paymentGateway->unique_code == "COINBASE108"){
            $title = "Payment with Coinbase Commerce";
            return view('user.payment.coinbase', compact('title', 'paymentMethod', 'paymentLog'));
        }else if($paymentLog->paymentGateway->unique_code == "RAZOR107"){
            $title = "Payment with Razor Pay";
            $api = new Api($paymentMethod->payment_parameter->key_id, $paymentMethod->payment_parameter->key_secret);
            $order = $api->order->create(
                array(
                    'receipt' => $paymentTrackNumber,
                    'amount' => round(($paymentLog->final_amount)*100),
                    'currency' => $paymentMethod->currency->name,
                    'payment_capture' => '1'
                )
            );
            return view('user.payment.razorpay', compact('title', 'paymentMethod', 'paymentLog','order'));
        }else{
            return redirect()->route('user.dashboard');
        }
    }

    public static function paymentUpdate($trx)
    {
        $general = GeneralSetting::first();
        $paymentData = PaymentLog::where('trx_number', $trx)->first();
   
        if($paymentData && $paymentData->status == 0){
            $paymentData->status = 2;
            $paymentData->save();

            $subscription = Subscription::where('id', $paymentData->subscriptions_id)->first();
            $subscription->status = 1;
            $subscription->save();

            $user = User::find($paymentData->user_id);
            $user->credit += $subscription->plan->credit;
            $user->email_credit += $subscription->plan->email_credit;
            $user->whatsapp_credit += $subscription->plan->whatsapp_credit;
            $user->save();

            $creditInfo = new CreditLog();
            $creditInfo->user_id = $user->id;
            $creditInfo->credit_type = "+";
            $creditInfo->credit = $subscription->plan->credit;
            $creditInfo->trx_number = trxNumber();
            $creditInfo->post_credit =  $user->credit;
            $creditInfo->details = $subscription->plan->name. " Plan Purchased";
            $creditInfo->save();

            $emailCredit = new EmailCreditLog();
            $emailCredit->user_id = $user->id;
            $emailCredit->type = "+";
            $emailCredit->credit = $subscription->plan->email_credit;
            $emailCredit->trx_number = trxNumber();
            $emailCredit->post_credit =  $user->email_credit;
            $emailCredit->details = $subscription->plan->name. " Plan Purchased";
            $emailCredit->save();

            $whatsappCredit = new WhatsappCreditLog();
            $whatsappCredit->user_id = $user->id;
            $whatsappCredit->type = "+";
            $whatsappCredit->credit = $subscription->plan->whatsapp_credit;
            $whatsappCredit->trx_number = trxNumber();
            $whatsappCredit->post_credit =  $user->whatsapp_credit;
            $whatsappCredit->details = $subscription->plan->name. " Plan Purchased";
            $whatsappCredit->save();

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'payment_method_id' => $paymentData->method_id,
                'amount' => $paymentData->amount,
                'transaction_type' => Transaction::PLUS,
                'transaction_number' => $paymentData->trx_number,
                'details' => 'Paid through ' . $paymentData->paymentGateway->name,
            ]);
            $mailCode = [
                'trx' => $paymentData->trx_number, 
                'amount' => shortAmount($paymentData->final_amount),
                'charge' => shortAmount($paymentData->charge),
                'currency' => $general->currency_name,
                'rate' => shortAmount($paymentData->rate),
                'method_name' => $paymentData->paymentGateway->name,
                'method_currency' => $paymentData->paymentGateway->currency->name,
            ];
            SendMail::MailNotification($user,'PAYMENT_CONFIRMED',$mailCode);
        }
    }


    public function manualPayment()
    {
        $paymentTrackNumber = session()->get('payment_track');
        $paymentLog = PaymentLog::where('trx_number', $paymentTrackNumber)->first();
        if(!$paymentLog){
            return redirect()->route('user.dashboard');
        } 
        $title = 'Payment Confirm';
        $paymentMethod =  $paymentLog->paymentGateway;
        return view('user.payment.manual_confirm', compact('paymentLog', 'title', 'paymentMethod'));
    }

    public function manualPaymentUpdate(Request $request)
    {
        $paymentTrackNumber = session()->get('payment_track');
        $paymentLog = PaymentLog::where('trx_number', $paymentTrackNumber)->first();
        if(!$paymentLog){
            return redirect()->route('user.dashboard');
        }
        $rules = array();
        if($paymentLog->paymentGateway->payment_parameter != null){
            foreach($paymentLog->paymentGateway->payment_parameter as $key => $value){
                if($key!="0") { 
                    $rules[$key] = ['required'];
                    if($value->field_type == 'file'){
                        array_push($rules[$key], 'image');
                        array_push($rules[$key], 'mimes:jpeg,jpg,png');
                        array_push($rules[$key], 'max:2048');
                    }
                    elseif($value->field_type == 'text'){
                        array_push($rules[$key], 'max:191');
                    }
                    elseif($value->field_type == 'textarea'){
                        array_push($rules[$key], 'max:10000');
                    }
                }
            }
        }
        $this->validate($request, $rules);
        $path       = filePath()['payment_file']['path'];
        $collection = collect($request);
        $userData = [];
        if ($paymentLog->paymentGateway->payment_parameter != "" || !empty($paymentLog->paymentGateway->payment_parameter)) {
            foreach ($collection as $k => $v) {
                foreach ($paymentLog->paymentGateway->payment_parameter as $inKey => $inVal){
                    if ($k <= 0) {
                        continue;
                    } else {
                        if ($inVal->field_type == 'file') {
                            if ($request->hasFile($inKey)) {
                                try {
                                    $userData[$inKey] = [
                                        'field_name' => uploadImage($request[$inKey], $path),
                                        'field_type' => $inVal->field_type,
                                    ];
                                }catch(\Exception $exp) {
                                    $notify[] = ['error', 'Could not upload your ' . $request[$inKey]];
                                    return back()->withNotify($notify)->withInput();
                                }
                            }
                        } else {
                            $userData[$inKey] = $v;
                            $userData[$inKey] = [
                                'field_name' => $v,
                                'field_type' => $inVal->field_type,
                            ];
                        }
                    }
                }
            }
        }
        $paymentLog->user_data = $userData;
        $paymentLog->status = 1;
        $paymentLog->save();
        $notify[] = ['success', 'You have order request has been taken.'];
        return redirect()->route('user.dashboard')->withNotify($notify);
    }
}
