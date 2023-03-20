<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSlog extends Model
{
    use HasFactory;

	const PENDING = 1;
	const SCHEDULE = 2;
	const FAILED = 3;
	const SUCCESS = 4;
	const PROCESSING = 5;


	public function user()
	{
		return $this->belongsTo(User::class, 'user_id');
	}

	public function smsGateway()
	{
		return $this->belongsTo(SmsGateway::class, 'api_gateway_id');
	}

	public function androidGateway()
	{
		return $this->belongsTo(AndroidApiSimInfo::class, 'android_gateway_sim_id');
	}


}
