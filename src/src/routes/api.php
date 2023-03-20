<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Api\PassportAuthController;
use App\Http\Controllers\Api\ManageSMSController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('login', [PassportAuthController::class, 'login']);
Route::get('init', [ManageSMSController::class, 'init']);

Route::middleware('auth:api')->group(function () {
    Route::post('sim/update', [ManageSMSController::class, 'simInfo']);
    Route::post('sms/logs', [ManageSMSController::class, 'smsfind']);
    Route::post('sms/status/update', [ManageSMSController::class, 'smsStatusUpdate']);
    Route::post('sim/status/update', [ManageSMSController::class, 'simClosed']);
});
