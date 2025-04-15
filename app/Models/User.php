<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    
    protected $fillable = [
        'name',
        'last_name',
        'email',
        'phone',
        'password',
        'want_news',  // sms or email news
        'want_pro_membership', // interested in pro membership
        'bio', 
        'type', //  enum ['admin', 'editor', 'pro_member', 'team_member', 'user']
        'photo', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'want_news' => 'boolean',
            'want_pro_membership' => 'boolean', // Added missing cast for want_pro_membership
            'bio' => 'string',
            'type' => 'string',
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime', // Added cast for phone_verified_at
            'password' => 'hashed',
        ];
    }
}
