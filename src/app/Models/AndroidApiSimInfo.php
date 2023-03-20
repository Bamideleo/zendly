<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AndroidApiSimInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'android_gateway_id',
        'sim_number',
        'time_interval',
        'sms_remaining',
        'send_sms',
        'status'
    ];

    public function androidGatewayName()
    {
    	return $this->belongsTo(AndroidApi::class, 'android_gateway_id');
    }
}
