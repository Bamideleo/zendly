<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway_code',
        'name',
        'type', 
        'status', 
        'user_id', 
        'credential'
    ];
    protected $casts = [
        'credential' => 'object'
    ];
}
