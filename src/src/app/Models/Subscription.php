<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
    	'plan_id',
    	'expired_date',
    	'trx_number',
    	'amount',
    	'status'
    ];

    protected $dates = ['created_at', 'updated_at', 'expired_date'];

    public function plan()
    {
    	return $this->belongsTo(PricingPlan::class, 'plan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
