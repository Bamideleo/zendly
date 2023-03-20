<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Contact;
use App\Models\User;
use App\Models\GeneralSetting;
use App\Models\Template;
use App\Models\EmailContact;
use App\Models\Transaction;
use App\Models\PricingPlan;
use App\Models\SmsGateway;
use App\Models\Subscription;
use App\Models\SMSlog;
use App\Models\EmailLog;
use App\Models\AndroidApi;
use App\Models\PaymentLog;
use App\Models\CreditLog;
use App\Models\WhatsappLog;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $title = "Admin Dashboard";
        $customers = User::where('status','!=','3')->orderBy('id', 'DESC')->take(10)->get();
        $paymentLogs = PaymentLog::orderBy('id', 'DESC')->where('status', '!=', 0)->with('user', 'paymentGateway','paymentGateway.currency')->take(10)->get();
        
        $phonebook['android_api'] = AndroidApi::count();
        $phonebook['payment_log'] = PaymentLog::where('status', PaymentLog::SUCCESS)->count();
        $phonebook['payment_amount'] = PaymentLog::where('status', PaymentLog::SUCCESS)->sum('amount');
        $phonebook['payment_amount_charge'] = PaymentLog::where('status', PaymentLog::SUCCESS)->sum('charge');
        $phonebook['subscription_amount'] = Subscription::where('status', '!=', 0)->sum('amount');
        $phonebook['transaction'] = Transaction::count();
        $phonebook['credit_log'] = CreditLog::count();

        $phonebook['user'] = User::count();
        $phonebook['plan'] = PricingPlan::count();
        $phonebook['sms_gateway'] = SmsGateway::count();
        $phonebook['contact'] = Contact::count();
        $phonebook['email_contact'] = EmailContact::count();
        $phonebook['subscription'] = Subscription::where('status', '!=', 0)->count();

        $smslog['all'] = SMSlog::count();
        $smslog['success'] = SMSlog::where('status',SMSlog::SUCCESS)->count();
        $smslog['pending'] = SMSlog::where('status',SMSlog::PENDING)->count();

        $emailLog['all'] = EmailLog::count();
        $emailLog['success'] = EmailLog::where('status',EmailLog::SUCCESS)->count();
        $emailLog['pending'] = EmailLog::where('status',EmailLog::PENDING)->count();

        $whatsappLog['all'] = WhatsappLog::count();
        $whatsappLog['success'] = WhatsappLog::where('status',WhatsappLog::SUCCESS)->count();
        $whatsappLog['pending'] = WhatsappLog::where('status',WhatsappLog::PENDING)->count();

        $smsReport['month'] = collect([]);
        $smsReport['month_sms'] = collect([]);
        $smsReportMonths = SMSlog::where('status', SMSlog::SUCCESS)->selectRaw(DB::raw('count(*) as sms_count'))
            ->selectRaw("DATE_FORMAT(created_at,'%M %Y') as months")
            ->groupBy('months')->get();

        $smsReportMonths->map(function ($query) use ($smsReport){
            $smsReport['month']->push($query->months);
            $smsReport['month_sms']->push($query->sms_count);
        });
        return view('admin.dashboard', compact('title','phonebook','smslog', 'smsReport', 'emailLog', 'customers', 'paymentLogs', 'whatsappLog'));
    }
    
    public function profile()
    {
        $title = "Admin Profile";
        $admin = auth()->guard('admin')->user();
        return view('admin.profile', compact('title', 'admin'));
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
        ]);
        
        $admin = Auth::guard('admin')->user();
        $admin->name = $request->name;
        $admin->username = $request->username;
        $admin->email = $request->email;
        
        if($request->hasFile('image')){
            try{
                $removefile = $admin->image ?: null;
                $admin->image = StoreImage($request->image, filePath()['profile']['admin']['path'], filePath()['profile']['admin']['size'], $removefile);
            }catch (\Exception $exp){
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
        $admin->save();
        $notify[] = ['success', 'Your profile has been updated.'];
        return redirect()->route('admin.profile')->withNotify($notify);
    }

    public function password()
    {
        $title = "Password Update";
        return view('admin.password', compact('title'));
    }

    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:5|confirmed',
        ]);
        $admin = Auth::guard('admin')->user();
        if (!Hash::check($request->current_password, $admin->password)) {
            $notify[] = ['error', 'Password do not match !!'];
            return back()->withNotify($notify);
        }
        $admin->password = Hash::make($request->password);
        $admin->save();
        $notify[] = ['success', 'Password changed successfully.'];
        return redirect()->route('admin.password')->withNotify($notify);
    }
}
