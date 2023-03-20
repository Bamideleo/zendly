<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;


    protected $casts = [
    	'frontend_section' => 'object',
    	's_login_google_info' => 'object',
    ];
}
