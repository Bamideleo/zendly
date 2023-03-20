<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    const PLUS = '+';
    const MINUS = "-"; 

    protected $fillable = [
        'seller_id', 'user_id', 'payment_method_id', 'amount', 'post_balance', 'transaction_type', 'transaction_number', 'details'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
