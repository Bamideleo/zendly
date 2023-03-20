<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\Currency;

class PaymentMethodController extends Controller
{
    
    public function index()
    {
        $title = "Payment methods";
        $paymentMethods = PaymentMethod::automaticMethod()->orderBy('id','ASC')->with('currency')->paginate(paginateNumber());
        return view('admin.payment.index', compact('title', 'paymentMethods'));
    }

    public function edit($slug,$id)
    {
        $title = "Payment method update";
        $paymentMethod = PaymentMethod::findOrFail($id);
        $currencies = Currency::latest()->get();
        return view('admin.payment.edit', compact('title', 'paymentMethod', 'currencies'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|in:1,2',
            'image' => 'nullable|image|mimes:jpg,png,jpeg',
        ]);
        $paymentMethod = PaymentMethod::findOrFail($id);
        $paymentMethod->currency_id = $request->currency_id;
        $paymentMethod->percent_charge = $request->percent_charge;
        $paymentMethod->rate = $request->rate;
        $paymentMethod->status = $request->status;
        $parameter = [];
        foreach ($paymentMethod->payment_parameter as $key => $value) {
            $parameter[$key] = $request->method[$key];
        }
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
        $notify[] = ['success', 'Payment method has been updated'];
        return back()->withNotify($notify);
    }
}
