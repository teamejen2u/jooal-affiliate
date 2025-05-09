<?php
// app/Models/UserMission.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'mission_id',
        'progress',
        'completed',
        'reward_claimed',
    ];

    protected $casts = [
        'progress' => 'decimal:2',
        'completed' => 'boolean',
        'reward_claimed' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }
}