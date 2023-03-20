<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Transaction;
use App\Models\SMSlog;
use App\Models\Group;
use App\Models\Contact;
use App\Models\Template;
use App\Models\CreditLog;
use App\Models\EmailLog;
use App\Models\EmailCreditLog;
use App\Models\PaymentMethod;
use App\Models\WhatsappLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function dashboard()
    {
        $title = "User dashboard";
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)->orderBy('id', 'DESC')->take(10)->get();
        $credits = CreditLog::where('user_id', $user->id)->with('user')->orderBy('id', 'DESC')->take(10)->get();

        $smslog['all'] = SMSlog::where('user_id', $user->id)->count();
        $smslog['success'] = SMSlog::where('user_id', $user->id)->where('status', SMSlog::SUCCESS)->count();
        $smslog['pending'] = SMSlog::where('user_id', $user->id)->where('status', SMSlog::PENDING)->count();
        $smslog['fail'] = SMSlog::where('user_id', $user->id)->where('status', SMSlog::FAILED)->count();

        $emailLog['all'] = EmailLog::where('user_id', $user->id)->count();
        $emailLog['success'] = EmailLog::where('user_id', $user->id)->where('status', EmailLog::SUCCESS)->count();
        $emailLog['pending'] = EmailLog::where('user_id', $user->id)->where('status', EmailLog::PENDING)->count();
        $emailLog['fail'] = EmailLog::where('user_id', $user->id)->where('status', EmailLog::FAILED)->count();

        $whatsappLog['all'] = WhatsappLog::where('user_id', $user->id)->count();
        $whatsappLog['success'] = WhatsappLog::where('user_id', $user->id)->where('status', WhatsappLog::SUCCESS)->count();
        $whatsappLog['pending'] = WhatsappLog::where('user_id', $user->id)->where('status', WhatsappLog::PENDING)->count();
        $whatsappLog['fail'] = WhatsappLog::where('user_id', $user->id)->where('status', WhatsappLog::FAILED)->count();
        
        $smsReport['month'] = collect([]);
        $smsReport['month_sms'] = collect([]);
        $smsReportMonths = SMSlog::where('user_id', $user->id)->where('status', SMSlog::SUCCESS)->selectRaw(DB::raw('count(*) as sms_count'))
            ->selectRaw("DATE_FORMAT(created_at,'%M') as months")
            ->groupBy('months')->get();

        $smsReportMonths->map(function ($query) use ($smsReport){
            $smsReport['month']->push($query->months);
            $smsReport['month_sms']->push($query->sms_count);
        });
        return view('user.dashboard', compact('title', 'smsReport', 'smslog', 'user', 'emailLog', 'transactions', 'credits', 'whatsappLog'));
    }

    public function profile()
    {
        $title = "User Profile";
        $user = auth()->user();
        return view('user.profile', compact('title', 'user'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'name' => 'nullable',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
            'address' => 'nullable|max:250',
            'city' => 'nullable|max:250',
            'state' => 'nullable|max:250',
            'zip' => 'nullable|max:250',
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        $address = [
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip
        ];
        $user->address = $address;
        if($request->hasFile('image')) {
            try {
                $removefile = $user->image ?: null;
                $user->image = StoreImage($request->image, filePath()['profile']['user']['path'], filePath()['profile']['user']['size'], $removefile);
            }catch (\Exception $exp){
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
        $user->save();
        $notify[] = ['success', 'Your profile has been updated.'];
        return redirect()->route('user.profile')->withNotify($notify);
    }

    public function password()
    {
        $title = "Password Update";
        return view('user.password', compact('title'));
    }

    public function passwordUpdate(Request $request)
    {
    	$this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);
        $user = auth()->user();
        if($user->password){
            if(!Hash::check($request->current_password, $user->password)) {
                $notify[] = ['error', 'The password doesn\'t match!'];
                return back()->withNotify($notify);
            }
            $user->password = Hash::make($request->password);
            $user->save();
            
        }else{
            $user->password = Hash::make($request->password);
            $user->save();
        }
        $notify[] = ['success', 'Password has been updated'];
        return back()->withNotify($notify);
    }


    public function transaction()
    {
        $title = "Transaction Log";
        $user = Auth::user();
        $paymentMethods = PaymentMethod::where('status', 1)->get();
        $transactions = Transaction::where('user_id', $user->id)->latest()->paginate(paginateNumber());
        return view('user.transaction', compact('title', 'transactions', 'paymentMethods'));
    }


    public function credit()
    {
        $title = "SMS Credit Log";
        $user = Auth::user();
        $credits = CreditLog::where('user_id', $user->id)->with('user')->latest()->paginate(paginateNumber());
        return view('user.credit', compact('title', 'credits'));
    }

    public function creditSearch(Request $request)
    {
        $title = "SMS Credit Search";
        $user = Auth::user();

        $search = $request->search;
        $searchDate = $request->date;

        if ($search!="") {
            $credits = CreditLog::where('user_id', $user->id)->where('trx_number', 'like', "%$search%");
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
                $credits = CreditLog::where('user_id', $user->id)->whereDate('created_at',Carbon::parse($firstDate));
            }
            if ($lastDate){
                $credits = CreditLog::where('user_id', $user->id)->whereDate('created_at','>=',Carbon::parse($firstDate))->whereDate('created_at','<=',Carbon::parse($lastDate));
            } 
        }

        if ($search=="" && $searchDate==""){
            $notify[] = ['error','Please give any search filter data'];
            return back()->withNotify($notify);
        }
        
        $credits = $credits->with('user')->paginate(paginateNumber());
        return view('user.credit', compact('title', 'credits', 'search', 'searchDate'));
    }


    public function emailCredit()
    {
        $title = "Email Credit Log";
        $user = Auth::user();
        $emailCredits = EmailCreditLog::where('user_id', $user->id)->latest()->paginate(paginateNumber());
        return view('user.email_credit', compact('title', 'emailCredits'));
    }

    public function emailCreditSearch(Request $request)
    { 
        $title = "Email Credit Search";
        $search = $request->search;
        $searchDate = $request->date;
        $user = Auth::user();
        if ($search!="") {
            $emailCredits = EmailCreditLog::where('user_id', $user->id)->where('trx_number', 'like', "%$search%");
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
                $emailCredits = EmailCreditLog::where('user_id', $user->id)->whereDate('created_at',Carbon::parse($firstDate));
            }
            if ($lastDate){
                $emailCredits = EmailCreditLog::where('user_id', $user->id)->whereDate('created_at','>=',Carbon::parse($firstDate))->whereDate('created_at','<=',Carbon::parse($lastDate));
            } 
        }

        if ($search=="" && $searchDate==""){
            $notify[] = ['error','Please give any search filter data'];
            return back()->withNotify($notify);
        }

        $emailCredits = $emailCredits->paginate(paginateNumber());
        return view('user.email_credit', compact('title', 'emailCredits', 'search'));
    }

    public function transactionSearch(Request $request)
    {
        $title = "Transaction Log Search";
        $search = $request->search;
        $paymentMethod = $request->paymentMethod;
        $searchDate = $request->date;

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
                $transactions = Transaction::where('user_id', $user->id)->whereDate('created_at',Carbon::parse($firstDate));
            }
            if ($lastDate){
                $transactions = Transaction::where('user_id', $user->id)->whereDate('created_at','>=',Carbon::parse($firstDate))->whereDate('created_at','<=',Carbon::parse($lastDate));
            } 
        }

        $user = Auth::user();
        $paymentMethods = PaymentMethod::where('status', 1)->get();
        
        if ($search!="") {
            $transactions = Transaction::where('user_id', $user->id)->where('transaction_number', 'like', "%$search%");
        }

        if ($paymentMethod!="") {
            $transactions = Transaction::where('user_id', $user->id)->where('payment_method_id', '=', "$paymentMethod");
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
                $transactions = Transaction::where('user_id', $user->id)->whereDate('created_at',Carbon::parse($firstDate));
            }
            if ($lastDate){
                $transactions = Transaction::where('user_id', $user->id)->whereDate('created_at','>=',Carbon::parse($firstDate))->whereDate('created_at','<=',Carbon::parse($lastDate));
            } 
        }

        if ($searchDate=="" && $paymentMethod=="" &&  $search=="") {
            $notify[] = ['error','Please give any search filter data'];
                return back()->withNotify($notify);
        }

        $transactions = $transactions->paginate(paginateNumber());

        return view('user.transaction', compact('title', 'transactions', 'paymentMethods', 'search', 'searchDate', 'paymentMethod'));
    }

}
