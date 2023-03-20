<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email_group_id',
        'email',
        'name',
        'status'
    ];

    public function emailGroup()
    {
    	return $this->belongsTo(EmailGroup::class, 'email_group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
