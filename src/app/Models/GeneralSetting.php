<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;

    protected $fillable = [
            'site_name',
            'phone',
            'country_code',
            'sms_gateway',
            'currency_name',
            'currency_symbol',
            'sms_gateway_id',
            'email_gateway_id',
            'mail_from',
            'email_template',
            's_login_google_info',
            'frontend_section',
            'registration_status',
            'cron_job_run',
            'plan_id',
            'sign_up_bonus',
            'debug_mode',
            'maintenance_mode',
            'maintenance_mode_message',
            'schedule_at',
            'user_id',
    ];
    protected $casts = [
    	'frontend_section' => 'object',
    	's_login_google_info' => 'object',
    ];
}
