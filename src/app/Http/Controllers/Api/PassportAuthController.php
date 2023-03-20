<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AndroidApi;
use Illuminate\Support\Facades\Auth;

class PassportAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'name' => $request->name,
            'password' => $request->password
        ];
        if(Auth::guard('android_api')->attempt($credentials)) {
        	$token = Auth::guard('android_api')->user()->createToken('bluk_sms_token')->accessToken;
            return response()->json([
                'status' => true,
            	'token' => $token,
            	'android_gateway_id' => Auth::guard('android_api')->user()->id,
            ],200);
        }else{
        	return response()->json([
                'status' => false,
                'error' => 'Invalid android gateway name and password.'
            ],200);
        }
    }  
}
