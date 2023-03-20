<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'credit', 
        'email_credit', 
        'whatsapp_credit', 
        'duration',
        'status',
        'recommended_status'
    ];

}
