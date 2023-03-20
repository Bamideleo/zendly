<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailConfiguration extends Model
{
    use HasFactory;

    protected $table = "mails";

    protected $fillable = [
     
        'name',
        'status', 
        'user_id', 
        'driver_information'
    ];
    protected $casts = [
        'driver_information' => 'object',
    ];
}
