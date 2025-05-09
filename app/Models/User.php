<?php

// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'profile_pic',
        'level',
        'xp_points',
        'earnings',
        'sales_count',
        'click_count',
        'conversion_rate',
        'rank',
        'referral_code',
        'joined_at',
        'payment_method',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'joined_at' => 'datetime',
        'earnings' => 'decimal:2',
        'conversion_rate' => 'decimal:2',
    ];

    public function missions()
    {
        return $this->belongsToMany(Mission::class, 'user_missions')
            ->withPivot('progress', 'completed', 'reward_claimed')
            ->withTimestamps();
    }

    public function affiliateLinks()
    {
        return $this->hasMany(AffiliateLink::class);
    }

    public function getActiveMissionsAttribute()
    {
        return $this->missions()->wherePivot('completed', false)->get();
    }

    public function getCompletedMissionsAttribute()
    {
        return $this->missions()->wherePivot('completed', true)->get();
    }

    public function getFormattedEarningsAttribute()
    {
        return 'RM' . number_format($this->earnings, 2);
    }
}