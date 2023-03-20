<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PricingPlan;
use App\Models\PaymentMethod;
use App\Models\Subscription;
use Carbon\Carbon;
use App\Http\Utility\PaymentInsert;
use App\Models\PaymentLog;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{

    public function create()
    {
    	$title = "All Plan";
    	$plans = PricingPlan::where('status', 1)->where('amount', '>=','1')->orderBy('amount', 'ASC')->get();
    	$paymentMethods = PaymentMethod::where('status', 1)->get();
        $user = Auth::user();
        $subscription = Subscription::where('user_id', $user->id)->where('status', '!=', 0)->first();
    	return view('user.plan.create',compact('title', 'plans', 'paymentMethods', 'subscription'));
    }

    public function store(Request $request)
    {
    	$data =$request->validate([
    		'id' => 'required|exists:pricing_plans,id',
    		'payment_gateway' => 'required|exists:payment_methods,id',
    	]); 

    	$user = Auth::user();
        PaymentLog::where('user_id',$user->id)->where('status', 0)->delete();
        Subscription::where('user_id',$user->id)->where('status', 0)->delete();
    	$plan = PricingPlan::where('id', $request->id)->where('status', 1)->firstOrFail();
        $subscription = Subscription::where('user_id', $user->id)->where('status', '!=', 0)->first();
        if($subscription){
            $subscription->plan_id = $plan->id;
            $subscription->amount = $plan->amount;
            $subscription->expired_date  = $subscription->expired_date->addDays($subscription->plan->duration);
            $subscription->save();
        }else{
            $subscription = Subscription::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'expired_date' => Carbon::now()->addDays($plan->duration),
                'amount' =>$plan->amount,
                'trx_number' =>trxNumber(),
                'status' => 0,
            ]);
        }
    	session()->put('subscription_id', $subscription->id);
    	$paymentMethod = PaymentMethod::where('id', $request->payment_gateway)->where('status', 1)->first();
        PaymentInsert::paymentCreate($paymentMethod->unique_code );
        return redirect()->route('user.payment.preview');
    }

    public function subscription()
    {
        $title = "Current Subscription Plan";
        $user = Auth::user();
        $paymentMethods = PaymentMethod::where('status', 1)->get();
        $subscriptions  = Subscription::where('user_id', $user->id)->orderBy('status', 'ASC')->where('status', '!=', 0)->with('plan')->paginate(paginateNumber());
        return view('user.subscription', compact('title', 'subscriptions', 'paymentMethods'));
    }

    public function subscriptionRenew(Request $request)
    {
        $user = auth()->user();
        $subscriptionPlan = Subscription::where('id', $request->id)->where('user_id', $user->id)->firstOrFail();
        session()->put('subscription_id', $subscriptionPlan->id);
        $paymentMethod = PaymentMethod::where('id', $request->payment_gateway)->where('status', 1)->first();
        PaymentInsert::paymentCreate($paymentMethod->unique_code);
        return redirect()->route('user.payment.preview');
    }
}
