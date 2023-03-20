<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Subscription;
use App\Models\PaymentLog;
use App\Models\CreditLog;
use App\Models\EmailCreditLog;
use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\PricingPlan;
use App\Models\GeneralSetting;
use App\Models\WhatsappCreditLog;
use App\Http\Utility\SendMail;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function transaction()
    {
        $title = "All transaction log";
        $paymentMethods = PaymentMethod::where('status', 1)->get();
        $transactions = Transaction::latest()->with('user')->paginate(paginateNumber());
        return view('admin.report.transaction', compact('title', 'transactions', 'paymentMethods'));
    }

    public function transactionSearch(Request $request)
    {
        $title = "Transaction Log Search";
        $search = $request->search;
        $paymentMethod = $request->paymentMethod;
        $searchDate = $request->date;

        if ($search!="") {
            $transactions = Transaction::where('transaction_number', 'like', "%$search%");
        }

        if ($paymentMethod!="") {
            $transactions = Transaction::where('payment_method_id', '=', "$paymentMethod");
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
                $transactions = Transaction::whereDate('created_at',Carbon::parse($firstDate));
            }
            if ($lastDate){
                $transactions = Transaction::whereDate('created_at','>=',Carbon::parse($firstDate))->whereDate('created_at','<=',Carbon::parse($lastDate));
            }
        }

        if ($search=="" && $searchDate=="" && $paymentMethod=="") {
            $notify[] = ['error','Search data field empty'];
            return back()->withNotify($notify);
        }
        $paymentMethods = PaymentMethod::where('status', 1)->get();

        $transactions = $transactions->latest()->with('user')->paginate(paginateNumber());
        return view('admin.report.transaction', compact('title', 'transactions', 'search', 'searchDate', 'paymentMethods', 'paymentMethod'));
    }


    public function userTransaction()
    {
        $title = "User all transaction log";
        $transactions = Transaction::latest()->with('user')->paginate(paginateNumber());
        return view('admin.report.transaction', compact('title', 'transactions'));
    }

    public function credit()
    {
        $title = "All sms credit log";
        $creditLogs = CreditLog::latest()->with('user')->paginate(paginateNumber());
        return view('admin.report.credit_log', compact('title', 'creditLogs'));
    }

    public function creditSearch(Request $request)
    {
        $title = "Search SMS Credit Log";
        $search = $request->search;
        $searchDate = $request->date;

        if ($search!="") {
            $creditLogs = CreditLog::where('trx_number', 'like', "%$search%");
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
                $creditLogs = CreditLog::whereDate('created_at',Carbon::parse($firstDate));
            }
            if ($lastDate){
                $creditLogs = CreditLog::whereDate('created_at','>=',Carbon::parse($firstDate))->whereDate('created_at','<=',Carbon::parse($lastDate));
            }
        }

        if ($search=="" && $searchDate=="") {
            $notify[] = ['error','Search data field empty'];
            return back()->withNotify($notify);
        }

        $creditLogs = $creditLogs->latest()->with('user')->paginate(paginateNumber());
        return view('admin.report.credit_log', compact('title', 'creditLogs', 'search'));
    }

    public function emailCredit()
    {
        $title = "All email credit log";
        $emailCreditLogs = EmailCreditLog::latest()->with('user')->paginate(paginateNumber());
        return view('admin.report.email_credit_log', compact('title', 'emailCreditLogs'));
    }

    public function emailCreditSearch(Request $request)
    {
        $title = "Search Email Credit Log";
        $search = $request->search;
        $searchDate = $request->date;

        if ($search!="") {
            $emailCreditLogs = EmailCreditLog::where('trx_number', 'like', "%$search%");
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
                $emailCreditLogs = EmailCreditLog::whereDate('created_at',Carbon::parse($firstDate));
            }
            if ($lastDate){
                $emailCreditLogs = EmailCreditLog::whereDate('created_at','>=',Carbon::parse($firstDate))->whereDate('created_at','<=',Carbon::parse($lastDate));
            }
        }

        if ($search=="" && $searchDate=="") {
            $notify[] = ['error','Search data field empty'];
            return back()->withNotify($notify);
        }
        $emailCreditLogs = $emailCreditLogs->latest()->with('user')->paginate(paginateNumber());
        return view('admin.report.email_credit_log', compact('title', 'emailCreditLogs', 'search'));
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $title = "Search by ".$searchData." transactions log";
        $transactions = Transaction::where('transaction_number', 'like', "%$search%")->latest()->with('user')->paginate(paginateNumber());
        return view('admin.report.index', compact('title', 'transactions', 'search'));
    }

    public function paymentLog()
    {
        $title = "Payment Logs";
        $paymentLogs = PaymentLog::where('status', '!=', 0)->with('user', 'paymentGateway')->paginate(paginateNumber());
        $paymentMethods = PaymentMethod::where('status', 1)->get();
        return view('admin.report.payment_log', compact('title', 'paymentLogs', 'paymentMethods'));
    }

    public function paymentDetail($id)
    {
        $title = "Payment Details";
        $paymentLog = PaymentLog::where('status', '!=', 0)->where('id', $id)->firstOrFail();
        return view('admin.report.payment_detail', compact('title', 'paymentLog'));
    }


    public function approve(Request $request)
    { 
        $request->validate(['id' => 'required|integer']);
        $general = GeneralSetting::first();
        $paymentData = PaymentLog::where('id',$request->id)->where('status',1)->firstOrFail();
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
        $notify[] = ['success', 'Payment has been approved.'];
        return back()->withNotify($notify);
    }

    public function reject(Request $request)
    {
        $request->validate(['id' => 'required|integer']);
        $paymentLog = PaymentLog::where('id',$request->id)->where('status',1)->firstOrFail();
        $paymentLog->status = 3;
        $paymentLog->save();
        $notify[] = ['success', 'Payment has been rejected.'];
        return back()->withNotify($notify);
    }



    public function paymentLogSearch(Request $request)
    { 
        $title = "Payment Log Search";
        $search = $request->search;
        $paymentMethod = $request->paymentMethod;
        $searchDate = $request->date;
        if ($search!="") {
            $paymentLogs = PaymentLog::OrWhere('trx_number','like',"%$search%")
                ->OrWhereHas('user', function($q) use ($search){
                $q->where('email','like',"%$search%");
            });
        }
        if ($paymentMethod!="") {
            $paymentLogs = PaymentLog::where('method_id', '=', "$paymentMethod");
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
                $paymentLogs = PaymentLog::whereDate('created_at',Carbon::parse($firstDate));
            }
            if ($lastDate){
                $paymentLogs = PaymentLog::whereDate('created_at','>=',Carbon::parse($firstDate))->whereDate('created_at','<=',Carbon::parse($lastDate));
            }
        }

        if ($search=="" && $searchDate=="" && $paymentMethod=="") {
            $notify[] = ['error','Search data field empty'];
            return back()->withNotify($notify);
        }

        $paymentLogs = $paymentLogs->where('status', '!=', 0)->orderBy('id','desc')->with('user','paymentGateway')->paginate(paginateNumber());
        $paymentMethods = PaymentMethod::where('status', 1)->get();
        return view('admin.report.payment_log', compact('title', 'paymentLogs', 'search', 'paymentMethods'));
    }

    public function subscription()
    {
        $title = "Subscription history";
        $pricingPlan = PricingPlan::where('status','=',1)->get();
        $subscriptions = Subscription::where('status', '!=', 0)->latest()->with('user', 'plan')->paginate(paginateNumber());
        return view('admin.report.subscription', compact('title', 'subscriptions', 'pricingPlan'));
    }

    public function subscriptionSearch(Request $request)
    {
        $title = "Subscription history search";
        $search = $request->search;
        $subsPlan = $request->subsPlan;
        $searchDate = $request->date;

        if ($search!="") {
            $subscriptions = Subscription::OrWhere('trx_number','like',"%$search%")
                ->OrWhereHas('user', function($q) use ($search){
                    $q->where('email','like',"%$search%");
                });
        }

        if ($subsPlan!="") {
            $subscriptions = Subscription::where('plan_id', '=', "$subsPlan");
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
                $subscriptions = Subscription::whereDate('created_at',Carbon::parse($firstDate));
            }
            if ($lastDate){
                $subscriptions = Subscription::whereDate('created_at','>=',Carbon::parse($firstDate))->whereDate('created_at','<=',Carbon::parse($lastDate));
            }
        }

        if ($search=="" && $searchDate=="" && $subsPlan=="") {
            $notify[] = ['error','Search data field empty'];
            return back()->withNotify($notify);
        }

 
        $pricingPlan = PricingPlan::where('status','=',1)->get();
        $subscriptions = $subscriptions->where('status', '!=', 0)->orderBy('id','desc')->with('user')->paginate(paginateNumber());
        return view('admin.report.subscription', compact('title', 'subscriptions', 'search', 'pricingPlan'));
    }
  
}
