<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\Currency;

class ManualPaymentGatewayController extends Controller
{
    
    public function index()
    {
        $title = "Manual Payment methods";
        $manulaPayments = PaymentMethod::manualMethod()->orderBy('id','ASC')->with('currency')->paginate(paginateNumber());
        return view('admin.manula_payment.index', compact('title', 'manulaPayments'));
    }

    public function create()
    {
        $title = "Manual payment method create";
        $currencies = Currency::latest()->get();
        return view('admin.manula_payment.create', compact('title', 'currencies'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'status' => 'required|in:1,2',
            'image' => 'required|image|mimes:jpg,png,jpeg',
        ]);
        $new_code = "500";
        $paymentMethodLog = PaymentMethod::manualMethod()->orderBy('unique_code','DESC')->limit(1)->first();
        if ($paymentMethodLog!=null) { 
            $new_code = (substr($paymentMethodLog->unique_code,6,3)+1);
        }
        $paymentMethod = new PaymentMethod();
        $paymentMethod->name = $request->name;
        $paymentMethod->currency_id = $request->currency_id;
        $paymentMethod->percent_charge = $request->percent_charge;
        $paymentMethod->rate = $request->rate;
        $paymentMethod->status = $request->status;
        $parameter = [];
        if($request->has('field_name')){
            for($i=0; $i<count($request->field_name); $i++){
                $array = [];
                $array['field_label'] = $request->field_name[$i];
                $array['field_name'] = strtolower(str_replace(' ', '_', $request->field_name[$i]));
                $array['field_type'] = $request->field_type[$i]; 
                $parameter[$array['field_name']] = $array;
            }
        }

        $array_push = []; 
        if ($request->payment_gw_info) {
            $array_push['payment_gw_info'] = $request->payment_gw_info;
        }else{ 
            $array_push['payment_gw_info'] = "";
        }  
        array_push($parameter,$array_push);
         
        $paymentMethod->payment_parameter = $parameter;
        if($request->hasFile('image')){
            try {
                $paymentMethod->image = StoreImage($request->image, filePath()['payment_method']['path'], filePath()['payment_method']['size'], $paymentMethod->image ?: null);
            }catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        }
        $paymentMethod->unique_code = "MANUAL".$new_code;
        $paymentMethod->save();
        $notify[] = ['success', 'Manual payment method has been create'];
        return back()->withNotify($notify);
    }


    public function edit($id)
    {
        $title = "Manual payment method update";
        $currencies = Currency::latest()->get();
        $manulaPayment = PaymentMethod::manualMethod()->where('id', $id)->firstOrFail();
        return view('admin.manula_payment.edit', compact('title', 'currencies', 'manulaPayment'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|in:1,2',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
        ]);
        $paymentMethod =  PaymentMethod::findOrFail($id);
        $paymentMethod->name = $request->name;
        $paymentMethod->currency_id = $request->currency_id;
        $paymentMethod->percent_charge = $request->percent_charge;
        $paymentMethod->rate = $request->rate;
        $paymentMethod->status = $request->status;
        $parameter = [];
        if($request->has('field_name')){
            for($i=0; $i<count($request->field_name); $i++){
                $array = [];
                $array['field_label'] = $request->field_name[$i];
                $array['field_name'] = strtolower(str_replace(' ', '_', $request->field_name[$i]));
                $array['field_type'] = $request->field_type[$i];
                $parameter[$array['field_name']] = $array;
            }
        }
        $array_push = []; 
        if ($request->payment_gw_info) {
            $array_push['payment_gw_info'] = $request->payment_gw_info;
        }else{
            $array_push['payment_gw_info'] = "";  
        }
        array_push($parameter,$array_push);
        $paymentMethod->payment_parameter = $parameter;
        if($request->hasFile('image')){
            try {
                $paymentMethod->image = StoreImage($request->image, filePath()['payment_method']['path'], filePath()['payment_method']['size'], $paymentMethod->image ?: null);
            }catch (\Exception $exp) {
                $notify[] = ['error', 'Image could not be uploaded.'];
                return back()->withNotify($notify);
            }
        } 
        $paymentMethod->save();
        $notify[] = ['success', 'Manual payment method has been create'];
        return back()->withNotify($notify);
    }

    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]); 
        $del_method = PaymentMethod::findOrFail($request->id);
        $iconfile = filePath()['payment_method']['path']."/".$del_method->image;
        unlink($iconfile);
        $notify[] = ['success', "Manual Payment Method Data Removed"];
        $del_method->delete();
        $notify[] = ['success', "Manual Payment Method Removed"];
        return back()->withNotify($notify);
    }
}
