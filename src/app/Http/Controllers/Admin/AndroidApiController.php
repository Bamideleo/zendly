<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AndroidApi;
use App\Models\AndroidApiSimInfo;
use Illuminate\Support\Facades\Hash;

class AndroidApiController extends Controller
{
    public function index()
    {
    	$title = "Android Gateway list";
    	$androids = AndroidApi::orderBy('id', 'DESC')->paginate(paginateNumber());
    	return view('admin.android.index', compact('title', 'androids'));
    }

    public function store(Request $request)
    {
    	$data = $request->validate([
    		'name' => 'required',
    		'password' => 'required|confirmed',
    		'status' => 'required|in:1,2'
    	]);
    	AndroidApi::create([
    		'name' => $request->name,
            'show_password' => $request->password,
    		'password' =>  Hash::make($request->password),
    		'status' => $request->status,
    	]);
    	$notify[] = ['success', 'New Android Gateway has been created'];
    	return back()->withNotify($notify);
    }

    public function update(Request $request)
    {
    	$data = $request->validate([
    		'name' => 'required',
    		'password' => 'required',
    		'status' => 'required|in:1,2'
    	]);
    	$androidApi = AndroidApi::where('id', $request->id)->firstOrFail();
    	$androidApi->update([
    		'name' => $request->name,
            'show_password' => $request->password,
    		'password' => Hash::make($request->password),
    		'status' => $request->status,
    	]);
    	$notify[] = ['success', 'Android Gateway has been updated'];
    	return back()->withNotify($notify);
    }

    public function simList($id)
    {
    	$android = AndroidApi::findOrFail($id);
    	$title = ucfirst($android->name)." api gateway sim list";
    	$simLists = AndroidApiSimInfo::where('android_gateway_id', $android->id)->latest()->with('androidGatewayName')->paginate(paginateNumber());
    	return view('admin.android.sim', compact('title', 'android', 'simLists'));
    }

    public function delete(Request $request)
    {
        $android = AndroidApi::findOrFail($request->id);
        $simLists = AndroidApiSimInfo::where('android_gateway_id', $android->id)->delete();
        $android->delete();
        $notify[] = ['success', 'Android Gateway has been deleted'];
        return back()->withNotify($notify);
    }

    public function simNumberDelete(Request $request)
    {
        $simLists = AndroidApiSimInfo::where('id', $request->id)->delete();
        $notify[] = ['success', 'Android Gateway sim has been deleted'];
        return back()->withNotify($notify);
    }
}
