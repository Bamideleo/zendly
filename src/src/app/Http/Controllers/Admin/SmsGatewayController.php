<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SmsGateway;
use App\Models\GeneralSetting;

class SmsGatewayController extends Controller
{
    
    public function index()
    {
    	$title = "SMS API Gateway list";
    	$smsGateways = SmsGateway::orderBy('id','asc')->paginate(paginateNumber());
    	return view('admin.sms_gateway.index', compact('title', 'smsGateways'));
    }

    public function edit($id)
    {
    	$title = "SMS API Gateway update";
    	$smsGateway = SmsGateway::findOrFail($id);
    	return view('admin.sms_gateway.edit', compact('title', 'smsGateway'));
    }

    public function update(Request $request, $id)
    {
    	 $this->validate($request, [
            'status' => 'required|in:1,2',
        ]);
    	$smsGateway = SmsGateway::findOrFail($id);
    	$parameter = [];
        foreach ($smsGateway->credential as $key => $value) {
            $parameter[$key] = $request->sms_method[$key];
        }
        $smsGateway->credential = $parameter;
        $smsGateway->status = $request->status;
        $smsGateway->save();
        $notify[] = ['success', 'SMS Gateway has been updated'];
        return back()->withNotify($notify);
    }


    public function defaultGateway(Request $request)
    {
    	$smsGateway = SmsGateway::findOrFail($request->sms_gateway);
    	$setting = GeneralSetting::first();
    	$setting->sms_gateway_id = $smsGateway->id;
    	$setting->save();
    	$notify[] = ['success', 'Default SMS Gateway has been updated'];
        return back()->withNotify($notify);
    }
}
