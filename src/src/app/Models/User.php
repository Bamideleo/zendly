<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'status',
        'phone',
        'password',
        'google_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'address' => 'object'
    ];


    public function scopeUnverified($query)
    {
        return $query->where('status', 3);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeBanned($query)
    {
        return $query->where('status', 2);
    }

    public function ticket()
    {
        return $this->hasMany(SupportTicket::class, 'user_id');
    }

    public function group()
    {
        return $this->hasMany(Group::class, 'user_id');
    }

    public function emailGroup()
    {
        return $this->hasMany(EmailGroup::class, 'user_id');
    }

    public function contact()
    {
        return $this->hasMany(Contact::class, 'user_id');
    }

    public function emailContact()
    {
        return $this->hasMany(EmailContact::class, 'user_id');
    }


    public function template()
    {
        return $this->hasMany(Template::class, 'user_id')->latest();
    }
}
