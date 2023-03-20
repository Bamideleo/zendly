<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;


    protected $casts = [
        'payment_parameter' => 'object'
    ];


    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }


    public function scopeManualMethod()
    {
        return $this->where('unique_code','LIKE','%MANUAL%');
    }

    public function scopeAutomaticMethod()
    {
        return $this->where('unique_code','NOT LIKE','%MANUAL%');
    }
}
